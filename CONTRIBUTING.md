# Contributing to Gelink

## About
Gelink is a URL shortener service built with Laravel and React (via Inertia.js). It allows both anonymous and authenticated users to create shortened URLs, with additional management features for registered users.

## Project Architecture

### Backend (Laravel)
- Database: PostgreSQL 
- Authentication: Laravel's built-in auth with session-based authentication
- Main components:
  - Controllers: `app/Http/Controllers/`
  - Models: `app/Models/`
  - Database migrations: `database/migrations/`

### Frontend (React + TypeScript)
- Uses Inertia.js for server-side rendering
- Components located in `resources/js/components/`
- Pages in `resources/js/pages/`
- TypeScript types in `resources/js/types/`

## Getting Started

1. Copy `.env.example` to `.env` and configure:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=gelink
   DB_USERNAME=gelink
   DB_PASSWORD=your_password
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up database:
   ```bash
   php artisan migrate
   ```

4. Start development servers:
   ```bash
   # Terminal 1: Laravel
   php artisan serve
   
   # Terminal 2: Vite (Frontend)
   npm run dev
   ```

## Development Workflow

### Database Changes
1. Create migration: `php artisan make:migration create_xyz_table`
2. Update migration file in `database/migrations/`
3. Run: `php artisan migrate`

### Adding New Features
1. Backend:
   - Add routes in `routes/web.php` or `routes/auth.php`
   - Create controller in `app/Http/Controllers/`
   - Add model in `app/Models/` if needed
   
2. Frontend:
   - Add page in `resources/js/pages/`
   - Create components in `resources/js/components/`
   - Define types in `resources/js/types/`

## Testing
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

## Architecture Decisions

### URL Shortening
- Short codes are stored in `links` table
- Anonymous links have `user_id = null`
- Authentication middleware protects user-specific routes
