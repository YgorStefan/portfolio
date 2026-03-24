# Architecture Research

**Domain:** Laravel personal portfolio site (single-page, no database, JSON-driven)
**Researched:** 2026-03-24
**Confidence:** HIGH

## Standard Architecture

### System Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                        Browser (Client)                          │
│  ┌───────────┐  ┌───────────┐  ┌─────────────┐  ┌───────────┐  │
│  │  HTML/CSS │  │ Alpine.js │  │   Swiper.js │  │  JS Anim  │  │
│  │  (Blade)  │  │ (x-inter) │  │  (carousel) │  │(scroll)   │  │
│  └─────┬─────┘  └─────┬─────┘  └──────┬──────┘  └─────┬─────┘  │
└────────┼──────────────┼───────────────┼────────────────┼────────┘
         │ HTTP requests│               │                │
┌────────┼──────────────┼───────────────┼────────────────┼────────┐
│                    Laravel Application (PHP)                      │
│  ┌─────┴─────────────────────────────────────────────────────┐   │
│  │                       web.php (routes)                     │   │
│  │  GET /            → PortfolioController@index              │   │
│  │  POST /contact    → ContactController@send                 │   │
│  └───────────────────────────────────────────────────────────┘   │
│  ┌────────────────────────┐  ┌────────────────────────────────┐  │
│  │   PortfolioController  │  │      ContactController         │  │
│  │  - reads projects.json │  │  - validates form input        │  │
│  │  - passes to view      │  │  - sends mail via SMTP         │  │
│  └────────────┬───────────┘  └────────────────────────────────┘  │
│               │                                                   │
│  ┌────────────┴───────────────────────────────────────────────┐  │
│  │              Blade Views (resources/views/)                 │  │
│  │   layouts/app.blade.php  ←  sections/pages extend this     │  │
│  │   pages/home.blade.php   ←  single route target            │  │
│  │   partials/              ←  nav, footer, sections          │  │
│  │   emails/contact.blade.php ← mail template                 │  │
│  └────────────────────────────────────────────────────────────┘  │
├───────────────────────────────────────────────────────────────────┤
│                        Data Layer                                  │
│  ┌─────────────────────────┐  ┌────────────────────────────────┐  │
│  │   data/projects.json    │  │   .env (SMTP credentials)      │  │
│  │   (read-only at runtime)│  │   config/mail.php              │  │
│  └─────────────────────────┘  └────────────────────────────────┘  │
├───────────────────────────────────────────────────────────────────┤
│                      Asset Pipeline (Vite)                        │
│  ┌────────────────────┐  ┌─────────────────────────────────────┐  │
│  │  resources/css/    │  │  resources/js/                      │  │
│  │  app.css           │  │  app.js (Alpine, Swiper, scroll)    │  │
│  │  (Tailwind v4)     │  │                                     │  │
│  └─────────┬──────────┘  └────────────────┬────────────────────┘  │
│            │                              │                       │
│  ┌─────────┴──────────────────────────────┴────────────────────┐  │
│  │               public/build/ (compiled output)               │  │
│  └─────────────────────────────────────────────────────────────┘  │
└───────────────────────────────────────────────────────────────────┘
```

### Component Responsibilities

| Component | Responsibility | Communicates With |
|-----------|----------------|-------------------|
| `web.php` | Defines two routes: `GET /` and `POST /contact` | Controllers |
| `PortfolioController` | Reads `projects.json`, decodes it, passes collection to view | Blade view, JSON file |
| `ContactController` | Validates POST data, dispatches Mailable, returns redirect with flash | Laravel Mail, Blade view |
| `ContactMail` (Mailable) | Wraps email data, renders email template, targets owner's address | SMTP driver, email Blade template |
| `layouts/app.blade.php` | HTML shell: `<head>`, nav, `@yield('content')`, footer, `@vite()` | All page views extend it |
| `pages/home.blade.php` | Injects all portfolio sections into `@section('content')` | Partials via `@include` |
| `partials/*.blade.php` | One file per section (hero, about, skills, projects, contact) | Receives `$projects` variable |
| `resources/css/app.css` | Tailwind v4 entry point — all design tokens, custom utilities | Vite, Blade via `@vite()` |
| `resources/js/app.js` | Alpine.js init, Swiper init, scroll animation setup | Vite, Alpine Intersect plugin |
| `data/projects.json` | Static array of project objects (title, description, tags, url, image) | `PortfolioController` |

---

## Recommended Project Structure

```
portifolio/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── PortfolioController.php   # reads JSON, renders home view
│   │       └── ContactController.php     # handles form POST
│   └── Mail/
│       └── ContactMail.php               # Mailable class
├── data/
│   └── projects.json                     # project data (not inside resources/)
├── resources/
│   ├── css/
│   │   └── app.css                       # @import "tailwindcss" entry point
│   ├── js/
│   │   └── app.js                        # Alpine + Swiper + scroll anim init
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             # HTML shell, nav, footer, @vite()
│       ├── pages/
│       │   └── home.blade.php            # @extends('layouts.app'), home content
│       ├── partials/
│       │   ├── nav.blade.php             # sticky navigation bar
│       │   ├── hero.blade.php            # hero section
│       │   ├── about.blade.php           # about section
│       │   ├── skills.blade.php          # skills carousel (Swiper)
│       │   ├── projects.blade.php        # projects grid (receives $projects)
│       │   └── contact.blade.php         # contact form + social links
│       └── emails/
│           └── contact.blade.php         # email template for owner notification
├── routes/
│   └── web.php                           # GET / and POST /contact
├── config/
│   └── mail.php                          # SMTP config (reads from .env)
├── public/                               # document root on Hostinger
│   ├── index.php
│   ├── build/                            # Vite compiled output (CSS/JS)
│   └── images/
│       └── projects/                     # project thumbnail images
├── vite.config.js
├── package.json
└── .env                                  # MAIL_* credentials, APP_KEY, etc.
```

### Structure Rationale

- **`data/projects.json` at project root, not `storage/`:** Keeps it clearly a static asset, not a runtime-generated file. PHP reads it with `file_get_contents(base_path('data/projects.json'))` or `File::json(base_path('data/projects.json'))`. No Storage disk configuration required.
- **`partials/` per section:** Each portfolio section is self-contained. The home view is just a sequence of `@include` calls — easy to reorder or toggle sections without touching the main template.
- **No `resources/views/sections/` nesting:** For a single-page site with ~5 sections, flat partials are simpler than a nested directory.
- **`public/images/projects/`:** Project thumbnails live in the public directory, directly URL-accessible. No Storage facade needed.
- **No Models directory:** Zero Eloquent models. The controller handles JSON decoding directly, or delegates to a plain PHP service class if the logic grows.

---

## Architectural Patterns

### Pattern 1: Single Route → Single View with Partials

**What:** All portfolio content lives at `GET /`. The controller reads JSON and passes data to `home.blade.php`, which `@include`s each section partial in order.

**When to use:** Always for a single-page portfolio. Avoids route proliferation for what is functionally a scrollable one-page layout.

**Trade-offs:** Simple and fast. No pagination, no filtering, no AJAX needed. Adding a separate `/projects` route later is trivial.

**Example:**
```php
// routes/web.php
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
```

```php
// PortfolioController.php
public function index(): View
{
    $projects = collect(json_decode(
        File::get(base_path('data/projects.json')), true
    ));

    return view('pages.home', compact('projects'));
}
```

```blade
{{-- pages/home.blade.php --}}
@extends('layouts.app')

@section('content')
    @include('partials.hero')
    @include('partials.about')
    @include('partials.skills')
    @include('partials.projects', ['projects' => $projects])
    @include('partials.contact')
@endsection
```

### Pattern 2: POST/Redirect/GET for Contact Form

**What:** Contact form POSTs to `/contact`. Controller validates, sends mail, then redirects back to `/#contact` with a flash message. The home view checks for the flash message and shows a success/error banner.

**When to use:** Every form submission in a traditional server-rendered app. Prevents duplicate submissions on browser refresh.

**Trade-offs:** Simple, battle-tested. The only downside is a full page reload on submit — acceptable for a portfolio contact form. No JavaScript form handling needed.

**Example:**
```php
// ContactController.php
public function send(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email|max:150',
        'message' => 'required|string|max:2000',
    ]);

    Mail::to(config('mail.owner_address'))->send(new ContactMail($validated));

    return redirect()->to('/#contact')->with('success', 'Mensagem enviada!');
}
```

```blade
{{-- partials/contact.blade.php --}}
@if (session('success'))
    <p class="text-green-400">{{ session('success') }}</p>
@endif
<form action="{{ route('contact.send') }}" method="POST">
    @csrf
    ...
</form>
```

### Pattern 3: JSON Data as Typed Collection

**What:** Decode `projects.json` inside the controller into a Laravel `collect()` collection. This unlocks `->filter()`, `->sortBy()`, `->take()` without a database, and keeps the view free of logic.

**When to use:** Any time JSON data needs sorting, filtering, or limiting (e.g., showing only "featured" projects on the hero).

**Trade-offs:** Adds minimal overhead. The entire JSON file is loaded per request — entirely acceptable for a portfolio with 10–20 projects. If the file grows beyond ~100 entries, consider caching the decoded result.

**Example:**
```php
$projects = collect(json_decode(File::get(base_path('data/projects.json')), true));
$featured = $projects->where('featured', true)->take(3);
```

### Pattern 4: Blade Layout Inheritance (Single Layout)

**What:** One `layouts/app.blade.php` defines the HTML shell. All pages `@extend` it and fill `@section('content')`. No need for `@yield('scripts')` slots — scripts live in the layout footer by default.

**When to use:** Any multi-section site. Even with a single page, this keeps the layout cleanly separated from content.

**Example:**
```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ygor Stefankowski — Desenvolvedor Full Stack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white" x-data>
    @include('partials.nav')
    @yield('content')
    @include('partials.footer')
</body>
</html>
```

### Pattern 5: Alpine.js Intersect for Scroll Animations

**What:** Use Alpine.js `x-intersect` plugin (official Alpine plugin) to add CSS classes when elements enter the viewport. Combine with Tailwind transition utilities for entrance animations.

**When to use:** For all "animate on scroll" effects. Avoids writing custom `IntersectionObserver` code and stays within the Alpine mental model already in the project.

**Trade-offs:** Requires loading the Alpine Intersect plugin (`@alpinejs/intersect`). Lightweight — total overhead is negligible. The `.once` modifier ensures animations don't repeat on scroll-up.

**Example:**
```blade
<div
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
    :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
    class="transition-all duration-700"
>
    <!-- section content -->
</div>
```

---

## Data Flow

### Page Load Flow (GET /)

```
Browser requests GET /
    ↓
web.php → PortfolioController@index
    ↓
File::get(base_path('data/projects.json'))
    ↓
json_decode → collect($projects)
    ↓
view('pages.home', compact('projects'))
    ↓
Blade compiles: layouts/app → pages/home → partials/*
    ↓
$projects passed into partials/projects.blade.php
    ↓
HTML response sent to browser
    ↓
Browser loads public/build/app.css + public/build/app.js (via @vite manifest)
    ↓
Alpine.js initialises (x-data on <body>), Swiper mounts on .skills-carousel
    ↓
Intersect plugin observes animated elements as user scrolls
```

### Contact Form Flow (POST /contact)

```
User fills form → clicks Submit
    ↓
Browser POST /contact with CSRF token
    ↓
web.php → ContactController@send
    ↓
$request->validate([...]) — fails → redirect back with @error messages
                           — passes ↓
Mail::to($ownerEmail)->send(new ContactMail($validated))
    ↓
ContactMail builds email using emails/contact.blade.php
    ↓
Symfony Mailer sends via SMTP (synchronous, no queue)
    ↓
redirect()->to('/#contact')->with('success', '...')
    ↓
Browser follows redirect → home page scrolls to #contact
    ↓
session('success') flash renders success message in partial
```

### JSON Projects Data Flow

```
data/projects.json (static file, edited manually)
    ↓ (File::get + json_decode on every request)
PortfolioController::index()
    ↓ (collect())
$projects Collection passed to view
    ↓ (@include with ['projects' => $projects])
partials/projects.blade.php
    ↓ (@foreach $projects as $project)
<article> cards rendered in HTML grid
```

---

## Blade Layout Structure

### Layout Hierarchy

```
layouts/app.blade.php          ← HTML shell, @vite(), x-data on body
    └── pages/home.blade.php   ← @extends('layouts.app'), @section('content')
            ├── @include('partials.nav')       ← sticky nav, smooth scroll links
            ├── @include('partials.hero')       ← name, role, CTA, photo
            ├── @include('partials.about')      ← bio text
            ├── @include('partials.skills')     ← Swiper carousel
            ├── @include('partials.projects', ['projects' => $projects])
            ├── @include('partials.contact')    ← form + social links
            └── @include('partials.footer')     ← copyright, back-to-top
```

### Navigation Anchor Mapping

Each section partial wraps its content in a `<section id="...">` tag. The nav links use `href="#hero"`, `href="#about"`, etc. CSS `scroll-behavior: smooth` (via Tailwind's `scroll-smooth` class on `<html>`) handles animated scroll without JavaScript.

```html
<section id="hero">...</section>
<section id="about">...</section>
<section id="skills">...</section>
<section id="projects">...</section>
<section id="contact">...</section>
```

---

## Vite / Asset Pipeline Setup

### Configuration

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### CSS Entry Point

```css
/* resources/css/app.css — Tailwind v4 syntax */
@import "tailwindcss";

/* Custom design tokens */
@theme {
    --color-electric-blue: #3b82f6;  /* adjust to exact accent */
}
```

### JS Entry Point

```javascript
// resources/js/app.js
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import Swiper from 'swiper/bundle';

Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();

// Swiper initialised after DOM ready
document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.skills-carousel', {
        loop: true,
        slidesPerView: 'auto',
        spaceBetween: 24,
        autoplay: { delay: 2500 },
    });
});
```

### Build for Production (Hostinger Deploy)

Development: `npm run dev` (hot module replacement, no manifest needed)
Production:  `npm run build` → outputs to `public/build/`

The `@vite()` Blade directive automatically uses the manifest in production and the dev server in development. Committed `public/build/` files are uploaded to Hostinger.

---

## Suggested Build Order

Dependencies between components drive this order:

| Step | Component | Why First |
|------|-----------|-----------|
| 1 | Vite + Tailwind + Alpine wiring | All views depend on compiled assets loading correctly |
| 2 | `layouts/app.blade.php` | Every view extends this; must exist before any view renders |
| 3 | `web.php` routes (GET /) | Need a working route to test any view |
| 4 | `PortfolioController@index` + JSON reading | Required before projects partial can receive data |
| 5 | `data/projects.json` schema definition | Locks the shape before any consuming code is written |
| 6 | Section partials (hero, about, skills, projects, contact) | Can be built independently once layout exists |
| 7 | `ContactController` + `ContactMail` | Form handling after the form UI exists |
| 8 | Scroll animations (Alpine Intersect) | Progressive enhancement layer, no blockers |
| 9 | Responsive polish + back-to-top | Final pass once all sections render correctly |

---

## Integration Points

### External Services

| Service | Integration Pattern | Notes |
|---------|---------------------|-------|
| SMTP provider (Hostinger mail or Gmail) | Laravel Mail via Symfony Mailer, `.env` credentials | Hostinger includes SMTP; use port 465 (SSL) or 587 (TLS). Gmail requires App Password if 2FA enabled. Consider Mailtrap for dev. |
| Swiper.js | npm package, imported in `app.js`, initialised on `DOMContentLoaded` | Use `swiper/bundle` import for simplest setup. Version 11 is current as of 2025. |
| Alpine.js | npm package, imported in `app.js` | Use `@alpinejs/intersect` for scroll animations. Attach `x-data` to `<body>` for global scope. |

### Internal Boundaries

| Boundary | Communication | Notes |
|----------|---------------|-------|
| Controller → View | `compact('projects')` array passed to `view()` | Keep controller thin; no business logic beyond JSON decode + collection filter |
| View → Partial | `@include('partial', ['projects' => $projects])` | Partials receive data explicitly; no implicit global view composers needed |
| Controller → Mail | `Mail::to()->send(new ContactMail($data))` | Mail class constructor accepts validated array; no model binding needed |
| Vite → Blade | `@vite(['resources/css/app.css', 'resources/js/app.js'])` in layout | Single `@vite()` call in the layout `<head>` — don't duplicate in child views |

---

## Anti-Patterns

### Anti-Pattern 1: Logic in Blade Templates

**What people do:** Put `json_decode(file_get_contents(...))` directly inside a `.blade.php` file to read projects inline.
**Why it's wrong:** Mixes data access with presentation. Hard to cache later. Untestable. Breaks MVC.
**Do this instead:** Read and decode JSON in `PortfolioController`, pass the collection to the view.

### Anti-Pattern 2: Using Storage Disk for JSON Data

**What people do:** Store `projects.json` in `storage/app/` and read it with `Storage::get()`.
**Why it's wrong:** Adds an unnecessary disk abstraction for a file that never changes at runtime and doesn't need cloud storage. Requires `storage:link` setup.
**Do this instead:** Place `projects.json` at `base_path('data/projects.json')` and read with `File::json()` or `file_get_contents()`.

### Anti-Pattern 3: Queuing Mail on Shared Hosting

**What people do:** Wrap mail dispatch in `Mail::to()->queue()` (or use `dispatch(new SendContactEmail())`).
**Why it's wrong:** Shared hosting (Hostinger) does not provide a queue worker daemon. Queued jobs never process.
**Do this instead:** Use synchronous `Mail::to()->send()`. For v1 with low traffic, synchronous send on the web request is perfectly acceptable.

### Anti-Pattern 4: Separate Route per Section

**What people do:** Create `GET /about`, `GET /skills`, `GET /projects` routes for "cleanliness."
**Why it's wrong:** This is a single-page site. Separate routes force separate page loads, break smooth scroll, and require duplicating the layout render for each route.
**Do this instead:** Single `GET /` route returns the full page. Sections are navigated via anchor links (`#about`, `#skills`).

### Anti-Pattern 5: Committing `.env` or Putting Credentials in JSON

**What people do:** Put SMTP credentials in `projects.json` or commit `.env` to the repository.
**Why it's wrong:** Security exposure. Hostinger control panels are often shared credentials environments.
**Do this instead:** Use `.env` exclusively for credentials. Add `.env` to `.gitignore` (default in Laravel). Set env variables via Hostinger's hPanel file manager on the server.

---

## Scaling Considerations

This is a personal portfolio — traffic will be low and scaling is not a real concern. Notes are included for completeness.

| Scale | Architecture Adjustments |
|-------|--------------------------|
| 0–1k visitors/month | Current architecture is correct. No changes needed. |
| 1k–50k visitors/month | Add response caching for the home route (`Cache::remember()`). Cache the decoded JSON collection for 60 minutes to avoid file reads on every request. |
| 50k+ visitors/month | At this point, move off shared hosting to a VPS (Laravel Forge/Ploi). Add a CDN for `public/build/` assets and images. Consider database-backed projects if an admin UI becomes necessary. |

---

## Sources

- [Laravel 12.x Routing Documentation](https://laravel.com/docs/12.x/routing) — HIGH confidence
- [Laravel 12.x Blade Templates](https://laravel.com/docs/12.x/blade) — HIGH confidence
- [Laravel 12.x Mail](https://laravel.com/docs/12.x/mail) — HIGH confidence
- [Laravel 12.x Asset Bundling (Vite)](https://laravel.com/docs/12.x/vite) — HIGH confidence
- [Tailwind CSS with Laravel Install Guide](https://tailwindcss.com/docs/guides/laravel) — HIGH confidence
- [Alpine.js Intersect Plugin](https://alpinejs.dev/plugins/intersect) — HIGH confidence
- [Reading JSON Files in Laravel — Ash Allen Design](https://ashallendesign.co.uk/blog/reading-json-files-in-laravel) — MEDIUM confidence
- [Laravel Blade View Organization Pattern (Maxiviper117 Gist)](https://gist.github.com/Maxiviper117/592658a3c27925f98e24bdff700f9de2) — MEDIUM confidence
- [Laravel Hostinger Shared Hosting Deploy Guide](https://dev.to/pushpak1300/deploying-laravel7-app-on-shared-hosting-hostinger-31cj) — MEDIUM confidence
- [Mailtrap: Laravel Contact Form Tutorial](https://mailtrap.io/blog/laravel-contact-form/) — MEDIUM confidence

---

*Architecture research for: Laravel personal portfolio — Ygor Stefankowski da Silva*
*Researched: 2026-03-24*
