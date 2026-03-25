# Roadmap: Portfólio Pessoal — Ygor Stefankowski da Silva

## Overview

Four phases take the project from a blank Laravel install to a live, recruiter-ready portfolio on Hostinger. Phase 1 locks the asset pipeline and deployment path so no credentials are exposed at launch. Phase 2 builds every visible section with full responsive layout and animations. Phase 3 wires the contact form backend with real email delivery. Phase 4 applies SEO meta tags, runs production verification, and flips the site live.

## Phases

**Phase Numbering:**
- Integer phases (1, 2, 3): Planned milestone work
- Decimal phases (2.1, 2.2): Urgent insertions (marked with INSERTED)

Decimal phases appear between their surrounding integers in numeric order.

- [ ] **Phase 1: Foundation** - Laravel 12 + Vite + Tailwind v4 pipeline, Blade layout shell, routing, and verified Hostinger deployment path
- [ ] **Phase 2: Core UI Sections** - All five portfolio sections rendered, responsive, animated, with projects loaded from JSON
- [ ] **Phase 3: Contact Form Backend** - ContactController, Mailable, SMTP via transactional provider, validation, rate limiting
- [ ] **Phase 4: Polish and Deploy** - OG meta tags, production checklist executed, site live on Hostinger

## Phase Details

### Phase 1: Foundation
**Goal**: A working Laravel 12 application with the Tailwind v4 + Alpine.js + Vite asset pipeline verified locally and a tested, documented deployment path to Hostinger with the correct document root.
**Depends on**: Nothing (first phase)
**Requirements**: INFRA-01, INFRA-02, INFRA-03, INFRA-04, LAYOUT-01, LAYOUT-02, LAYOUT-03, LAYOUT-04, LAYOUT-05, VIS-04
**Success Criteria** (what must be TRUE):
  1. Running `npm run build` produces compiled CSS and JS under `public/build/` with no errors and the `@vite()` directive loads assets correctly in the browser
  2. The Blade layout (`layouts/app.blade.php`) renders at `GET /` with header, main, and footer visible; smooth-scroll nav links and mobile hamburger menu (Alpine.js) work at all breakpoints
  3. Google Fonts load correctly in a production build (no 404 or CORS errors)
  4. A deploy guide documents exactly how to configure Hostinger document root to `public/`, set `APP_DEBUG=false`, and verify that `yourdomain.com/.env` returns 403/404 — not file contents
**Plans**: 3 plans
Plans:
- [ ] 01-PLAN-A.md — Asset pipeline: Laravel project creation, Vite + Tailwind v4 + Alpine.js wiring, .env.example, projects.json stub
- [ ] 01-PLAN-B.md — Blade layout shell: routing, controller, layouts/app.blade.php, partials/nav.blade.php (hamburger), partials/footer.blade.php (back-to-top)
- [ ] 01-PLAN-C.md — Hostinger deploy guide: document root strategies, production .env config, security verification checklist
**UI hint**: yes

### Phase 2: Core UI Sections
**Goal**: All five portfolio sections — Hero, About, Skills, Projects, and Contact (form UI + social links) — render at `GET /` with full responsive layout, scroll animations, and project cards driven by `data/projects.json`.
**Depends on**: Phase 1
**Requirements**: HERO-01, HERO-02, HERO-03, HERO-04, ABOUT-01, ABOUT-02, ABOUT-03, ABOUT-04, SKILL-01, SKILL-02, SKILL-03, SKILL-04, PROJ-01, PROJ-02, PROJ-03, PROJ-04, PROJ-05, VIS-01, VIS-02, VIS-03, ASSET-01, ASSET-02, ASSET-03
**Success Criteria** (what must be TRUE):
  1. Visiting the site shows name, role ("Desenvolvedor Full Stack"), profile photo, and a CTA button in the hero; the About section shows personal bio text and a CV download button that triggers a PDF download
  2. The Skills carousel (Swiper.js) scrolls through technology cards with icons and names; pagination and autoplay work on mobile and desktop
  3. The Projects grid renders cards from `data/projects.json` — each card shows image, title, description, and tech tags; hovering a card reveals demo and repository links
  4. All sections have AOS scroll-triggered entrance animations; the back-to-top button appears on scroll and returns the user to the top smoothly
  5. The layout is responsive and correct at 320 px, 375 px, 768 px, and 1280 px — no horizontal overflow, no broken grids; dark theme with electric-blue accent is consistent across all interactive elements
**Plans**: 5 plans
Plans:
- [x] 02-A-PLAN.md — Dependency setup: npm install swiper + aos, rewrite app.js with DOMContentLoaded init, add Devicon CDN to layout, create placeholder assets
- [ ] 02-B-PLAN.md — Hero + About sections: name/role/photo/CTA in hero; bio/photo/CV-download in about; AOS animations on both
- [ ] 02-C-PLAN.md — Skills carousel: $skills array in PortfolioController, Swiper markup with Devicon icons and pagination
- [ ] 02-D-PLAN.md — Projects section: populate projects.json with schema + 4 sample entries, responsive grid with hover overlay cards
- [ ] 02-E-PLAN.md — Contact UI + visual checkpoint: form fields + social links in contact section, final build, human verification of all 5 sections
**UI hint**: yes

### Phase 3: Contact Form Backend
**Goal**: The contact form submits to `POST /contact`, validates input server-side, sends an email to the owner via a transactional SMTP provider, and returns success or error feedback — with rate limiting preventing abuse.
**Depends on**: Phase 2
**Requirements**: CONTACT-01, CONTACT-02, CONTACT-03, CONTACT-04, CONTACT-05, CONTACT-06
**Success Criteria** (what must be TRUE):
  1. Submitting the contact form with valid input (name, email, subject, message) delivers an email to the owner's inbox — confirmed from a production host, not only Mailtrap
  2. Submitting with invalid input (empty fields, malformed email) shows field-level error messages inline without losing other valid field values; no double-submission on page refresh (POST/Redirect/GET pattern)
  3. A visible success or error banner appears after form submission; the submit button is disabled while the request is in flight
  4. Sending more than 5 requests per minute from one IP returns a throttle error; GitHub, LinkedIn, WhatsApp, and Email social links are visible in the contact section and open correctly
**Plans**: TBD

### Phase 4: Polish and Deploy
**Goal**: The site is production-ready — OG meta tags generate correct rich previews on LinkedIn and WhatsApp, and the full production checklist (compiled assets, document root, debug off, real email test, `.env` protection) has been verified on Hostinger.
**Depends on**: Phase 3
**Requirements**: SEO-01, SEO-02
**Success Criteria** (what must be TRUE):
  1. Pasting the live URL into WhatsApp and LinkedIn generates a rich preview with the correct title, description, and image (OG tags verified via Open Graph debugger)
  2. The page `<title>` and `<meta name="description">` are set correctly and appear in browser tab and search result snippets
  3. Visiting `yourdomain.com/.env` returns 403 or 404; `APP_DEBUG` is `false`; `public/build/` is present and assets load with no 404 errors; a real contact form submission from production delivers email to owner's inbox
**Plans**: TBD

## Progress

**Execution Order:**
Phases execute in numeric order: 1 → 2 → 3 → 4

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Foundation | 2/3 | In Progress|  |
| 2. Core UI Sections | 1/5 | In Progress|  |
| 3. Contact Form Backend | 0/TBD | Not started | - |
| 4. Polish and Deploy | 0/TBD | Not started | - |

---
*Roadmap created: 2026-03-24*
*Coverage: 41/41 v1 requirements mapped — 0 orphans*
*Phase 1 plans created: 2026-03-24*
*Phase 2 plans created: 2026-03-24*
