# Project Research Summary

**Project:** Personal Developer Portfolio — Ygor Stefankowski da Silva
**Domain:** Laravel single-page portfolio site on Hostinger shared hosting
**Researched:** 2026-03-24
**Confidence:** HIGH

## Executive Summary

This is a single-page personal developer portfolio built with Laravel 12, Tailwind CSS v4, and vanilla Alpine.js — deployed to Hostinger shared hosting. The research is unusually well-documented because every major decision has a clear "right answer": PHP 8.2 on the host (do not target 8.3+), Vite for asset bundling (Mix is deprecated), Alpine.js for interactivity (no Vue/React needed), and a flat JSON file for project data (no database, no Eloquent, no Livewire). The architecture is two routes, five Blade partials, and one Mailable. There are no ambiguous technical choices in this project.

The recommended approach is to treat this as a server-rendered static site that happens to run on Laravel. The framework earns its place by showcasing backend PHP competence in the portfolio itself — the tech stack IS part of the pitch. All content is delivered in a single GET / response; the only dynamic behavior is the contact form POST. Projects live in a hand-edited JSON file. Every interactive UI element (mobile nav, scroll animations, skills carousel, back-to-top) is handled by Alpine.js and Swiper.js in the Vite bundle.

The key risks are concentrated in deployment, not development. Hostinger shared hosting has four gotchas that can break a correctly-written app on first deploy: wrong document root exposing `.env` (critical security), missing compiled `public/build/` (Vite manifest 404), `APP_DEBUG=true` leaking stack traces, and SMTP mail going to spam or timing out. All four must be addressed before the portfolio is publicly linked anywhere. Contact form reliability is the second risk area — synchronous SMTP on shared hosting is slow and deliverability is unpredictable without a transactional mail service.

---

## Key Findings

### Recommended Stack

Laravel 12 with Tailwind CSS v4 and Alpine.js 3 is the definitive stack for this project. The Vite + `laravel-vite-plugin` + `@tailwindcss/vite` pipeline replaces all legacy tooling (no Mix, no PostCSS config file, no `tailwind.config.js`). Tailwind v4's CSS-first configuration (`@import "tailwindcss"` and `@theme {}` blocks) is fully compatible with this pipeline. PHP must be pinned to `^8.2` in `composer.json` — Hostinger's shared hosting ceiling is 8.2 as of December 2025.

**Core technologies:**
- PHP 8.2 / Laravel 12: backend framework, routing, Blade templating, mail — LTS support until Feb 2027, minimum PHP version matches Hostinger ceiling
- Tailwind CSS v4.2: utility-first CSS, CSS-first config, up to 100x faster incremental builds via dedicated Vite plugin
- Alpine.js 3.15: declarative JS for all interactive UI elements — mobile nav, back-to-top, scroll animations via `@alpinejs/intersect` plugin
- Swiper.js 12.x: touch-enabled skills carousel — v12 uses plain CSS only, no SCSS needed, fully compatible with Tailwind v4
- AOS 2.3.4: scroll-triggered reveal animations — 8 KB, attribute-based, production-stable despite being unmaintained
- Vite 6 via `laravel-vite-plugin`: local dev server with hot reload; compile locally and upload `public/build/` — Node.js is not available on Hostinger

**What not to use:** Laravel Mix (deprecated), Livewire, Inertia.js, jQuery, Bootstrap CSS, queues, Eloquent/database, PHP 8.3+.

### Expected Features

Research from multiple recruiter surveys and community sources confirms a consistent feature expectation for developer portfolios in 2025. The portfolio must answer "who is this?" within 5 seconds and must lower friction to contact.

**Must have (table stakes) — missing any of these signals unprofessionalism:**
- Hero section (name, role, photo, CTA)
- About / bio section
- Projects showcase (3-5 projects with tech stack, GitHub links)
- Skills section (visual, ~12-15 technologies — not 40+)
- Contact form (Laravel Mail) with submission confirmation
- GitHub + LinkedIn + WhatsApp links (WhatsApp is Brazilian market differentiator)
- Mobile-responsive design (test at 320px, 375px, 768px)
- Smooth anchor navigation with active state
- Fast load time (< 2s on 4G)

**Should have (competitive differentiators):**
- CV / resume PDF download in hero (70%+ of recruiters want this — missing from reference portfolio)
- Scroll-triggered entry animations (section fade/slide via AOS or Alpine Intersect)
- Project cards with hover overlay showing stack badges + links
- Back-to-top button (UX polish signal)
- OG meta tags for rich link previews on LinkedIn/WhatsApp shares
- Skills Swiper carousel (already planned, matches reference design)

**Defer to v1.x (add after live validation):**
- Analytics (GA4 or Plausible snippet)
- English language version
- Testimonials section
- Live demo badges on project cards

**Out of scope for v1 — do not build:**
- Blog / CMS (empty blog is worse than no blog)
- Admin panel / project CRUD
- Dark/light mode toggle (dark is the brand identity — commit to it)
- Multi-language toggle
- 3D / WebGL hero effects

### Architecture Approach

The architecture is intentionally minimal: two routes (`GET /` and `POST /contact`), a single Blade layout extended by one home view that `@include`s five section partials, a `PortfolioController` that reads `data/projects.json` via `File::json(base_path(...))` and passes a Laravel collection to the view, and a `ContactController` that validates, sends mail synchronously, and redirects via POST/Redirect/GET. There is no database, no models, no Eloquent, no sessions beyond flash messages. All JavaScript behavior is client-side via the Vite bundle.

**Major components:**
1. `web.php` — two routes only: `GET /` and `POST /contact`
2. `PortfolioController` — reads `data/projects.json`, decodes to collection, passes to view
3. `ContactController` + `ContactMail` — validates POST, sends synchronous SMTP mail, redirects with flash
4. `layouts/app.blade.php` — single HTML shell with `@vite()` directive, `x-data` on body for Alpine scope
5. `partials/*.blade.php` — one file per section (hero, about, skills, projects, contact, nav)
6. `data/projects.json` — single source of truth for all project data (title, description, tags, URLs, image)
7. Vite pipeline — `resources/css/app.css` (Tailwind v4 entry) + `resources/js/app.js` (Alpine, Swiper, AOS) → `public/build/`

**Key patterns to follow:**
- Single route → single view with partials (not separate routes per section)
- POST/Redirect/GET for contact form (prevents duplicate submissions)
- `collect(json_decode(...))` in controller, not in Blade
- Never construct Tailwind class names dynamically (JIT purge will remove them)
- Alpine `x-intersect.once` for scroll animations (not raw `scroll` event listeners)

### Critical Pitfalls

1. **Vite manifest missing in production** — `public/build/` must be compiled locally (`npm run build`) and uploaded via FTP every deploy; Node.js is not available on Hostinger shared hosting. Never rely on running Vite on the server.

2. **Laravel source files exposed via wrong document root** — Hostinger's default web root is `public_html/`. The full Laravel app must NOT be placed there. Either upload the project above `public_html/` and update `index.php` paths, or configure the domain document root to point at `laravel/public/` via hPanel. Verify by visiting `yourdomain.com/.env` — it must return 403/404, never file contents.

3. **`APP_DEBUG=true` left enabled in production** — Production `.env` requires `APP_DEBUG=false` and `APP_ENV=production`. A debug-mode error exposes stack traces, file paths, and all environment variable values to visitors.

4. **Dynamic Tailwind class names purged in production build** — Never construct class strings via string concatenation (e.g., `` `bg-${color}-500` ``). Use full-string lookup maps. Store full class names in `projects.json`. This is the most common Tailwind production bug and looks fine in `npm run dev`.

5. **Contact emails going to spam or SMTP blocking the HTTP response** — Use a transactional mail service (Brevo free tier, Mailgun, or Resend — all have free plans) instead of raw Hostinger SMTP. Set `MAIL_FROM_ADDRESS` to a domain-matched address with SPF/DKIM configured. Wrap `Mail::send()` in try/catch and set a 10-second SMTP timeout to prevent 30-second hangs on the contact form response.

---

## Implications for Roadmap

Based on the dependency graph in ARCHITECTURE.md and the pitfall-to-phase mapping in PITFALLS.md, the natural build order groups into four phases.

### Phase 1: Foundation — Laravel Project Setup and Asset Pipeline

**Rationale:** Every other phase depends on this. Vite, Tailwind, and the Blade layout must be wired and verified before any feature work begins. The document root and deploy structure must be resolved in this phase — not retrofitted later — to avoid exposing credentials at launch.
**Delivers:** Working Laravel 12 app with Tailwind v4 + Alpine.js + Vite pipeline, `layouts/app.blade.php`, project directory structure, `data/projects.json` schema defined, and a tested deployment path to Hostinger with correct document root.
**Addresses features:** None yet — infrastructure only.
**Avoids pitfalls:** Vite manifest not found in production (Pitfall 1), document root exposure (Pitfall 2), APP_DEBUG in production (Pitfall 3), SSH/artisan unavailability (Pitfall 6).
**Research flag:** Standard patterns — well-documented Laravel 12 + Tailwind v4 install; skip phase-level research.

### Phase 2: Core UI Sections (Static Content)

**Rationale:** Once the pipeline is verified, build all content sections as static Blade partials. This phase has no backend dependencies beyond the layout. The `projects.json` schema defined in Phase 1 unlocks the projects partial.
**Delivers:** All five section partials rendering correctly at `GET /` — hero (name, role, photo, CTA, CV download button), about (bio), skills (Swiper carousel), projects (grid from JSON with tech badges and hover overlay), contact (form UI + social links). Mobile-responsive layout across all breakpoints. Smooth scroll navigation with active state.
**Uses stack elements:** Tailwind v4 utility classes, Swiper.js 12, AOS 2.3.4, Alpine.js `x-intersect` for scroll animations.
**Implements architecture:** `PortfolioController@index` reading JSON, all section partials, `@include` chain in `pages/home.blade.php`.
**Avoids pitfalls:** Dynamic Tailwind class purging (Pitfall 5) — establish full-string class maps in this phase before any dynamic component is written.
**Research flag:** Standard patterns — skip phase-level research.

### Phase 3: Contact Form (Backend Integration)

**Rationale:** The contact form is the only backend integration and the most deployment-sensitive feature. Isolating it to its own phase means the form is built, tested on Mailtrap in development, and verified against a real inbox in production before the portfolio goes live.
**Delivers:** Working `ContactController` + `ContactMail` Mailable, server-side validation with field-level error display, CSRF protection, rate limiting middleware (`throttle:3,1`), honeypot spam field, success/error flash messages, "Sending..." disabled button state on submit, and confirmed email delivery to owner's Gmail and Outlook inboxes (not just Mailtrap).
**Uses stack elements:** Laravel Mail (Symfony Mailer), transactional SMTP service (Brevo or Resend), `.env` configuration.
**Implements architecture:** POST/Redirect/GET pattern, `ContactMail` Mailable, `emails/contact.blade.php` template.
**Avoids pitfalls:** SMTP blocking page response (Pitfall 4), contact emails going to spam (Pitfall 7), CSRF 419 errors, form double-submission.
**Research flag:** May need lightweight research on transactional mail service setup (Brevo vs Resend free tier limits) — low complexity but worth confirming current API before coding.

### Phase 4: Polish, OG Tags, and Production Deploy

**Rationale:** Final cross-cutting concerns that require the full site to exist before they can be properly implemented and verified. OG tags need a final domain. Mobile testing requires real content. Production deploy verification needs all previous phases complete.
**Delivers:** OG/Twitter meta tags, `prefers-reduced-motion` CSS overrides for all animations, mobile testing on real devices (320px, 375px), performance verification (Lighthouse, image optimization, WebP conversion), production deploy checklist executed (compile assets locally, upload `public/build/`, verify document root, verify `APP_DEBUG=false`, send real test email from production host, verify `.env` returns 403).
**Addresses features:** OG meta tags, back-to-top button (final polish pass), CV PDF in `public/`.
**Avoids pitfalls:** All infrastructure pitfalls via the "Looks Done But Isn't" checklist from PITFALLS.md.
**Research flag:** Standard patterns — skip phase-level research.

### Phase Ordering Rationale

- Phase 1 before everything: Vite/Tailwind pipeline must be verified before any CSS or JS is written. Document root decision must be made before any credential is placed on the server.
- Phase 2 before Phase 3: The contact form partial UI (Phase 2) must exist before the controller (Phase 3) can be wired to it. More importantly, the Tailwind class-purging discipline must be established in Phase 2 so the dynamic badge colors in projects cards do not silently break.
- Phase 3 isolated: Mail integration is the only feature that requires external service credentials and DNS configuration. Isolating it prevents credential debugging from blocking UI work.
- Phase 4 last: OG tags need a real domain. Mobile testing is most reliable when content is final. Production deploy verification is the final gate.

### Research Flags

Phases likely needing deeper research during planning:
- **Phase 3 (Contact Form):** Confirm current Brevo vs Resend free tier limits and Laravel 12 SMTP configuration for each — minor but worth a quick lookup before coding to avoid switching providers mid-phase.

Phases with standard patterns (skip research-phase):
- **Phase 1:** Laravel 12 + Tailwind v4 + Vite install is fully documented in official docs with step-by-step guides.
- **Phase 2:** All UI patterns (Swiper, AOS, Alpine Intersect, Tailwind responsive grid) have clear documentation and examples from ARCHITECTURE.md.
- **Phase 4:** Production deploy checklist is fully enumerated in PITFALLS.md — no new research needed.

---

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Stack | HIGH | All core technology choices backed by official docs and release notes; only uncertainty is exact Hostinger PHP version ceiling (verify in hPanel before deploy — MEDIUM on that specific point) |
| Features | HIGH | Multiple recruiter surveys and community sources with consistent findings; CV download and WhatsApp link are well-supported differentiators for the BR market |
| Architecture | HIGH | All patterns sourced from Laravel 12 official docs; two-route architecture is battle-tested for single-page portfolio sites; JSON-for-projects is explicitly documented as the correct approach for this scale |
| Pitfalls | HIGH (deployment) / MEDIUM (Vite/Tailwind v4 specifics) | Deployment pitfalls sourced from multiple corroborating community posts; Tailwind v4 JIT purge behavior is documented but v4 is recent enough that some edge cases may surface |

**Overall confidence:** HIGH

### Gaps to Address

- **Hostinger PHP version ceiling:** Research documents PHP 8.2 support as of December 2025. Verify the exact version available in hPanel before pinning `composer.json` — if 8.3 is now available, it can be targeted safely.
- **Transactional mail service selection:** Research identifies Brevo, Mailgun, and Resend as viable options but does not verify current free tier limits or Laravel 12 driver availability for each. Confirm before Phase 3 begins.
- **Swiper initialization order with Alpine:** PITFALLS.md flags a timing gotcha — Swiper must be initialized after Alpine has mounted the DOM. The `document.addEventListener('alpine:init')` pattern is noted as the solution but is not validated against the specific version combination (Alpine 3.15 + Swiper 12). Verify during Phase 2 implementation.
- **`projects.json` file path on Hostinger:** `base_path('data/projects.json')` works locally. Verify the resolved path is correct under Hostinger's directory structure before launch (PITFALLS.md notes this as a "Looks Done But Isn't" item).

---

## Sources

### Primary (HIGH confidence)
- [Laravel 12 Release Notes](https://laravel.com/docs/12.x/releases) — PHP requirements, Vite integration, Mail
- [Laravel 12.x Routing, Blade, Mail, Vite docs](https://laravel.com/docs/12.x/) — all architecture patterns
- [Tailwind CSS v4.0 Blog Post](https://tailwindcss.com/blog/tailwindcss-v4) — v4 CSS-first config, Vite plugin
- [Tailwind CSS Laravel Install Guide](https://tailwindcss.com/docs/guides/laravel) — official integration
- [Swiper v12 Blog](https://swiperjs.com/blog/swiper-v12) — v12 breaking changes (CSS-only styles)
- [Alpine.js Intersect Plugin](https://alpinejs.dev/plugins/intersect) — scroll animation pattern

### Secondary (MEDIUM confidence)
- [DEV Community — Deploying Laravel to Hostinger](https://dev.to/pushpak1300/deploying-laravel7-app-on-shared-hosting-hostinger-31cj) — document root and artisan workarounds
- [Vite Manifest Not Found in Laravel — Laravel Daily](https://laraveldaily.com/post/laravel-vite-manifest-not-found-at-manifest-json) — production build pitfall
- [Ash Allen Design — Reading JSON Files in Laravel](https://ashallendesign.co.uk/blog/reading-json-files-in-laravel) — JSON data pattern
- [Mailtrap — Laravel Contact Form Tutorial](https://mailtrap.io/blog/laravel-contact-form/) — contact form architecture
- [LaravelSMTP — Preventing Emails from Going to Spam](https://www.laravelsmtp.com/blog/preventing-laravel-emails-from-going-to-spam-folders) — deliverability
- [Perficient — Tailwind CSS Safelist](https://blogs.perficient.com/2025/08/19/understanding-tailwind-css-safelist-keep-your-dynamic-classes-safe/) — dynamic class purge
- [Recruiter survey sources — Pesto, Profy, Nucamp, Fueler, WebWave, DesignInDC](https://pesto.tech/resources/what-recruiters-look-for-in-developer-portfolios) — feature expectations
- [Hostinger PHP version guide](https://www.hostinger.com/tutorials/how-to-change-your-php-version) — PHP 8.2 ceiling

### Tertiary (LOW confidence — needs validation)
- Hostinger SSH access availability on specific plan tiers — needs verification against current hPanel for the exact plan in use
- Brevo / Resend free tier limits for Laravel 12 — needs verification before Phase 3

---
*Research completed: 2026-03-24*
*Ready for roadmap: yes*
