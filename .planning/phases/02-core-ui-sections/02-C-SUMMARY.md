---
phase: 02-core-ui-sections
plan: C
subsystem: skills-carousel
tags: [swiper, devicon, blade, controller, tailwind-v4, aos]
dependency_graph:
  requires: [02-A (swiper-runtime, devicon-cdn), 02-B (home.blade.php with hero/about)]
  provides: [skills-carousel-section, skills-controller-data]
  affects: [02-E (visual-checkpoint — skills section will be visible during browser verification)]
tech_stack:
  added: []
  patterns:
    - $skills array defined in controller (not blade) — single edit point for tech stack updates
    - .swiper-skills selector matches app.js new Swiper() init from Plan A
    - Devicon icon classes passed as data from controller array to blade @foreach
    - swiper-pagination placed as sibling of swiper-wrapper (not child) per Swiper DOM requirements
key_files:
  created: []
  modified:
    - app/Http/Controllers/PortfolioController.php ($skills array added, compact updated)
    - resources/views/pages/home.blade.php (#skills stub replaced with Swiper carousel section)
decisions:
  - Skills array lives in PortfolioController (not a config file or JSON) for simplicity — easy to edit, no extra file to manage
  - overflow-hidden on .swiper-skills container prevents slides from bleeding outside section during animation
  - swiper-pagination outside swiper-wrapper (sibling element) — required by Swiper's internal DOM structure
metrics:
  duration_minutes: 4
  completed_date: "2026-03-25"
  tasks_completed: 2
  tasks_total: 2
  files_created: 0
  files_modified: 2
---

# Phase 2 Plan C: Skills Carousel Summary

**One-liner:** PortfolioController $skills array (12 Devicon entries) wired to home.blade.php Swiper carousel using `.swiper-skills` selector that matches the Plan A app.js init target.

## What Was Built

### Task 1: Add $skills array to PortfolioController

**app/Http/Controllers/PortfolioController.php** — Added `$skills` array with 12 entries and updated `compact()`:

- Array contains 12 skill entries with `name` and `icon` keys
- Icon values are Devicon CSS class strings (e.g., `devicon-php-plain colored`)
- 12 entries satisfies Swiper `loop: true` constraint at all breakpoints — at `slidesPerView: 5` (1024px+), the constraint is `slides >= 5 * 2 = 10`
- Updated `compact('projects')` to `compact('projects', 'skills')` to pass both variables to the view
- Skills included: PHP, Laravel, JavaScript, TypeScript, Vue.js, MySQL, Git, Docker, TailwindCSS, HTML5, CSS3, Linux

### Task 2: Build Skills carousel section in home.blade.php

**resources/views/pages/home.blade.php** — Replaced `#skills` stub with full Swiper carousel section:

- Section background: `bg-bg-card` to alternate with `bg-bg-primary` (hero + about) for visual rhythm
- Section heading "Habilidades" with `data-aos="fade-up"` and accent underline bar
- Descriptive subtitle paragraph explaining the section purpose
- Swiper container: `class="swiper swiper-skills overflow-hidden"` with `data-aos="fade-up" data-aos-delay="100"`
  - `.swiper-skills` selector matches `new Swiper('.swiper-skills', ...)` in app.js from Plan A
  - `overflow-hidden` prevents slides from bleeding outside section during carousel motion
- `@foreach($skills as $skill)` renders one `swiper-slide` per skill entry
- Each card: `bg-bg-primary border border-gray-800 rounded-xl` with hover states `hover:border-accent/50 hover:-translate-y-1 transition-all duration-300`
- Devicon icon output: `<i class="{{ $skill['icon'] }} text-5xl"></i>` — classes come from controller array
- Skill name: `<span class="text-sm font-medium text-gray-300">{{ $skill['name'] }}</span>`
- `.swiper-pagination` div placed as sibling of `.swiper-wrapper` (not child) — Swiper requirement
- Sections #projects and #contact stubs remain untouched per plan scope

## Verification Results

All 6 checks passed:

| Check | Command | Result |
|-------|---------|--------|
| SKILL-03 compact | `grep "compact('projects', 'skills')"` | match |
| SKILL-01 swiper-skills | `grep "swiper-skills"` | 2 matches |
| SKILL-04 pagination | `grep "swiper-pagination"` | match |
| SKILL-02 foreach | `grep "@foreach.*skills"` | match |
| SKILL-02 icon output | `grep "skill\['icon'\]"` | match |
| VIS-02 data-aos | `grep "data-aos.*fade-up"` on skills elements | match |

## Key Decisions

| Decision | Rationale |
|----------|-----------|
| $skills in controller (not JSON file) | Simpler than a separate data file — controller is already the data layer for this view; one place to edit |
| 12 skill entries | Satisfies Swiper loop constraint at all breakpoints (minimum 10 for slidesPerView: 5 at 1024px) |
| overflow-hidden on .swiper-skills | Prevents slides from bleeding outside section bounds during carousel animation |
| swiper-pagination as sibling (not child) | Required by Swiper internal DOM — placing inside swiper-wrapper breaks pagination dots |

## Deviations from Plan

None — plan executed exactly as written.

## Known Stubs

None introduced by this plan. Previously documented stubs from Plans A and B remain:

| File | Content | Reason |
|------|---------|--------|
| `public/images/profile.jpg` | 148-byte JPEG placeholder (Plan A) | User must replace with real profile photo before deployment |
| `public/files/curriculo.pdf` | Text placeholder (Plan A) | User must replace with real CV PDF before deployment |
| About section bio text | Placeholder Portuguese bio (Plan B) | User must replace with real biography before deployment |

## Self-Check: PASSED

Files verified:
- `C:/Users/Ygor/portifolio/app/Http/Controllers/PortfolioController.php` — exists, contains compact('projects', 'skills'), 12 skill entries
- `C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php` — exists, contains swiper-skills, swiper-pagination, @foreach($skills), $skill['icon'] output

Commits verified:
- `6da128d` — feat(02-core-ui-sections-C): add $skills array to PortfolioController
- `c25839c` — feat(02-core-ui-sections-C): build Skills carousel section in home.blade.php
