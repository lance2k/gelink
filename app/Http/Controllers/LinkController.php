<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Link;

class LinkController extends Controller
{
    public function index(Request $request): Response
    {
        $user = auth()->user();
        $links = $user ? $user->links()
            ->latest()
            ->paginate(10) : collect();

        return Inertia::render('Links/Index', [
            'links' => $links,
        ]);
    }

    public function show(int $id): Response
    {
        $link = auth()->user()?->links()
            ->with(['visits' => fn($query) => $query->latest()])
            ->findOrFail($id);

        return Inertia::render('Links/Show', [
            'link' => $link,
            'stats' => [
                'total_visits' => $link->visits->count(),
                'recent_visits' => $link->visits->take(10)
            ]
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Links/Create');
    }

    private function generateShortCode(): string 
    {
        do {
            $code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
        } while (Link::where('short_code', $code)->exists());
        
        return $code;
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'longUrl' => 'required|url|max:2048',
            'customizedLink' => 'nullable|string|min:3|max:20|alpha_dash|unique:links,short_code',
        ]);

        try {
            $short_code = $data['customizedLink'] ?? $this->generateShortCode();
            
            $link = new Link([
                'long_url' => $data['longUrl'],
                'short_code' => $short_code,
                'is_custom' => !empty($data['customizedLink'])
            ]);

            if (auth()->check()) {
                $link->user()->associate(auth()->user());
            }

            $link->save();

            return back()->with([
                'success' => true,
                'shortUrl' => route('links.redirect', $short_code)
            ]);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to create link.'])
                ->withInput();
        }
    }

    public function edit(int $id): Response
    {
        $link = auth()->user()?->links()->findOrFail($id);

        return Inertia::render('Links/Edit', [
            'link' => $link,
        ]);
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $link = auth()->user()?->links()->findOrFail($id);

        try {
            $data = $request->validate([
                'url' => 'required|url|max:2048',
                'title' => 'nullable|string|max:255',
            ]);

            $link->update($data);

            return redirect()
                ->route('links.show', $link->id)
                ->with('success', 'Link updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to update link.'])
                ->withInput();
        }
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        try {
            $link = auth()->user()?->links()->findOrFail($id);
            $link->delete();

            return redirect()
                ->route('links.index')
                ->with('success', 'Link deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete link.']);
        }
    }
    public function redirect(string $code): \Illuminate\Http\RedirectResponse
    {
        $link = Link::where('short_code', $code)->firstOrFail();

        // Record visit
        $link->visits()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect($link->long_url);
    }
}
