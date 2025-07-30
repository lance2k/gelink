# AI Agent Guide for Gelink

## Project Overview
Gelink is a URL shortener service built with Laravel (PHP) and React+TypeScript. The application allows both anonymous and authenticated users to create shortened URLs, with additional management capabilities for registered users.

## Key Technical Context

### Architecture
- **Backend**: Laravel 10+ with PostgreSQL
- **Frontend**: React 18+ with TypeScript, using Inertia.js for SSR
- **Authentication**: Session-based using Laravel's built-in auth
- **Database**: PostgreSQL with TimestampTz for proper timezone handling

### Important Patterns
1. **Route Organization**:
   - Web routes in `routes/web.php`
   - Auth routes in `routes/auth.php`
   - Settings routes in `routes/settings.php`

2. **Controller Structure**:
   - Regular controllers extend base `App\Http\Controllers\Controller`
   - Auth controllers in `App\Http\Controllers\Auth\`
   - Settings controllers in `App\Http\Controllers\Settings\`

3. **Model Relations**:
   - Links belong to optional User (`user_id` can be null)
   - Users can have many Links

4. **Frontend Patterns**:
   - Pages in `resources/js/pages/` correspond to routes
   - Components in `resources/js/components/` for reuse
   - Use TypeScript types from `resources/js/types/`

### Key Files
- **URL Shortening**: `database/migrations/2025_07_14_123749_create_links_table.php`
- **Authentication**: `routes/auth.php`, `app/Http/Controllers/Auth/*`
- **User Model**: `app/Models/User.php`
- **Main Routes**: `routes/web.php`

### Code Conventions
1. **Database**:
   - Use TimestampTz for timestamps (PostgreSQL)
   - Foreign keys should specify onDelete behavior
   - Unique constraints on important fields (e.g., `short_code`)

2. **Controllers**:
   - Return Inertia responses for web pages
   - Use type hints and return types
   - Validate input using Form Request classes

3. **Models**:
   - Define `protected $fillable` for mass assignment
   - Use proper type hints for properties
   - Define relationships using methods

## Common Operations

### Adding Features
1. Create migration if needed: `php artisan make:migration`
2. Add routes in appropriate routes file
3. Create controller with type-safe methods
4. Add React components in `resources/js/`
5. Update TypeScript types as needed

### Testing
- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`
- Run: `php artisan test`

### Development
1. Start Laravel: `php artisan serve`
2. Start Vite: `npm run dev`
3. Watch logs: `tail -f storage/logs/laravel.log`
