---
phase: 01-foundation
plan: B
subsystem: blade-layout
tags: [laravel, blade, alpinejs, tailwind, routing, nav, footer]
dependency_graph:
  requires: [01-A (asset-pipeline, css-tokens, js-runtime)]
  provides: [blade-layout-shell, routing, nav-partial, footer-partial, home-page-stub]
  affects: [01-C, 02-hero, 02-about, 02-skills, 02-projects, 02-contact]
tech_stack:
  added:
    - PortfolioController (Laravel controller with File facade)
    - Blade layout inheritance (layouts/app -> pages/home)
    - Alpine.js x-data scoped components (nav hamburger, footer back-to-top)
    - Alpine intersect plugin (x-intersect:leave/enter for scroll sentinel)
  patterns:
    - Blade @extends/@section/@yield layout inheritance
    - Alpine x-data isolated scope per component (nav has its own open state)
    - Intersect sentinel pattern (1px div at top, x-intersect drives button visibility)
    - Tailwind CSS-first custom utility bg-accent from @theme token
key_files:
  created:
    - routes/web.php (replaced default welcome route)
    - app/Http/Controllers/PortfolioController.php
    - resources/views/layouts/app.blade.php
    - resources/views/pages/home.blade.php
    - resources/views/partials/nav.blade.php
    - resources/views/partials/footer.blade.php
  modified: []
decisions:
  - SESSION_DRIVER and CACHE_STORE switched to 'file' (SQLite PDO unavailable in dev env)
  - Stub partials created in Task 1 commit to satisfy HTTP 200 acceptance criteria, replaced in Task 2
metrics:
  duration_minutes: 4
  completed_date: "2026-03-24"
  tasks_completed: 2
  tasks_total: 2
  files_created: 6
  files_modified: 1
---

# Phase 1 Plan B: Blade Layout Shell and Routing Summary

**One-liner:** GET / route via PortfolioController, Blade layout shell with scroll-smooth + Alpine x-data body, sticky nav with Alpine hamburger, and footer with intersect-driven back-to-top button.

## What Was Built

### Task 1: Route, Controller, and Layout Shell

**routes/web.php** — Replaced Laravel's default welcome route with:
```php
Route::get('/', [PortfolioController::class, 'index'])->name('home');
```

**app/Http/Controllers/PortfolioController.php** — Controller that reads `data/projects.json` via `File::get()` and renders `pages.home` view with `$projects` collection. This wires Phase 1 to Phase 2's project data without Phase 2 needing to re-open the controller.

**resources/views/layouts/app.blade.php** — Master Blade layout with:
- `<html lang="pt-BR" class="scroll-smooth">` — CSS smooth scrolling, no JS library
- `@vite(['resources/css/app.css', 'resources/js/app.js'])` — exactly once in `<head>`
- `<body ... x-data>` — empty Alpine scope enabling child component scope inheritance
- `@include('partials.nav')` and `@include('partials.footer')`
- `<main>@yield('content')</main>`

**resources/views/pages/home.blade.php** — Extends layout with five section stubs:
- `#hero`, `#about`, `#skills`, `#projects`, `#contact` (all `min-h-screen`)
- Phase 2 fills content inside these sections without changing IDs or layout files

### Task 2: Nav Partial and Footer Partial

**resources/views/partials/nav.blade.php** — Sticky nav:
- Own Alpine scope: `x-data="{ open: false }"`
- Desktop: `hidden md:flex` nav links to all five section anchors
- Hamburger button: `md:hidden`, `@click="open = !open"`, SVG icons toggled via `x-show`
- Mobile menu: `x-show="open"` with enter/leave transitions; `@click="open = false"` on each link

**resources/views/partials/footer.blade.php** — Scroll sentinel + back-to-top:
- Sentinel: `id="scroll-sentinel"`, `x-data="{ show: false }"`, `x-intersect:leave="show = true"`, `x-intersect:enter="show = false"`, absolutely positioned 1x1px div at top
- Back-to-top button: `x-show="show"`, `fixed bottom-6 right-6`, `bg-accent` (from @theme token), `@click="window.scrollTo({ top: 0, behavior: 'smooth' })"` with enter/leave transitions
- Footer bar: copyright with `{{ date('Y') }}`

## Blade Inheritance Structure

```
layouts/app.blade.php  (master layout)
├── @include('partials.nav')     → resources/views/partials/nav.blade.php
├── <main>@yield('content')</main>
└── @include('partials.footer')  → resources/views/partials/footer.blade.php

pages/home.blade.php
└── @extends('layouts.app')
    └── @section('content')  [five section stubs]
```

## Alpine Patterns Used

| Pattern | File | Description |
|---------|------|-------------|
| Scoped x-data | nav.blade.php | `x-data="{ open: false }"` isolates hamburger state to nav component |
| x-show + @click | nav.blade.php | Hamburger toggles `open`; mobile links close menu via `@click="open = false"` |
| Intersect sentinel | footer.blade.php | `x-intersect:leave/enter` on a 1px div drives `show` boolean |
| x-show + transitions | footer.blade.php | Back-to-top button appears/disappears with scale+opacity transition |

## Verification Results

CLI checks:
1. `grep "PortfolioController" routes/web.php` — match (LAYOUT-01)
2. `grep "scroll-smooth" resources/views/layouts/app.blade.php` — match (LAYOUT-02)
3. `grep 'x-data="{ open: false }"' resources/views/partials/nav.blade.php` — match (LAYOUT-03)
4. `grep "x-intersect" resources/views/partials/footer.blade.php` — match (LAYOUT-04)
5. HTTP GET / returns 200 — confirmed
6. `npm run build` exits 0, 507ms — confirmed (LAYOUT-05 asset pipeline)

Checkpoint: Auto-approved (auto_advance=true) — all CLI verifications passed. Browser verification at next human interaction.

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 3 - Blocking] Stub partials required for Task 1 HTTP 200 verification**
- **Found during:** Task 1 verification
- **Issue:** `layouts/app.blade.php` includes partials that didn't exist yet, causing 500 on `GET /`. Task 1's acceptance criteria requires HTTP 200, but Task 2 creates the partials.
- **Fix:** Created minimal stub partials (`nav.blade.php`, `footer.blade.php`) in Task 1 commit. Task 2 replaced them with full implementations in the Task 2 commit.
- **Impact:** None — functionally equivalent. Task 2 commit contains the final production content.
- **Commit:** 1635d41 (stubs), b8934a2 (full implementation)

**2. [Rule 1 - Bug] SQLite PDO driver unavailable, causing HTTP 500 on all requests**
- **Found during:** Task 1 HTTP verification
- **Issue:** `.env` defaults `SESSION_DRIVER=database` and `CACHE_STORE=database`, both requiring SQLite PDO which is not installed in this environment. Laravel throws `could not find driver` on every request.
- **Fix:** Changed `SESSION_DRIVER=file` and `CACHE_STORE=file` in `.env`. This is appropriate for a development environment and has no impact on the portfolio's functionality (no user auth, no server-side caching requirements in Phase 1).
- **Files modified:** `.env` (gitignored — not committed)
- **Impact:** None for portfolio use case. File-based sessions are equivalent for Phase 1.

## Known Stubs

| File | Stub Content | Reason |
|------|-------------|--------|
| `resources/views/pages/home.blade.php` | Five placeholder sections with "Phase 2" text | Intentional — Phase 2 plans fill hero, about, skills, projects, contact with real content |

These stubs are intentional per the plan. `GET /` returns 200 and renders correctly; the placeholder text is expected in Phase 1.

## Self-Check: PASSED

Files verified:
- `C:/Users/Ygor/portifolio/routes/web.php` — exists
- `C:/Users/Ygor/portifolio/app/Http/Controllers/PortfolioController.php` — exists
- `C:/Users/Ygor/portifolio/resources/views/layouts/app.blade.php` — exists
- `C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php` — exists
- `C:/Users/Ygor/portifolio/resources/views/partials/nav.blade.php` — exists
- `C:/Users/Ygor/portifolio/resources/views/partials/footer.blade.php` — exists

Commits verified:
- `1635d41` — feat(01-foundation-B): add route, controller, layout shell, and partial stubs
- `b8934a2` — feat(01-foundation-B): build nav partial with Alpine hamburger and footer with intersect back-to-top
