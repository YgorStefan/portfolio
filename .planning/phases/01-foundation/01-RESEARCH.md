# Phase 1: Foundation - Research

**Researched:** 2026-03-24
**Domain:** Laravel 12 project setup, Tailwind CSS v4 + Vite asset pipeline, Blade layout, Hostinger shared hosting deployment
**Confidence:** HIGH

---

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|------------------|
| INFRA-01 | Projeto Laravel 12 criado com PHP 8.2, Vite e Tailwind CSS v4 | Full install sequence documented; vite.config.js and app.css patterns verified from official Tailwind Laravel guide |
| INFRA-02 | Pipeline Vite compilando corretamente (`npm run build`) com output em `public/build/` | Build-for-production workflow documented; laravel-vite-plugin 3.0.0 + Vite 6 confirmed compatible with Node 24 local env |
| INFRA-03 | Configuração de deploy documentada para Hostinger (document root → `public/`) | Two deployment strategies documented (symlink vs index.php path rewrite); security verification steps included |
| INFRA-04 | `.env.example` com todas as variáveis necessárias documentadas | Required variables identified: APP_KEY, APP_URL, APP_ENV, APP_DEBUG + mail vars for later phases |
| LAYOUT-01 | Layout Blade base (`layouts/app.blade.php`) com header, main e footer | Layout inheritance pattern documented; `@vite()` placement and `x-data` on body confirmed |
| LAYOUT-02 | Navegação com links de âncora suave para cada seção | CSS `scroll-smooth` on `<html>` via Tailwind class; anchor `href="#section"` pattern documented |
| LAYOUT-03 | Menu hamburger funcional em mobile (Alpine.js) | Alpine `x-data` toggle pattern documented; no extra library needed |
| LAYOUT-04 | Botão "voltar ao topo" com transição suave | Alpine `x-show` + `x-intersect` visibility pattern documented |
| LAYOUT-05 | Design responsivo em mobile, tablet e desktop | Tailwind v4 responsive prefixes (`sm:`, `md:`, `lg:`) unchanged from v3; mobile-first approach |
| VIS-04 | Google Fonts carregando corretamente em produção | CSS `@import` inside `@layer base` in app.css is the correct Tailwind v4 approach; avoids 404/CORS in production |
</phase_requirements>

---

## Summary

Phase 1 establishes the technical foundation that all subsequent phases depend on. The work divides cleanly into three tracks: (1) creating the Laravel 12 project and wiring the Vite + Tailwind v4 + Alpine.js asset pipeline, (2) building the Blade layout shell with responsive navigation, and (3) documenting and partially verifying the Hostinger deployment path. None of these tracks have ambiguous technical choices — the ecosystem has exactly one blessed answer for each decision.

The most important insight from research is that Tailwind v4 is **CSS-first**: there is no `tailwind.config.js`, no PostCSS config, and no content scanning array to configure. Configuration happens in `app.css` using `@theme {}` blocks. The `@tailwindcss/vite` plugin replaces the PostCSS pipeline entirely. Developers who approach v4 expecting v3 patterns will waste hours looking for configuration files that do not exist.

The deployment risk is real and must be addressed in this phase, not retrofitted. Hostinger's default web root is `public_html/` — if the full Laravel app lands there, `.env` is publicly readable. The correct document root strategy must be chosen and tested before any credential is placed on the server. Node.js is not available on Hostinger shared hosting, so `npm run build` must run locally and `public/build/` must be uploaded via FTP on every deploy.

**Primary recommendation:** Create the Laravel 12 project, install `tailwindcss @tailwindcss/vite alpinejs @alpinejs/intersect`, wire `vite.config.js` exactly as documented below, build the Blade layout, then test a production build locally before touching Hostinger at all.

---

## Standard Stack

### Core

| Library | Version | Purpose | Why Standard |
|---------|---------|---------|--------------|
| Laravel | 12.x | Framework, routing, Blade, .env loading | Only Laravel version receiving full support through Feb 2027; PHP 8.2 minimum matches Hostinger ceiling |
| PHP | 8.2.x | Server runtime | Hostinger shared hosting ceiling confirmed as 8.2 (local machine is 8.3 — pin composer.json to `^8.2` regardless) |
| Tailwind CSS | 4.2.2 | Utility-first CSS | Current stable release; CSS-first config, zero PostCSS setup, native Vite plugin |
| @tailwindcss/vite | 4.2.2 | Tailwind v4 Vite plugin | Must match Tailwind version exactly; replaces PostCSS pipeline |
| laravel-vite-plugin | 3.0.0 | Laravel/Vite bridge | Handles @vite() directive, HMR, asset fingerprinting; requires Node 20+ (local is Node 24 — fine) |
| Vite | 6.x | Asset bundler / dev server | Laravel 12 default; `npm run build` produces `public/build/` with versioned manifest |
| Alpine.js | 3.15.8 | Declarative JS for UI interactivity | Mobile nav toggle, back-to-top visibility, scroll animation triggers — all in this phase |
| @alpinejs/intersect | 3.15.8 | IntersectionObserver plugin for Alpine | Used for back-to-top button visibility (LAYOUT-04); loaded once and reused in later phases |

### Supporting

| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| Swiper | 12.1.3 | Skills carousel | NOT in Phase 1 — referenced here for version awareness; installed in Phase 2 |
| AOS | 2.3.4 | Scroll reveal animations | NOT in Phase 1 — installed in Phase 2 |

### Alternatives Considered

| Instead of | Could Use | Tradeoff |
|------------|-----------|----------|
| @tailwindcss/vite | PostCSS + tailwindcss | PostCSS approach still works in v4 but requires extra config file and is explicitly the legacy path |
| Alpine.js (npm) | Alpine.js (CDN) | CDN is simpler for basic use but bypasses Vite bundling and lacks plugin system — use npm for this project |
| CSS scroll-smooth | JS smooth scroll library | JS not needed; `scroll-smooth` on `<html>` covers all anchor navigation |

**Installation (Phase 1 packages only):**
```bash
composer create-project laravel/laravel portfolio
cd portfolio
npm install tailwindcss @tailwindcss/vite alpinejs @alpinejs/intersect
```

**Version verification (confirmed 2026-03-24 from npm registry):**
```
tailwindcss           4.2.2
@tailwindcss/vite     4.2.2
laravel-vite-plugin   3.0.0
alpinejs              3.15.8
@alpinejs/intersect   3.15.8
swiper                12.1.3  (Phase 2)
aos                   2.3.4   (Phase 2)
```

---

## Architecture Patterns

### Recommended Project Structure

```
portifolio/
├── app/Http/Controllers/
│   └── PortfolioController.php    # reads projects.json, renders home view
├── data/
│   └── projects.json              # defined in Phase 1 schema; populated in Phase 2
├── resources/
│   ├── css/app.css                # @import "tailwindcss" entry + @theme tokens
│   └── js/app.js                  # Alpine init + plugin registration
├── resources/views/
│   ├── layouts/app.blade.php      # HTML shell with @vite(), nav, footer
│   ├── pages/home.blade.php       # @extends layout, @includes partials
│   └── partials/
│       ├── nav.blade.php          # sticky nav, hamburger (Alpine)
│       └── footer.blade.php       # copyright, back-to-top button
├── routes/web.php                 # GET / only in Phase 1
├── vite.config.js
└── public/build/                  # Vite output — compiled locally, FTPd to host
```

### Pattern 1: Tailwind v4 CSS-First Configuration

**What:** Tailwind v4 has no `tailwind.config.js` by default. All configuration lives in `app.css` using `@theme {}` for design tokens and `@source` directives if needed. The `@tailwindcss/vite` plugin handles content scanning automatically.

**When to use:** Always for v4 — this is the only supported approach with the Vite plugin.

**Example:**
```css
/* resources/css/app.css */
/* Source: https://tailwindcss.com/docs/guides/laravel */
@import "tailwindcss";

@theme {
    --color-accent: #3b82f6;         /* electric blue */
    --color-bg: #030712;             /* near-black background */
    --font-sans: 'Inter', sans-serif;
}

@layer base {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
}
```

**Important:** Google Fonts must be imported inside `@layer base` in this file — NOT in the Blade `<head>` — to ensure they are included in the production CSS bundle and served correctly (satisfies VIS-04).

### Pattern 2: Vite Config (Laravel + Tailwind v4)

**What:** Single `vite.config.js` with two plugins: `laravel()` for Blade integration and `tailwindcss()` for v4 processing. No PostCSS config file required.

**Example:**
```js
// vite.config.js
// Source: https://tailwindcss.com/docs/guides/laravel
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

### Pattern 3: Blade Layout Shell

**What:** Single `layouts/app.blade.php` that all pages extend. The `@vite()` directive belongs in `<head>`. Alpine's `x-data` belongs on `<body>` to give all partials access to the global Alpine scope.

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
<body class="bg-gray-950 text-white antialiased" x-data>
    @include('partials.nav')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>
```

**Notes:**
- `scroll-smooth` on `<html>` enables CSS smooth scroll for all anchor links (LAYOUT-02) — no JS required
- `x-data` on `<body>` (empty object) creates a global Alpine scope without any specific component data
- Single `@vite()` call in the layout — never repeat in child views

### Pattern 4: Alpine.js Mobile Hamburger Menu

**What:** Alpine `x-data` with an `open` boolean controls nav visibility on mobile. No custom JS required.

**Example:**
```blade
{{-- partials/nav.blade.php --}}
<nav x-data="{ open: false }" class="fixed top-0 w-full z-50 bg-gray-950/90 backdrop-blur">
    <div class="flex items-center justify-between px-6 py-4">
        <a href="#hero" class="font-bold text-white">YS</a>
        <button @click="open = !open" class="md:hidden text-white" aria-label="Menu">
            <svg x-show="!open" ...></svg>
            <svg x-show="open" ...></svg>
        </button>
        <ul class="hidden md:flex gap-8" :class="open ? 'flex flex-col ...' : 'hidden md:flex'">
            <li><a href="#about">Sobre</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#projects">Projetos</a></li>
            <li><a href="#contact">Contato</a></li>
        </ul>
    </div>
    <ul x-show="open" x-transition ...> {{-- mobile menu --}} </ul>
</nav>
```

### Pattern 5: Back-to-Top Button (Alpine Intersect)

**What:** Show back-to-top button only after user scrolls past the hero. Uses `@alpinejs/intersect` to observe the hero section sentinel.

**Example:**
```blade
{{-- In partials/footer.blade.php or layout --}}
<div x-data="{ show: false }">
    <div x-intersect:leave.once="show = true"
         x-intersect:enter.once="show = false"
         id="hero-sentinel" class="absolute top-0"></div>
    <button x-show="show"
            x-transition
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 bg-accent text-white rounded-full p-3">
        ↑
    </button>
</div>
```

### Pattern 6: JS Entry Point

**What:** `app.js` registers Alpine plugins before calling `Alpine.start()`. Order matters — plugins must be registered before start.

**Example:**
```js
// resources/js/app.js
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();
```

Note: Swiper and AOS are NOT imported here in Phase 1 — added in Phase 2.

### Pattern 7: GET / Route and Controller Stub

**What:** Phase 1 creates the route and a minimal controller that renders the home view. JSON reading is wired but `data/projects.json` is created with an empty array.

**Example:**
```php
// routes/web.php
use App\Http\Controllers\PortfolioController;
Route::get('/', [PortfolioController::class, 'index'])->name('home');
```

```php
// app/Http/Controllers/PortfolioController.php
public function index(): View
{
    $projects = collect(json_decode(
        File::get(base_path('data/projects.json')), true
    ));
    return view('pages.home', compact('projects'));
}
```

```json
// data/projects.json — Phase 1 stub (schema defined, no real data yet)
[]
```

### Pattern 8: Hostinger Deploy — Document Root Strategy

**What:** On Hostinger, the web root is `public_html/`. Two strategies keep Laravel source files non-public. Strategy A (index.php rewrite) is recommended for shared hosting plans without SSH.

**Strategy A — index.php path rewrite (works on all Hostinger plans):**

1. Upload full Laravel project to `~/laravel/` (above `public_html/`)
2. Copy ONLY `laravel/public/` contents into `public_html/`
3. Edit `public_html/index.php` — update two path constants:
```php
// Before:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// After:
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
```
4. Copy `laravel/.htaccess` to `public_html/.htaccess`

**Strategy B — Document root via hPanel (Business plan only):**

1. Upload full project to `~/laravel/`
2. In hPanel: Hosting > Manage > Advanced > Document Root → set to `/home/user/domains/yourdomain.com/laravel/public`

**Security verification (both strategies):**
- `yourdomain.com/.env` must return 403 or 404 — NOT file contents
- `yourdomain.com/vendor/` must return 403 or 404
- `yourdomain.com/composer.json` must return 403 or 404

### Anti-Patterns to Avoid

- **No `tailwind.config.js`:** Tailwind v4 does not use this file. Creating one for v4 is either ignored or causes conflicts. Content scanning is automatic via the Vite plugin.
- **No PostCSS config for Tailwind:** `postcss.config.js` with `tailwindcss` plugin is the v3 approach. With `@tailwindcss/vite`, PostCSS is not needed and adding it creates a conflict.
- **No `@vite()` in child views:** The directive belongs only in `layouts/app.blade.php`. Duplicating it causes double asset loading.
- **Never place Laravel source in `public_html/` root:** Puts `.env`, `vendor/`, `config/` in the web root — critical security exposure.
- **Never use `npm run dev` build for production upload:** The dev server output is not the same as `npm run build`. Only `public/build/` from a production build should be FTPd to Hostinger.

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| CSS anchor smooth scroll | Custom JS scroll handler | `scroll-smooth` Tailwind class on `<html>` | CSS-native, zero JS, works for all anchor links site-wide |
| Mobile menu toggle | Vanilla JS classList toggle | Alpine.js `x-data / @click / x-show` | Declarative, no event listener cleanup needed, already in bundle |
| Back-to-top visibility detection | `scroll` event listener with debounce | `@alpinejs/intersect` `x-intersect:leave` on hero | IntersectionObserver-based, no performance cost, no scroll event needed |
| Asset fingerprinting | Manual cache-busting query strings | `@vite()` directive + `laravel-vite-plugin` | Automatic versioning via manifest.json, handles dev vs prod automatically |
| Tailwind custom color tokens | Hardcoded hex values in every class | `@theme { --color-accent: ... }` in app.css | Single source of truth, generates `text-accent`, `bg-accent` etc. automatically |

**Key insight:** In this stack, the framework handles asset versioning, the CSS framework handles responsive layout and scroll behavior, and Alpine handles DOM interactivity. Writing custom JS for any of these three is always the wrong choice.

---

## Runtime State Inventory

Step 2.5 SKIPPED — Phase 1 is a greenfield setup phase (new Laravel project creation). There is no existing runtime state, stored data, OS registrations, or build artifacts for the portfolio project yet. This section does not apply.

---

## Environment Availability Audit

| Dependency | Required By | Available | Version | Fallback |
|------------|------------|-----------|---------|----------|
| Node.js | Vite asset pipeline (local build) | Yes | 24.14.0 | — |
| npm | Package installation | Yes | 11.9.0 | — |
| PHP | Laravel (local + server) | Yes (local) | 8.3.30 (local) / 8.2.x (Hostinger) | — |
| Composer | PHP dependency management | Yes | 2.9.5 | — |
| Git | Version control | Not verified | — | Not required for Phase 1 execution |
| FTP client | Uploading `public/build/` to Hostinger | Not verified | — | Manual file manager in hPanel |

**Notes:**
- Local PHP is 8.3.30. `composer.json` must pin `"php": "^8.2"` to match Hostinger ceiling. Laravel 12 runs fine under both versions.
- `laravel-vite-plugin` 3.0.0 requires Node 20+. Local Node 24 satisfies this requirement.
- No external services required in Phase 1 (mail, database, CDN are all later phases).

**Missing dependencies with no fallback:** None — all required tools confirmed available locally.

**Missing dependencies with fallback:** FTP client / Git — Hostinger provides a file manager in hPanel as a fallback for file uploads. Neither is strictly required to complete Phase 1 locally.

---

## Common Pitfalls

### Pitfall 1: Expecting `tailwind.config.js` to Exist in v4

**What goes wrong:** Developer creates `tailwind.config.js` with a `content` array (v3 pattern), then discovers Tailwind v4 ignores it entirely. Custom colors defined there don't appear. Time wasted debugging.

**Why it happens:** All community tutorials, Stack Overflow answers, and most AI suggestions still reference v3 patterns as of early 2026. v4 is less than 14 months old.

**How to avoid:** All Tailwind configuration lives in `app.css`. Custom design tokens: `@theme { --color-accent: #3b82f6; }`. Custom utilities: `@utility`. Content scanning: automatic via `@tailwindcss/vite` plugin, no override needed.

**Warning signs:** Classes defined in `tailwind.config.js` extend/theme sections have no effect in the browser.

### Pitfall 2: Vite Manifest 404 After Deploy

**What goes wrong:** Production site renders with zero CSS/JS. Browser console shows 404 for `/build/app-[hash].css`.

**Why it happens:** `public/build/` was not compiled locally and uploaded. Node.js is not available on Hostinger shared hosting — you cannot run `npm run build` on the server.

**How to avoid:** Treat `npm run build` as the last step of every deployment. Upload entire `public/build/` directory via FTP after every build. Add this to the deploy checklist documented in INFRA-03.

**Warning signs:** Page loads but has no styling; console shows 404s for fingerprinted asset files.

### Pitfall 3: `.env` Accessible from Browser (Wrong Document Root)

**What goes wrong:** Visiting `yourdomain.com/.env` returns the raw file with APP_KEY, SMTP credentials, and any future database passwords.

**Why it happens:** Full Laravel project uploaded into `public_html/` instead of only `public/` contents. Hostinger's default web root is the entire `public_html/` directory.

**How to avoid:** Use Strategy A (index.php path rewrite) documented above. After any deploy, verify `yourdomain.com/.env` returns 403/404. This check must be in the deploy guide (INFRA-03).

**Warning signs:** Direct URL access to `.env`, `vendor/autoload.php`, or `composer.json` returns content instead of 403/404.

### Pitfall 4: Google Fonts CORS Error or 404 in Production Build (VIS-04)

**What goes wrong:** Fonts load in `npm run dev` but fail in production. Either the Google Fonts `@import` is stripped from the production CSS, or CORS blocks the font from loading.

**Why it happens:** If Google Fonts `@import` is placed in the Blade `<head>` as a `<link>` tag or `<style>` block rather than in `app.css`, it is outside the Vite pipeline and may be blocked by the production server's CSP or missing from the compiled output.

**How to avoid:** Place the Google Fonts import inside `app.css` within `@layer base`. This ensures it appears in the compiled CSS output and is served through the normal asset path:
```css
@layer base {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
}
```
Alternatively, use Bunny Fonts (GDPR-compliant drop-in replacement for Google Fonts) — same URL format, no GDPR concern.

**Warning signs:** Console shows a CORS or CSP error for `fonts.googleapis.com`; or text renders in the OS fallback font in production but the correct font in development.

### Pitfall 5: `APP_URL` Set to `http://localhost` in Production

**What goes wrong:** Asset URLs in the production HTML point to `http://localhost/build/...` instead of the real domain. All assets 404.

**Why it happens:** `.env` is copied from local development without updating `APP_URL`.

**How to avoid:** Production `.env` must set `APP_URL=https://yourdomain.com`. Also set `APP_ENV=production` and `APP_DEBUG=false`. Document all three in the deploy guide.

### Pitfall 6: PHP Version Mismatch Between Local and Hostinger

**What goes wrong:** `composer install --no-dev` fails on Hostinger or silently installs wrong package versions because local PHP is 8.3 but Hostinger is 8.2.

**Why it happens:** Local machine has PHP 8.3.30. `composer.json` generated by `composer create-project` defaults to the local PHP version requirement.

**How to avoid:** Immediately after creating the project, set `"php": "^8.2"` in `composer.json`'s `require` block. Run `composer update` locally to confirm no package requires 8.3+ features. Verify Hostinger's actual available PHP version in hPanel before first deploy.

---

## Code Examples

### Complete vite.config.js

```js
// Source: https://tailwindcss.com/docs/guides/laravel (verified 2026-03-24)
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

### Complete app.css (Phase 1)

```css
/* resources/css/app.css */
/* Source: https://tailwindcss.com/docs/guides/laravel */
@import "tailwindcss";

/* Phase 1: design tokens only */
@layer base {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
}

@theme {
    --color-accent: #3b82f6;
    --color-bg-primary: #030712;
    --color-bg-card: #111827;
    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
}
```

### Complete app.js (Phase 1 — no Swiper/AOS yet)

```js
// resources/js/app.js
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();
```

### layouts/app.blade.php (complete Phase 1 version)

```blade
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ygor Stefankowski — Desenvolvedor Full Stack</title>
    <meta name="description" content="Portfólio de Ygor Stefankowski da Silva, Desenvolvedor Full Stack.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white antialiased" x-data>
    @include('partials.nav')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>
```

### .env.example (INFRA-04 — Phase 1 variables)

```dotenv
APP_NAME=Portfolio
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Production deploy: set APP_ENV=production, APP_DEBUG=false, APP_URL=https://yourdomain.com
# Mail variables (needed in Phase 3):
# MAIL_MAILER=smtp
# MAIL_HOST=
# MAIL_PORT=587
# MAIL_USERNAME=
# MAIL_PASSWORD=
# MAIL_ENCRYPTION=tls
# MAIL_FROM_ADDRESS=contato@yourdomain.com
# MAIL_FROM_NAME="${APP_NAME}"
# MAIL_OWNER_ADDRESS=ygor@yourdomain.com
```

### Production deploy checklist (INFRA-03)

```
1. Locally: npm run build
2. FTP: upload entire public/build/ to public_html/build/ (replacing old contents)
3. FTP: upload changed PHP/Blade files
4. Server: verify public_html/index.php paths point to ../laravel/vendor/ and ../laravel/bootstrap/
5. Server .env: APP_ENV=production, APP_DEBUG=false, APP_URL=https://yourdomain.com
6. Verify: yourdomain.com/.env returns 403/404 (NOT file contents)
7. Verify: yourdomain.com/vendor/ returns 403/404
8. Verify: page loads with full CSS/JS (no console 404s)
9. Verify: APP_DEBUG=false by triggering /nonexistent-route — must show plain 404, not Ignition
```

---

## State of the Art

| Old Approach | Current Approach | When Changed | Impact |
|--------------|------------------|--------------|--------|
| `tailwind.config.js` + content array | CSS-first `@theme {}` in app.css, auto-scanning via `@tailwindcss/vite` | Tailwind v4 (Jan 2025) | No config file to create or maintain |
| `postcss.config.js` with tailwindcss plugin | `@tailwindcss/vite` plugin in `vite.config.js` | Tailwind v4 (Jan 2025) | One less config file; PostCSS not involved |
| Laravel Mix (webpack) | `laravel-vite-plugin` + Vite | Laravel 10+ (2023), standard in L12 | 10x faster builds; Mix fully deprecated |
| `@import url(...)` in Blade `<head>` | `@import url(...)` inside `@layer base` in app.css | Tailwind v4 CSS-first pattern | Fonts included in production bundle, no separate network request ordering issues |

**Deprecated/outdated:**
- Laravel Mix: do not install `laravel-mix` npm package; not compatible with Tailwind v4
- `tailwind.config.js` with `content: [...]`: redundant with `@tailwindcss/vite`
- PostCSS-based Tailwind setup: valid but legacy; Vite plugin approach is the official Laravel path

---

## Open Questions

1. **Hostinger PHP version ceiling — exact current version**
   - What we know: Documented as PHP 8.2 ceiling as of December 2025
   - What's unclear: Whether 8.3 is now available (local machine has 8.3.30, suggesting 8.3 is stable)
   - Recommendation: Pin to `^8.2` in `composer.json` now. Before first deploy, check hPanel's PHP version selector. If 8.3 is listed, bump the pin. Low priority — this does not block Phase 1 local work.

2. **Hostinger plan SSH availability**
   - What we know: SSH is included in Business plan and above; not available on Starter/Premium
   - What's unclear: Which Hostinger plan is in use for this project
   - Recommendation: Check hPanel for SSH access. If available, Strategy B (document root via hPanel) is simpler. If not, use Strategy A (index.php rewrite). The deploy guide should document both paths.

3. **Google Fonts vs Bunny Fonts**
   - What we know: Google Fonts works correctly in production when imported in `@layer base`; Bunny Fonts is a GDPR-compliant drop-in replacement with the same URL format
   - What's unclear: Whether GDPR compliance is a concern for this portfolio (Brazilian audience, not EU-targeted)
   - Recommendation: Use Google Fonts for v1 — simpler, no functional difference for a BR-audience portfolio. Switch to Bunny Fonts in a future polish pass if needed.

---

## Validation Architecture

### Test Framework

| Property | Value |
|----------|-------|
| Framework | None — automated testing is explicitly out of scope for v1 (see REQUIREMENTS.md Out of Scope) |
| Config file | n/a |
| Quick run command | n/a |
| Full suite command | n/a |

### Phase Requirements → Test Map

All Phase 1 requirements are verified manually. Automated tests are out of scope per project REQUIREMENTS.md ("Testes automatizados — Fora do escopo de v1; portfólio simples sem lógica de negócio complexa").

| Req ID | Behavior | Test Type | Verification Method |
|--------|----------|-----------|---------------------|
| INFRA-01 | Laravel 12 project created with PHP 8.2, Vite, Tailwind v4 | manual | `php artisan --version` shows Laravel 12.x; `cat package.json` shows tailwindcss ^4.x |
| INFRA-02 | `npm run build` produces output in `public/build/` with no errors | manual | Run `npm run build` and confirm `public/build/manifest.json` exists; no terminal errors |
| INFRA-03 | Deploy guide documents Hostinger document root, APP_DEBUG=false, .env 403 check | manual | Read the written deploy guide; verify checklist steps are actionable |
| INFRA-04 | `.env.example` has all variables documented | manual | `cat .env.example` shows all required variables with comments |
| LAYOUT-01 | Blade layout renders at GET / with header, main, footer visible | manual | `php artisan serve`, open browser, confirm structure in DevTools |
| LAYOUT-02 | Smooth-scroll nav links work | manual | Click nav anchor links; confirm smooth scroll behavior in browser |
| LAYOUT-03 | Hamburger menu works on mobile | manual | Resize to 375px in DevTools; click hamburger; confirm menu opens/closes |
| LAYOUT-04 | Back-to-top button appears after scrolling past hero | manual | Scroll down; confirm button appears; click; confirm scroll to top |
| LAYOUT-05 | Responsive at mobile, tablet, desktop | manual | DevTools device emulation at 375px, 768px, 1280px — no overflow, no broken layout |
| VIS-04 | Google Fonts load correctly in production build | manual | Run `npm run build`, open `public/build/app-[hash].css`, confirm `@import` for fonts is present; in browser verify text renders in Inter, not system fallback |

### Sampling Rate

- **Per task commit:** Manual browser check at `php artisan serve` — confirm route renders and assets load
- **Per wave merge:** `npm run build` with no errors + manual browser check in production build (serve `public/` directory with a simple HTTP server or test on Hostinger staging)
- **Phase gate:** All 10 manual verification steps pass before moving to Phase 2

### Wave 0 Gaps

None — no test framework infrastructure needed. All verification is manual inspection as per project scope.

---

## Sources

### Primary (HIGH confidence)

- [Tailwind CSS Laravel Install Guide](https://tailwindcss.com/docs/guides/laravel) — official v4 Vite setup, CSS-first config, no postcss.config.js
- [Tailwind CSS v4 Blog Post](https://tailwindcss.com/blog/tailwindcss-v4) — CSS-first configuration, @theme blocks, auto content scanning
- [Laravel 12.x Vite Documentation](https://laravel.com/docs/12.x/vite) — @vite() directive, laravel-vite-plugin configuration, production builds
- [Laravel 12.x Blade Templates](https://laravel.com/docs/12.x/blade) — @extends, @section, @yield, @include patterns
- [Alpine.js Intersect Plugin](https://alpinejs.dev/plugins/intersect) — x-intersect directive, plugin registration
- npm registry (verified 2026-03-24): tailwindcss@4.2.2, @tailwindcss/vite@4.2.2, laravel-vite-plugin@3.0.0, alpinejs@3.15.8, @alpinejs/intersect@3.15.8, swiper@12.1.3, aos@2.3.4

### Secondary (MEDIUM confidence)

- [Deploying Laravel to Hostinger Shared Hosting — DEV Community](https://dev.to/pushpak1300/deploying-laravel7-app-on-shared-hosting-hostinger-31cj) — index.php path rewrite strategy, document root approaches
- [Deploy Laravel 11 to Hostinger Business Plan — DEV Community](https://dev.to/prakash_nayak/deploy-laravel-11-project-to-hostinger-business-plan-ea3) — hPanel document root configuration
- [Vite Manifest Not Found in Laravel — Laravel Daily](https://laraveldaily.com/post/laravel-vite-manifest-not-found-at-manifest-json) — production build pitfall documentation
- [Deploying Laravel on Shared Hosting Using .htaccess — GitHub Gist](https://gist.github.com/bladeSk/3666d04964e4de9c263776ba51f63a18) — .htaccess symlink approach
- [Hostinger PHP version guide](https://www.hostinger.com/tutorials/how-to-change-your-php-version) — PHP 8.2 ceiling as of Dec 2025

### Tertiary (LOW confidence — needs validation before Phase 1 execution)

- Hostinger current PHP 8.3 availability: undocumented post-December 2025 — verify in hPanel
- Hostinger SSH access on the specific plan in use — check hPanel before choosing deploy strategy

---

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH — all versions verified from npm registry 2026-03-24; official docs confirm compatibility
- Architecture: HIGH — all patterns sourced from Laravel 12 and Tailwind v4 official documentation
- Pitfalls: HIGH (deployment) / MEDIUM (Tailwind v4 CSS-first edge cases) — deployment pitfalls corroborated by multiple community sources; Tailwind v4 is recent enough that some edge cases may not be fully documented
- Validation: HIGH — manual verification steps are deterministic and cover all 10 requirements

**Research date:** 2026-03-24
**Valid until:** 2026-06-24 (90 days — stable stack with LTS support; Tailwind and laravel-vite-plugin versions may increment but APIs are stable)
