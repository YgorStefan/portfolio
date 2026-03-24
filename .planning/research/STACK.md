# Stack Research

**Domain:** Personal developer portfolio (Laravel + Tailwind CSS + vanilla JS)
**Researched:** 2026-03-24
**Confidence:** HIGH (core stack), MEDIUM (Hostinger PHP version ceiling)

---

## Recommended Stack

### Core Technologies

| Technology | Version | Purpose | Why Recommended |
|------------|---------|---------|-----------------|
| PHP | 8.2.x | Server runtime | Laravel 12 minimum requirement. Hostinger shared hosting is confirmed to support up to 8.2 as of Dec 2025 — do NOT target 8.3 or 8.4 yet; risk of host mismatch on deploy. |
| Laravel | 12.x | Backend framework, routing, Blade templating, Mail | Released Feb 24, 2025. LTS-equivalent support until Feb 2027. Minimal breaking changes from 11.x. Ships with Vite integration and Blade out of the box — no Livewire or Inertia needed for a static portfolio. |
| Tailwind CSS | 4.2.x | Utility-first CSS framework | v4 is the current stable release (launched Jan 22, 2025, current 4.2.2). CSS-first configuration (no `tailwind.config.js` by default), automatic content detection, and a dedicated `@tailwindcss/vite` plugin for zero-friction Laravel/Vite integration. Up to 100x faster incremental builds. |
| Vite | 6.x (via laravel-vite-plugin) | Asset bundler / dev server | Laravel 12's default bundler. The `laravel-vite-plugin` v3.0.0 wires Vite to Blade with hot-reload and asset fingerprinting out of the box. Replaces Laravel Mix entirely. |

### Supporting Libraries

| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| Alpine.js | 3.15.x | Lightweight reactive JS for Blade templates | Use for all interactive UI elements: mobile nav toggle, smooth scroll behavior, "back to top" button visibility, contact form state (loading/success/error). Drop-in via npm. No build step required if loaded via CDN for simple cases. |
| Swiper.js | 12.x | Touch-enabled carousel / slider | Use for the Skills section carousel. v12 (Sep 2025) removed SCSS/Less sources — all styles are plain CSS via `swiper/css`. Import `swiper/css` and `swiper/css/pagination` in `app.css`. Customize colors via CSS custom properties (`--swiper-theme-color`). |
| AOS (Animate on Scroll) | 2.3.4 | Scroll-triggered reveal animations | Use for fade/slide-in effects on section elements (About, Skills, Projects cards, Contact). 8 KB gzipped. Simple attribute-based API (`data-aos="fade-up"`). WARNING: original package is unmaintained (last release 7 years ago) — but it is production-stable and widely used. See notes below. |
| @tailwindcss/vite | 4.2.x | Tailwind v4 Vite plugin | Required for Tailwind v4 integration in Laravel. Replaces PostCSS config. Add to `vite.config.js` as a plugin. |

### Development Tools

| Tool | Purpose | Notes |
|------|---------|-------|
| Vite (via npm) | Dev server + production build | Run `npm run dev` locally; `npm run build` generates versioned assets in `public/build/`. No watch needed on shared hosting. |
| Laravel Artisan | Route caching, config caching for production | Run `php artisan config:cache` and `php artisan route:cache` after deploy on Hostinger to speed up the app. |
| Laravel Mail (Symfony Mailer) | Contact form email dispatch | Built into Laravel 12. Use synchronous `Mail::to()->send()` (no queue) for shared hosting. Configure via SMTP credentials from Hostinger cPanel email account. |
| Composer | PHP dependency manager | Required for Laravel. Hostinger shared hosting supports Composer via SSH terminal. |

---

## Installation

```bash
# Create new Laravel 12 project
composer create-project laravel/laravel portfolio

# Install Tailwind CSS v4 with Vite plugin
npm install tailwindcss @tailwindcss/vite

# Install Alpine.js
npm install alpinejs

# Install Swiper
npm install swiper

# Install AOS
npm install aos

# Dev dependencies (already included in Laravel scaffold)
npm install -D vite laravel-vite-plugin
```

### vite.config.js (key configuration)

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, // auto-reload on Blade changes in dev
        }),
        tailwindcss(),
    ],
});
```

### resources/css/app.css (Tailwind v4 — CSS-first)

```css
@import "tailwindcss";
@import "swiper/css";
@import "swiper/css/pagination";
@import "aos/dist/aos.css";

@theme {
    --color-accent: #2563eb; /* electric blue */
}
```

### resources/js/app.js

```js
import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import AOS from 'aos';

window.Alpine = Alpine;
Alpine.start();

AOS.init({ once: true, duration: 700 });

// Swiper initialized per-component in Blade or inline script
```

---

## Alternatives Considered

| Recommended | Alternative | When to Use Alternative |
|-------------|-------------|-------------------------|
| Alpine.js | Vue 3 / React | Only if the portfolio requires client-side routing or complex state (it doesn't). Vue/React add hundreds of KB and require Inertia for SSR — overkill for a static portfolio. |
| Alpine.js | Vanilla JS only | Acceptable for a very simple portfolio. Alpine is preferred because it gives clean declarative syntax for toggle/show behavior without writing imperative DOM code. |
| Tailwind CSS v4 | Tailwind CSS v3 | Use v3 only if you have legacy plugins or a `tailwind.config.js` you need to preserve. v4 has a migration tool and is the forward-looking choice. |
| AOS 2.3.4 | GSAP + ScrollTrigger | GSAP is superior for timeline animations and complex sequences. For a portfolio needing basic "fade in when visible," AOS is 5x smaller (8 KB vs 48 KB) and zero-config. Use GSAP if the design calls for staggered text animations, parallax, or morphing effects. |
| AOS 2.3.4 | @reimujs/aos | Modern TypeScript rewrite of AOS, 5.7 KB. Use if bundle size is critical or if the IntersectionObserver API behavior of the original AOS causes issues. Caveat: v0.1.3 is pre-1.0 and API compatibility is not guaranteed. |
| Swiper 12.x | Splide.js | Splide is fully accessible (WCAG 2.1 AA) and 30 KB. Use instead of Swiper if accessibility audit is a hard requirement. For a personal portfolio, Swiper 12 is the ecosystem default. |
| Laravel Mail (SMTP) | Mailgun / Resend API | API-based mailers are more reliable and bypass SMTP port blocking. Use Mailgun or Resend if Hostinger's SMTP (port 465/587) is rate-limited or blacklisted. Free tiers available on both. |
| Vite | Laravel Mix (webpack) | Mix is deprecated. Do not use it for new Laravel 12 projects. Vite is the official replacement. |

---

## What NOT to Use

| Avoid | Why | Use Instead |
|-------|-----|-------------|
| Laravel Mix | Deprecated as of Laravel 10; removed from starter kits. webpack-based, slow builds, no longer receives updates. | Vite + `laravel-vite-plugin` |
| Livewire | Full-stack reactive components requiring websockets or polling. Adds complexity (Livewire runtime, component classes) for no benefit on a static portfolio where all content is server-rendered once. | Blade templates + Alpine.js |
| Inertia.js | SPA adapter for Vue/React/Svelte. Unnecessary if you're not using a JS framework. Adds a full client-side router layer. | Plain Blade routing |
| jQuery | Outdated. Alpine.js and vanilla JS cover all required interactivity. Adds ~87 KB with no benefit over modern alternatives. | Alpine.js + vanilla JS |
| Bootstrap CSS | Conflicts with Tailwind's reset. Mixing the two causes specificity wars. Design system is Tailwind-based. | Tailwind CSS v4 exclusively |
| PHP 8.3 or 8.4 as target | Hostinger shared hosting is documented at PHP 8.2 ceiling as of Dec 2025. Targeting higher versions risks deploy failures. | PHP 8.2 — specify in `composer.json` `"php": "^8.2"` |
| Queues for contact form | Shared hosting does not support process supervisors (Supervisor, systemd) needed to run `php artisan queue:work`. Synchronous mail send is the correct approach. | `Mail::to()->send()` directly in controller |
| Database / Eloquent for projects | Adds schema migration complexity and DB credentials management on shared hosting for no benefit. Projects are static data. | `projects.json` read via `Storage::disk('local')` or `File::get()` |

---

## Stack Patterns by Variant

**If Hostinger supports PHP 8.3+ (verify in hPanel before deploy):**
- Bump `"php": "^8.3"` in `composer.json`
- No other changes needed — Laravel 12 is fully compatible with 8.3 and 8.4

**If SMTP port is blocked on Hostinger (common with port 587):**
- Switch `MAIL_PORT=465` with `MAIL_ENCRYPTION=ssl`
- Or switch `MAIL_MAILER=resend` / `MAIL_MAILER=mailgun` using a free API tier
- Laravel 12 ships with Resend support natively

**If animations feel heavy on mobile:**
- Disable AOS on `prefers-reduced-motion` via CSS: `@media (prefers-reduced-motion: reduce) { [data-aos] { opacity: 1 !important; transform: none !important; } }`
- AOS has a `disable` callback option: `AOS.init({ disable: 'mobile' })`

**If the Skills carousel needs to be a grid on mobile instead of carousel:**
- Use Swiper's `breakpoints` config to show 1 slide on mobile and switch to a Tailwind grid layout above `md:`
- Or use CSS Grid with `overflow-x: auto` and Tailwind `snap-x` as a no-JS fallback

---

## Version Compatibility

| Package | Compatible With | Notes |
|---------|-----------------|-------|
| Laravel 12.x | PHP ^8.2 | PHP 8.1 is dropped. Do not use PHP 8.1 on Hostinger. |
| Tailwind CSS 4.2.x | `@tailwindcss/vite` 4.2.x | These two must be on the same version. Install together: `npm install tailwindcss @tailwindcss/vite`. |
| `laravel-vite-plugin` 3.0.0 | Vite 6.x | v3.0.0 drops Node 18 support; requires Node 20+. Verify local Node version. |
| Alpine.js 3.15.x | Any modern browser | No IE11 support (not a concern for a developer portfolio). |
| Swiper 12.x | Vanilla JS, no framework required | v12 uses standard CSS only — no SCSS/Less preprocessor needed. Tailwind v4 CSS-first approach is fully compatible. |
| AOS 2.3.4 | Vanilla JS + IntersectionObserver API | IntersectionObserver is supported in all modern browsers. IE11 not supported (acceptable). |

---

## Hostinger Shared Hosting — Deployment Constraints

These constraints directly influence stack choices above:

1. **Document root** must point to `laravel/public/`. In Hostinger hPanel: Hosting > Manage > PHP Configuration > set Document root to `/home/user/domains/yourdomain.com/public_html/public` — OR — upload the project one level above `public_html` and update `public/index.php` paths.
2. **No process supervisors**: No queue workers. All operations must be synchronous.
3. **PHP version**: Confirmed support up to 8.2 as of Dec 2025. Verify before deploy.
4. **Composer**: Available via SSH terminal (`composer install --no-dev`).
5. **Node.js not available on server**: Run `npm run build` locally and upload the compiled `public/build/` directory. Do NOT run Vite on the shared host.
6. **`.env` file**: Must be manually created on the server (do not commit `.env` to git). Set `APP_ENV=production`, `APP_DEBUG=false`.

---

## Sources

- [Laravel 12 Release Notes](https://laravel.com/docs/12.x/releases) — PHP requirements, release date, support timeline (HIGH confidence)
- [Tailwind CSS v4.0 Blog Post](https://tailwindcss.com/blog/tailwindcss-v4) — v4 features, CSS-first config, Vite plugin (HIGH confidence)
- [Tailwind CSS Laravel Install Guide](https://tailwindcss.com/docs/guides/laravel) — Official integration steps (HIGH confidence)
- [Swiper v12 Blog](https://swiperjs.com/blog/swiper-v12) — v12 breaking changes, CSS-only styles, September 2025 release (HIGH confidence)
- [Alpine.js npm](https://www.npmjs.com/package/alpinejs) — v3.15.8 as current release (HIGH confidence)
- [AOS npm](https://www.npmjs.com/package/aos) — v2.3.4, last published 7 years ago, production-stable (MEDIUM confidence — unmaintained but widely deployed)
- [laravel-vite-plugin npm](https://www.npmjs.com/package/laravel-vite-plugin) — v3.0.0 current (HIGH confidence)
- [Hostinger PHP version guide](https://www.hostinger.com/tutorials/how-to-change-your-php-version) — PHP 8.2 ceiling documented Dec 2025 (MEDIUM confidence — check hPanel directly before deploy)
- WebSearch: Hostinger Laravel deployment patterns — `.htaccess` rewrite and document root approaches (MEDIUM confidence — multiple corroborating sources)

---
*Stack research for: Personal developer portfolio (Laravel + Tailwind CSS)*
*Researched: 2026-03-24*
