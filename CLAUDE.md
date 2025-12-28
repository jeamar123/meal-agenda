# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 10 + Vue 3 meal planning application using Inertia.js for full-stack reactivity. The backend implements a modular monolith pattern, while the frontend uses modern Vue 3 with Composition API, Tailwind CSS 4, and Vite for building.

**Tech Stack:**
- Backend: Laravel 10 (PHP 8.1+), Laravel Sanctum (API auth)
- Frontend: Vue 3, Inertia.js, Vue Router 4, Vuex 4
- Build: Vite 7
- Styling: Tailwind CSS 4, SCSS
- Key Packages: Spatie permissions, Spatie activity log, Ziggy (route helpers)

## Essential Commands

### Initial Setup
```bash
composer install              # Install PHP dependencies
npm install                   # Install JavaScript dependencies
cp .env.example .env         # Create environment file
php artisan key:generate     # Generate application key
php artisan migrate          # Run database migrations
```

### Development
```bash
npm run dev                  # Start Vite dev server with hot reload
php artisan serve           # Start Laravel development server (default: http://localhost:8000)
```

### Testing
```bash
php artisan test            # Run all PHPUnit tests
vendor/bin/phpunit          # Run PHPUnit directly
vendor/bin/phpunit tests/Feature/ExampleTest.php  # Run specific test file
```

### Production Build
```bash
npm run build               # Build frontend assets for production
php artisan optimize        # Optimize Laravel for production
```

## Architecture Overview

### Modular Monolith Pattern

This project uses a **modular monolith** architecture where features are organized into self-contained modules rather than traditional MVC layers.

**Module Structure (example: User module):**
```
app/Modules/User/
├── Actions/              # Business logic classes (LoginUserAction, CreateUserAction)
├── Http/
│   ├── Controllers/      # Single-action controllers with __invoke method
│   │   └── Web/          # Web-specific controllers
│   ├── Requests/         # Form request validation (LoginUserRequest)
│   └── Resources/        # API response transformers (UserResource)
├── Models/               # Eloquent models (User.php)
├── Policies/             # Authorization policies (UserPolicy)
├── Providers/            # Module service providers (RouteServiceProvider)
└── routes/
    ├── api.php          # API routes (protected with auth:sanctum)
    └── web.php          # Web routes
```

**When creating new features:**
1. Create a new module directory under `app/Modules/`
2. Follow the User module structure as a template
3. Register module routes in the module's RouteServiceProvider
4. Use single-action controllers (one class per endpoint)
5. Extract business logic into Action classes

### Single-Action Controllers

All controllers use the **single-action pattern** with an `__invoke` method:

```php
class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        $user = app(CreateUserAction::class)->execute($request->validated());
        return new UserResource($user);
    }
}
```

**Benefits:**
- Clear responsibility per controller
- Easy to test in isolation
- Encourages slim controllers

### Action Classes

Business logic is encapsulated in **Action classes** (e.g., `LoginUserAction`, `CreateUserAction`):

```php
class CreateUserAction
{
    public function execute(array $data): User
    {
        // Business logic here
        return User::create($data);
    }
}
```

Actions are:
- Reusable across controllers, console commands, and jobs
- Dependency injection friendly
- Independently testable

### Frontend Architecture with Inertia.js

**Inertia.js** bridges Laravel's server-side routing with Vue's client-side reactivity:

- **Routes defined in Laravel** (`routes/web.php`, `app/Modules/*/routes/web.php`)
- **Pages rendered as Vue components** (`resources/js/Pages/`)
- **No API needed** for most operations (Inertia handles data passing)
- **Props automatically synced** between server and client

**Frontend Structure:**
```
resources/js/
├── app.js                    # Vite entry point, Inertia setup
├── Components/
│   ├── common/              # Reusable UI components (Button, Modal, Card, etc.)
│   ├── form/                # Form components (TextInput, Checkbox, etc.)
│   └── [others]             # Header, Footer, etc.
├── Layouts/                 # Page layouts (Default, Auth, Public)
├── Pages/                   # Full-page components (Inertia renders these)
│   ├── Auth/Login.vue
│   ├── Home.vue
│   └── MealCalendar.vue
├── composables/             # Vue 3 composition functions (colors, date, route, utils)
├── store/                   # Vuex modules (auth, users, admin)
└── routes/                  # Route definitions
```

**Component Organization:**
- `Components/common/` - Reusable UI components exported via barrel export (index.js)
- `Components/form/` - Form inputs with consistent styling
- `Layouts/` - Wrap pages with common structure (header, navigation, etc.)
- `Pages/` - Top-level components that Inertia renders (correspond to routes)
- `composables/` - Shared Vue logic using Composition API

**Accessing Laravel Routes in Vue:**
Use Ziggy's `route()` helper (available globally):
```javascript
import { route } from '@/composables/route'
route('user.index')  // Generates URL for named route
```

### Authentication & Authorization

**Two Guard Systems:**

1. **Web Guard** (Session-based):
   - For browser-based requests
   - Login via `LoginController` in User module
   - Protected with `middleware(['auth'])` or `middleware(['guest'])`

2. **API Guard** (Token-based with Sanctum):
   - For API requests
   - Protected with `middleware(['auth:sanctum'])`
   - Tokens issued via Sanctum

**Authorization:**
- Use **Policy classes** for authorization logic (e.g., `UserPolicy`)
- Gate checks in controllers: `->authorize('update', $user)`
- Route-level checks: `->can('list', User::class)`
- Spatie permission package for role-based access

**Activity Logging:**
- Spatie activity log tracks model changes automatically
- Enabled via `LogsActivity` trait on models

### Form Validation Pattern

Use **Form Request classes** for validation:

```php
class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ];
    }
}
```

Type-hint the request in your controller to auto-validate before execution.

### API Response Pattern

Use **Resource classes** to transform models for API responses:

```php
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            // ... other fields
        ];
    }
}
```

## Key Conventions

### Models
- Use UUIDs as primary keys (via `UuidPrimaryKey` trait)
- Enable activity logging with `LogsActivity` trait
- Use `HasRoles` for permission management
- Hide sensitive fields (password, tokens) in `$hidden` array

### Routes
- **Module routes**: Define in module's `routes/api.php` or `routes/web.php`
- **Named routes**: Always use named routes for easier refactoring
- **API routes**: Protected with `auth:sanctum` middleware
- **Web routes**: Use `web` middleware group (session, CSRF)

### Frontend
- **Use Composition API** (`<script setup>`) for new components
- **Import from barrel exports**: `import { Button, Card } from '@/Components/common'`
- **Tailwind classes**: Use utility-first approach, avoid custom CSS when possible
- **Dark mode support**: Use `dark:` prefix for dark theme variants

### Testing
- **Feature tests**: Test full HTTP request/response cycle
- **Unit tests**: Test individual classes (Actions, helpers)
- **Database**: Use `RefreshDatabase` trait for tests that touch the database
- Test environment configured in `phpunit.xml` (array drivers, no external services)

## Build Configuration

**Vite setup** (`vite.config.js`):
- Entry points: `resources/sass/app.scss` and `resources/js/app.js`
- Path alias: `@` resolves to `resources/js`
- Plugins: Laravel, Vue, Tailwind CSS
- SCSS preprocessor with modern-compiler API

**PostCSS** (`postcss.config.js`):
- Tailwind CSS v4 PostCSS plugin
- Autoprefixer via Tailwind

## Important Notes

- **Inertia responses**: Use `Inertia::render('PageName', $props)` for page components
- **API vs Web**: Most features use Inertia (web routes). API routes are for external consumers or mobile apps.
- **Module registration**: Each module's `RouteServiceProvider` must be registered in `config/app.php`
- **Asset compilation**: Always run `npm run dev` during development for hot reload
- **UUID models**: Use `User::find($uuid)` not `User::findOrFail($id)` for UUID lookups
