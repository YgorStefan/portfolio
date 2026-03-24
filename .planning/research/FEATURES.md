# Feature Research

**Domain:** Personal developer portfolio website
**Researched:** 2026-03-24
**Confidence:** HIGH (multiple credible sources, consistent findings across recruiter surveys and community articles)

---

## Feature Landscape

### Table Stakes (Users Expect These)

Features recruiters and clients assume exist. Missing these = portfolio feels unprofessional or incomplete. No credit for having them, but immediate negative signal for missing them.

| Feature | Why Expected | Complexity | Notes |
|---------|--------------|------------|-------|
| Hero section with name + role + CTA | First 5 seconds must answer "who is this?" — if missing, visitors bounce | LOW | "Desenvolvedor Full Stack" + photo + "Entre em contato" or similar CTA button |
| About / bio section | Recruiters want to know the person behind the code — cold portfolio = no connection | LOW | 2-3 short paragraphs; trajectory, values, what you build |
| Projects showcase (3-5 projects) | A portfolio with no visible work is a resume, not a portfolio | MEDIUM | Each project: title, description, tech stack used, GitHub link, live demo link if exists |
| Skills / technologies section | Recruiters scan for stack compatibility before reading anything else | LOW | Visual grid or icon list; keep to ~12-15 technologies you actually use — avoid listing 40+ |
| Contact section with multiple options | Dead-end portfolio = lost opportunity; must lower friction to reach you | LOW | Form + email + GitHub + LinkedIn at minimum |
| Working contact form | Standard expectation in 2025 — email-only feels like 2010 | MEDIUM | Laravel Mail handles this; must confirm submission to user |
| GitHub link | #1 thing tech recruiters click after the project section | LOW | Prominent placement in nav or hero |
| LinkedIn link | Professional network verification; recruiters cross-reference | LOW | Social links cluster in hero/contact/footer |
| Mobile-responsive design | 60%+ of portfolio views are on mobile; broken mobile = immediate red flag for a web dev | MEDIUM | Tailwind makes this straightforward; test on 320px, 375px, 768px breakpoints |
| Smooth navigation (scroll / anchors) | Single-page portfolios require anchor links that work reliably | LOW | Smooth scroll CSS + active nav state highlight |
| Readable typography and color contrast | Dark themes can fail accessibility if contrast ratio is too low | LOW | Electric blue on dark bg: verify WCAG AA (4.5:1 ratio) for body text |
| Fast load time | Recruiters close slow pages without waiting; also signals technical competence | LOW | Optimize images, no blocking JS on load; target < 2s on 4G |
| No broken links / 404s | A broken portfolio link says "I don't maintain my work" | LOW | Test all project links, social links, and form submission before launch |

---

### Differentiators (Competitive Advantage)

Features that set the portfolio apart. Not expected, but noticed and valued. Align with core value: "memorable professional impression."

| Feature | Value Proposition | Complexity | Notes |
|---------|-------------------|------------|-------|
| Scroll-triggered entry animations | Elevates perceived quality; makes the portfolio feel "alive" without being distracting | MEDIUM | IntersectionObserver API or Alpine.js; fade-in/slide-in on section entry. Already planned. |
| CV / resume download button | 70%+ of recruiters want a hard copy; removing friction to get the resume = more applications processed | LOW | PDF download in hero or header; self-hosting the file in `/public/` |
| Project cards with hover overlay showing stack + links | Compact, information-dense; shows frontend competence in the portfolio itself | MEDIUM | CSS/Tailwind hover transition; overlay reveals tech badges + GitHub/demo links |
| Skills carousel (Swiper.js) | Visually engaging alternative to a static list; tech-specific visual identity | LOW | Already planned per visual reference. Swiper is well-maintained in 2025. |
| Live demo links on projects | "Show don't tell" — visitors can interact with actual work, not just screenshots | LOW | If projects are deployed; add badge stating "live" vs "archived" |
| WhatsApp direct contact link | Differentiator for Brazilian market specifically; clients prefer WhatsApp over email for initial contact | LOW | `wa.me/` link with pre-filled message; already planned |
| "Back to top" button | UX polish signal — shows attention to small details that matter | LOW | Already planned; visible after scroll past hero |
| Project tech stack badges per card | Recruiters scan for stack match instantly; inline badges are faster than reading descriptions | LOW | Tailwind badge components; driven by `projects.json` data |
| Consistent visual identity (dark + electric blue) | Memorable and "dev aesthetic" — stands out against beige/white portfolios | LOW | Already locked in via design decision |
| Performance score visible / documented | Some senior devs share Lighthouse scores as proof of craft — niche but impressive | LOW | Optional; add to README or About section |
| Section-level meta descriptions / OG tags | Allows portfolio link shared on LinkedIn/WhatsApp to render a rich preview | LOW | Single `<meta og:*>` block in Blade layout head |
| Testimonials / recommendations section | Social proof for freelance clients specifically; less important for job seekers | HIGH | Requires gathering real testimonials; defer to v1.x |

---

### Anti-Features (Deliberately NOT Building in v1)

Features that seem appealing but create problems disproportionate to their value.

| Feature | Why Requested | Why Problematic | Alternative |
|---------|---------------|-----------------|-------------|
| Blog / CMS | "Shows you can write and think deeply" | Requires regular content production; an empty or stale blog is worse than no blog; adds complexity without v1 value | Keep a link to a Medium/Dev.to profile if you already write there |
| Admin panel / project CRUD | "Makes updating easier" | Adds auth, database, session management, security surface — overkill for a JSON file | Edit `projects.json` directly; simple and already decided |
| Multi-language (PT/EN toggle) | "Reaches international market" | Doubles content maintenance burden; v1 audience is domestic (Brazil); translation quality matters | Ship in PT-BR, add EN in v1.x when there's a real international lead |
| Dark/light mode toggle | "Accessibility, personal preference" | Adds JavaScript state management + CSS variable overhead; dark theme is already the identity of this portfolio; toggle risks breaking the designed look | Commit to dark theme; it IS the brand; add `prefers-color-scheme` media query for OS respect if needed |
| Real-time notifications / WebSockets | Impressive technically | Zero value for a portfolio; adds infra complexity incompatible with shared hosting | Not applicable |
| Visitor analytics dashboard (custom) | "Know who's viewing your portfolio" | Build complexity; shared hosting constraint | Use free Plausible embed or Google Analytics GA4 snippet (2 lines) |
| Paginated projects | Appears thorough | Pagination on 5-10 projects is UX friction with no benefit; all projects should be visible on one scroll | Show all projects in a 2-3 column responsive grid |
| Portfolio password protection | "Private by invite" | Defeats the purpose of a public portfolio | Not applicable for this use case |
| 3D / WebGL hero | "Wow factor, tech flex" | Performance cost is high; distracts from content; maintenance burden when libs update | Subtle CSS animations achieve similar "alive" feeling with zero performance cost |

---

## Feature Dependencies

```
[Contact Form]
    └──requires──> [Laravel Mail config (SMTP/Mailtrap)]
                       └──requires──> [Environment variables on host]

[Projects Section]
    └──requires──> [projects.json schema defined]
                       └──enhances──> [Project cards with tech stack badges]
                                          └──enhances──> [Hover overlay with links]

[Skills Carousel]
    └──requires──> [Swiper.js loaded]

[Scroll animations]
    └──requires──> [IntersectionObserver (native) or Alpine.js]

[CV Download]
    └──requires──> [PDF file in /public/]

[Social links]
    └──requires──> [WhatsApp, GitHub, LinkedIn, Email values in config or .env]

[OG meta tags]
    └──enhances──> [Portfolio URL shareable on LinkedIn/WhatsApp]
    └──requires──> [Deployed domain finalized]
```

### Dependency Notes

- **Contact Form requires Laravel Mail config:** The form is the most deployment-sensitive feature. SMTP credentials must be set in `.env` on the production host. Test this early to avoid last-minute surprises.
- **Projects Section drives multiple features:** `projects.json` is the single source of truth for project cards, tech badges, links, and overlay data. Define its schema in Phase 1 so all downstream rendering is consistent.
- **OG meta tags require a deployed domain:** Can be stubbed with a placeholder during development but only fully valid after deploy. Low priority during build phase.
- **Scroll animations conflict with prefers-reduced-motion:** Wrap all animation triggers with a `prefers-reduced-motion` media query check to avoid accessibility issues.

---

## MVP Definition

### Launch With (v1)

Minimum to make a professional first impression and enable contact.

- [x] Hero section — name, role, photo, CTA button — answers "who is this?" in 3 seconds
- [x] About section — personal bio, trajectory
- [x] Skills section — visual grid/carousel of ~12-15 technologies
- [x] Projects section — 3-5 projects from `projects.json`, each with description + stack + GitHub link
- [x] Contact section — working form (Laravel Mail) + GitHub + LinkedIn + WhatsApp + Email
- [x] Mobile-responsive layout — test at 320px, 375px, 768px
- [x] Smooth scroll navigation — anchor links + active nav highlight
- [x] Back to top button
- [x] Scroll-triggered animations — section entry fade/slide
- [x] Social links throughout (hero + contact + footer)
- [x] CV download button — PDF in `/public/`
- [x] OG meta tags — rich preview when link is shared

### Add After Validation (v1.x)

Add when the portfolio is live and getting real traffic/feedback.

- [ ] English language version — when international opportunities arise
- [ ] Testimonials section — once 2-3 genuine testimonials are collected
- [ ] Analytics integration — GA4 snippet or Plausible embed once traffic is meaningful
- [ ] Live demo badges on project cards — as more projects get deployed

### Future Consideration (v2+)

Defer until there is a clear signal these are worth the investment.

- [ ] Blog section — only if you commit to writing regularly (3+ posts already drafted before building)
- [ ] Case studies — deeper write-ups per project when you have outcomes to report (metrics, client results)
- [ ] Admin panel — only if project list grows beyond 15 and JSON editing becomes painful

---

## Feature Prioritization Matrix

| Feature | User Value | Implementation Cost | Priority |
|---------|------------|---------------------|----------|
| Hero section | HIGH | LOW | P1 |
| Projects showcase | HIGH | MEDIUM | P1 |
| Contact form (Laravel Mail) | HIGH | MEDIUM | P1 |
| Mobile responsiveness | HIGH | MEDIUM | P1 |
| Skills section | HIGH | LOW | P1 |
| About section | HIGH | LOW | P1 |
| Social links | HIGH | LOW | P1 |
| CV download | HIGH | LOW | P1 |
| Smooth scroll nav | MEDIUM | LOW | P1 |
| Scroll animations | MEDIUM | MEDIUM | P1 |
| Back to top button | MEDIUM | LOW | P1 |
| OG / meta tags | MEDIUM | LOW | P1 |
| Project hover overlay | MEDIUM | MEDIUM | P2 |
| Tech stack badges per project | MEDIUM | LOW | P2 |
| Live demo links on projects | HIGH | LOW | P2 (depends on whether projects are deployed) |
| Testimonials section | MEDIUM | HIGH | P3 |
| Analytics (GA4 / Plausible) | LOW | LOW | P3 |
| Blog / CMS | LOW | HIGH | Out of scope v1 |
| Admin panel | LOW | HIGH | Out of scope v1 |
| Multi-language | LOW | MEDIUM | Out of scope v1 |

**Priority key:**
- P1: Must have for launch
- P2: Should have, add when possible
- P3: Nice to have, future consideration

---

## Competitor Feature Analysis

Reference portfolio: https://jhonatansousa.github.io/Portfolio/

| Feature | Reference Portfolio | Industry Standard (2025) | Ygor's Approach |
|---------|--------------------|--------------------------|-----------------------|
| Theme | Dark + colored accent (green) | Either; dark is trending | Dark + electric blue — keeps identity, differentiates from green reference |
| Skills display | Swiper carousel | Grid or carousel | Swiper carousel — matches reference, already planned |
| Projects | Grid with hover overlay | Grid with cards | Grid with hover overlay showing stack + links |
| Contact | Form + social links | Form + social links | Form (Laravel Mail) + GitHub + LinkedIn + WhatsApp + Email |
| Animations | Entry animations on scroll | Standard expectation in 2025 | IntersectionObserver or Alpine.js-driven |
| CV download | Not present in reference | Expected by 70%+ of recruiters | Add CV download in hero CTA — competitive advantage over reference |
| Backend | Static (GitHub Pages) | Static common; Laravel rare | Laravel — showcases PHP/backend skills directly; the portfolio IS a demo |
| Social links | GitHub, LinkedIn | GitHub + LinkedIn minimum | GitHub + LinkedIn + WhatsApp (BR market) + Email |

---

## Sources

- [How to Build a Frontend Developer Portfolio in 2025 — DEV Community](https://dev.to/siddheshcodes/frontend-developer-portfolio-tips-for-2025-build-a-stunning-site-that-gets-you-hired-3hga)
- [What Recruiters Look for in Developer Portfolios — Pesto](https://pesto.tech/resources/what-recruiters-look-for-in-developer-portfolios)
- [Web Developer Portfolio Inspiration and Examples — March 2025 — WeAreDevelopers](https://www.wearedevelopers.com/en/magazine/561/web-developer-portfolio-inspiration-and-examples-march-2025-561)
- [What Makes a Portfolio Actually Stand Out in 2025 — WebWave](https://webwave.me/blog/what-makes-a-portfolio-stand-out)
- [Five Development Portfolio Anti-Patterns — Nitor](https://nitor.com/en/articles/five-development-portfolio-anti-patterns-and-how-to-avoid-them)
- [15 Portfolio Mistakes to Avoid in 2025 — Fueler](https://fueler.io/blog/portfolio-mistakes-to-avoid)
- [Don't Waste Time on a Portfolio Website — Survey of 60+ Hiring Managers — Profy](https://profy.dev/article/portfolio-websites-survey)
- [Selecting Projects for Your Portfolio: What Recruiters Look For — Nucamp](https://www.nucamp.co/blog/coding-bootcamp-job-hunting-selecting-projects-for-your-portfolio-what-recruiters-look-for)
- [Dark Mode Web Design: SEO and UX Trends for 2025 — DesignInDC](https://designindc.com/blog/dark-mode-web-design-seo-ux-trends-for-2025/)
- Reference portfolio analyzed: https://jhonatansousa.github.io/Portfolio/

---
*Feature research for: Personal developer portfolio — Ygor Stefankowski da Silva*
*Researched: 2026-03-24*
