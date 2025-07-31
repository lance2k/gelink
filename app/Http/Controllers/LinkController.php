<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

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

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'url' => 'required|url|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        try {
            $link = auth()->user()->links()->create([
                ...$data,
                'short_code' => $this->generateUniqueShortCode(),
                'is_custom' => false
            ]);

            return redirect()
                ->route('links.show', $link->id)
                ->with('success', 'Link created successfully.');
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
}
