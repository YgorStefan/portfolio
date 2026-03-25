---
phase: 02-core-ui-sections
plan: A
subsystem: js-dependencies-and-assets
tags: [swiper, aos, devicon, placeholder-assets, vite, app-js]
dependency_graph:
  requires: [01-A (asset-pipeline), 01-B (blade-layout)]
  provides: [swiper-runtime, aos-runtime, devicon-cdn, placeholder-profile-photo, placeholder-cv-pdf, projects-image-dir]
  affects: [02-B (hero), 02-C (skills-carousel), 02-D (projects), 02-E (contact)]
tech_stack:
  added:
    - swiper@12.1.3 (modular import — Pagination + Autoplay modules)
    - aos@2.3.4 (scroll animation library)
  patterns:
    - Swiper CSS imported in app.js (not app.css) to avoid Tailwind v4 cascade ordering issues
    - AOS.init() and new Swiper() wrapped in DOMContentLoaded to avoid Vite timing pitfall
    - Devicon loaded from jsDelivr CDN (no npm package needed)
key_files:
  created:
    - public/images/projects/.gitkeep
    - public/files/curriculo.pdf
    - public/images/profile.jpg
  modified:
    - resources/js/app.js (added Swiper + AOS imports and DOMContentLoaded init)
    - resources/views/layouts/app.blade.php (added Devicon CDN link)
    - package.json (added swiper@12.1.3, aos@2.3.4)
decisions:
  - Swiper CSS imported in app.js to prevent Tailwind v4 cascade issues
  - Both AOS.init() and new Swiper() wrapped in DOMContentLoaded (module scope silently fails in Vite)
  - Devicon served from CDN (jsDelivr) rather than npm to keep bundle size down
  - profile.jpg placeholder created via Python minimal JPEG bytes (PHP GD unavailable in this env)
metrics:
  duration_minutes: 5
  completed_date: "2026-03-25"
  tasks_completed: 2
  tasks_total: 2
  files_created: 3
  files_modified: 3
---

# Phase 2 Plan A: JS Dependencies and Placeholder Assets Summary

**One-liner:** Swiper@12.1.3 + AOS@2.3.4 installed and wired into app.js with DOMContentLoaded guard, Devicon CDN added to layout head, and placeholder profile photo/CV/projects directory created in public/.

## What Was Built

### Task 1: Install Swiper + AOS and rewrite app.js

Installed `swiper@12.1.3` and `aos@2.3.4` via npm. Replaced the entire content of `resources/js/app.js`:

- Modular Swiper import: `import Swiper from 'swiper'` + `{ Pagination, Autoplay }` modules
- Swiper CSS imported in JS: `import 'swiper/css'` and `import 'swiper/css/pagination'`
- AOS import: `import AOS from 'aos'` and `import 'aos/dist/aos.css'`
- Both `AOS.init()` and `new Swiper('.swiper-skills', {...})` wrapped in `DOMContentLoaded` listener
- Alpine.js initialization preserved before the DOMContentLoaded block
- `npm run build` exits 0 — 43 modules transformed in 564ms

**Why DOMContentLoaded:** Calling `AOS.init()` or `new Swiper()` at ES module scope silently fails in Vite because the DOM is not ready when the module evaluates. The guard ensures the carousel selector `.swiper-skills` and all AOS-annotated elements exist before initialization.

**Why Swiper CSS in JS:** Importing Swiper CSS inside `app.js` ensures it is processed after Tailwind v4's cascade. Importing in `app.css` would risk cascade order conflicts where Tailwind resets override Swiper's required styles.

### Task 2: Devicon CDN and placeholder assets

**resources/views/layouts/app.blade.php** — Added Devicon CDN link immediately after the `@vite(...)` directive in `<head>`:
```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
```

**public/images/projects/.gitkeep** — Empty file to track the projects image directory in git.

**public/files/curriculo.pdf** — Text placeholder file. User must replace with their real CV PDF before deployment.

**public/images/profile.jpg** — Minimal valid JPEG placeholder (148 bytes). User must replace with their real profile photo before deployment.

## Key Decisions

| Decision | Rationale |
|----------|-----------|
| Swiper CSS in app.js | Avoids Tailwind v4 cascade ordering issues — Tailwind resets can override Swiper styles if CSS import order is wrong |
| DOMContentLoaded guard | Vite module evaluation happens before DOMContentLoaded; calling Swiper/AOS at module scope silently fails |
| Devicon via CDN | No npm package needed — CDN reduces bundle size, icons load from jsDelivr |
| profile.jpg via Python bytes | PHP GD extension unavailable in this dev environment; Python creates a minimal valid JPEG without external deps |

## Verification Results

All 6 final checks passed:

1. `npm run build` — exits 0, 43 modules, 566ms
2. `grep "DOMContentLoaded" resources/js/app.js` — match
3. `grep "cdn.jsdelivr.net/gh/devicons" resources/views/layouts/app.blade.php` — match
4. `ls public/images/profile.jpg` — file exists
5. `ls public/files/curriculo.pdf` — file exists
6. `ls public/images/projects/` — directory exists with .gitkeep

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 1 - Bug] PHP GD extension unavailable for profile.jpg creation**
- **Found during:** Task 2
- **Issue:** The plan specified using `php -r "imagecreatetruecolor(...)"` to create a placeholder JPEG. PHP GD (`ext-gd`) is not installed in this environment — the command exited 255 with "Call to undefined function imagecreatetruecolor()".
- **Fix:** Used Python to write a 148-byte minimal valid JPEG directly to `public/images/profile.jpg`. The file is a valid JPEG that browsers will load without 404 errors.
- **Impact:** None — the placeholder fulfills its purpose (preventing 404s on `<img src="/images/profile.jpg">`). User must replace with their real photo before deployment regardless.
- **Files modified:** `public/images/profile.jpg`
- **Commit:** a8651de

## Known Stubs

| File | Content | Reason |
|------|---------|--------|
| `public/images/profile.jpg` | 148-byte minimal JPEG placeholder | PHP GD unavailable; user must replace with real profile photo before Phase 4 deployment |
| `public/files/curriculo.pdf` | Text placeholder file | User must replace with real CV PDF before Phase 4 deployment |

These stubs are intentional and documented in the plan. They prevent 404 errors in Plans B-E while real assets are pending user upload.

## Self-Check: PASSED

Files verified:
- `C:/Users/Ygor/portifolio/resources/js/app.js` — exists, contains DOMContentLoaded + AOS.init + new Swiper
- `C:/Users/Ygor/portifolio/resources/views/layouts/app.blade.php` — exists, contains Devicon CDN link
- `C:/Users/Ygor/portifolio/public/images/profile.jpg` — exists
- `C:/Users/Ygor/portifolio/public/files/curriculo.pdf` — exists
- `C:/Users/Ygor/portifolio/public/images/projects/.gitkeep` — exists
- `C:/Users/Ygor/portifolio/package.json` — contains swiper@^12.1.3 and aos@^2.3.4

Commits verified:
- `6f326de` — feat(02-core-ui-sections-A): install Swiper + AOS and rewrite app.js with DOMContentLoaded init pattern
- `a8651de` — feat(02-core-ui-sections-A): add Devicon CDN to layout and create placeholder assets
