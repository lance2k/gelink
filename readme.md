## Folder Structure

app/
    Actions/            # Encapsulate domain-specific actions (e.g., CreatePost, UpdateProfile)
    Http/
        Controllers/    # Handle HTTP requests, call services/actions, return responses
        Middleware/     # Filter/modify HTTP requests (e.g., auth, CORS)
        Requests/       # Form request validation logic
        Resources/      # Transform models/data for API or frontend
    Models/              # Eloquent models representing database tables
    Services/           # Business logic/services (e.g., payment, notifications)
    Policies/           # Authorization logic for models/resources
    Providers/          # Service providers for bootstrapping app services
bootstrap/              # App bootstrap files (e.g., app.php, cache)
config/                 # Configuration files (database, mail, queue, etc.)
database/
    factories/          # Model factories for seeding/testing
    migrations/         # Database schema migrations
    seeders/            # Database seeders for test/demo data
public/                 # Web server root; index.php, assets (images, js, css)
resources/
    js/
        components/     # Reusable React components (buttons, forms, etc.)
        pages/          # Top-level React pages/views (route targets)
        layouts/        # Shared React layouts (wrappers, navbars)
        hooks/          # Custom React hooks (useAuth, useForm, etc.)
        utils/          # Utility/helper functions for React code
        App.tsx         # Main React app component
        main.tsx        # React entry point (bootstraps app)
        types/          # TypeScript types/interfaces for React code
    css/                # CSS/SCSS files for frontend styling
    views/              # Blade templates (emails, error pages, etc.)
routes/
    web.php             # Web routes (controllers, Inertia pages)
storage/                # Logs, compiled views, file uploads, cache
tests/
    Feature/            # Feature tests (HTTP, integration)
    Unit/               # Unit tests (services, models)
    Dusk/               # Browser/end-to-end tests (Laravel Dusk)
lang/                   # Localization files (translations)