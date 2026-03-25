# Phase 2: Core UI Sections — Research

**Researched:** 2026-03-24
**Domain:** Laravel Blade UI, Swiper.js carousel, AOS scroll animations, Tailwind v4 dark theme, portfolio section patterns
**Confidence:** HIGH

---

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|------------------|
| HERO-01 | Exibe nome completo e cargo (Desenvolvedor Full Stack) | Tailwind v4 typography utilities; Blade template pattern |
| HERO-02 | Exibe foto de perfil ou imagem com overlay | public/images/ asset path; Tailwind aspect-ratio + object-cover |
| HERO-03 | Botão CTA para contato ou download de CV | Tailwind button pattern; `href="#contact"` OR `href="/files/curriculo.pdf"` |
| HERO-04 | Animação de entrada nos elementos do hero | AOS `data-aos="fade-up"` with staggered delays |
| ABOUT-01 | Texto pessoal com trajetória e objetivo profissional | Static Blade content; Tailwind prose-style classes |
| ABOUT-02 | Foto de perfil na seção sobre | Same asset as HERO-02 or separate image |
| ABOUT-03 | Botão de download do CV em PDF | `<a href="{{ asset('files/curriculo.pdf') }}" download>` |
| ABOUT-04 | Animação de entrada com AOS ao rolar | AOS `data-aos="fade-right"` / `data-aos="fade-left"` |
| SKILL-01 | Carrossel de tecnologias usando Swiper.js | Swiper v12.1.3 npm package; modular import pattern |
| SKILL-02 | Cada card exibe ícone/logo e nome da tecnologia | Devicon CDN font icons; inline SVG alternative |
| SKILL-03 | Skills carregadas de dado configurável | PHP array in PortfolioController passed to Blade view |
| SKILL-04 | Paginação e/ou navegação do Swiper funcional | Swiper Pagination module + clickable: true |
| PROJ-01 | Projetos carregados de data/projects.json | PortfolioController already passes $projects; JSON schema needed |
| PROJ-02 | Grid responsivo 3col/2col/1col | Tailwind `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3` |
| PROJ-03 | Card com imagem, título, descrição, tags | Blade @foreach loop over $projects collection |
| PROJ-04 | Hover overlay com links demo e repo | Tailwind `group` + `group-hover:opacity-100` pattern |
| PROJ-05 | projects.json schema documentado | Schema: title, description, image, url, repo, tags[] |
| VIS-01 | Dark theme com acento azul elétrico | Already defined: --color-accent in @theme, bg-accent utility |
| VIS-02 | Animações AOS em todas as seções | AOS v2.3.4 npm; initialized in resources/js/app.js |
| VIS-03 | Transições hover suaves em botões e cards | Tailwind `transition-all duration-300 ease-in-out` |
| ASSET-01 | Foto de perfil em public/images/ | Placeholder or real PNG; asset() helper path |
| ASSET-02 | CV PDF em public/files/curriculo.pdf | Placeholder or real PDF; download attribute |
| ASSET-03 | Imagens de projetos em public/images/projects/ | Placeholder images; referenced in projects.json |
</phase_requirements>

---

## Summary

Phase 2 fills the five section stubs already present in `resources/views/pages/home.blade.php` (created by Phase 1 Plan B). The Blade inheritance and routing contract are fully in place: `PortfolioController::index()` reads `data/projects.json`, decodes it into a `$projects` collection, and passes it to `pages.home`. All new content goes inside the existing `@section('content')` block.

The two external library dependencies are **Swiper.js v12.1.3** (carousel for Skills) and **AOS v2.3.4** (scroll animations). Both must be npm-installed and imported inside `resources/js/app.js` (Swiper) and CSS imported inside `resources/css/app.css` (AOS stylesheet, Swiper stylesheet). The Devicon icon font is loaded from jsDelivr CDN in `layouts/app.blade.php` head — it does not go through Vite.

The visual identity is already locked: dark background `--color-bg-primary: #030712`, card surface `--color-bg-card: #111827`, electric-blue accent `--color-accent: #3b82f6` (maps to `bg-accent`, `text-accent`, `border-accent` in Tailwind v4). Every section must use these tokens and never hardcode hex values.

**Primary recommendation:** Implement sections in dependency order — Hero (no deps), About (no deps), Skills (needs Swiper initialized), Projects (needs $projects JSON data), then Contact UI stub. Wire AOS last after all DOM structure is in place. Install Swiper + AOS as a single npm step before writing any Blade content.

---

## Standard Stack

### Core (already installed from Phase 1)

| Library | Version | Purpose | Why Standard |
|---------|---------|---------|--------------|
| tailwindcss | 4.2.2 | Utility CSS | Locked in Phase 1 — CSS-first via @theme |
| alpinejs | 3.15.8 | Reactive JS | Locked in Phase 1 — hamburger + intersect already wired |
| @alpinejs/intersect | 3.15.8 | Scroll detection | Locked in Phase 1 |
| laravel-vite-plugin | 3.0.0 | Asset pipeline | Locked in Phase 1 |

### New Libraries Needed (Phase 2)

| Library | Version | Purpose | Why Standard |
|---------|---------|---------|--------------|
| swiper | 12.1.3 | Touch-friendly carousel | Specified by SKILL-01; industry standard for carousels |
| aos | 2.3.4 | Scroll entry animations | Specified by VIS-02 and ABOUT-04; declarative `data-aos` on HTML |

### Supporting (CDN, no npm install)

| Resource | Source | Purpose | When to Use |
|----------|--------|---------|-------------|
| Devicon font | jsDelivr CDN | Tech icons for skill cards | SKILL-02; `<link>` in app.blade.php head |

### Alternatives Considered

| Instead of | Could Use | Tradeoff |
|------------|-----------|----------|
| swiper npm | Splide.js | Swiper is specified; Splide is lighter but not in scope |
| aos npm | Custom CSS @keyframes | AOS is specified; custom animations would require re-inventing per-element trigger logic |
| Devicon CDN | inline SVG files | CDN is simpler for a portfolio; inline SVGs add ~200 lines but avoid CDN dependency |

**Installation:**
```bash
npm install swiper@12.1.3 aos@2.3.4
```

**Version verification (confirmed 2026-03-24):**
- `npm view swiper version` → `12.1.3`
- `npm view aos version` → `2.3.4`

---

## Architecture Patterns

### Recommended Project Structure (additions to Phase 1)

```
resources/
├── views/
│   └── pages/
│       └── home.blade.php          # Fill the 5 section stubs
├── css/
│   └── app.css                     # Add: import 'aos/dist/aos.css' + swiper CSS
├── js/
│   └── app.js                      # Add: Swiper init + AOS init
data/
└── projects.json                    # Populate with real project objects
public/
├── images/
│   ├── profile.jpg                  # ASSET-01: hero/about photo
│   └── projects/
│       └── project-name.jpg         # ASSET-03: one image per project
└── files/
    └── curriculo.pdf                # ASSET-02: CV download
```

### Pattern 1: JS Module Initialization Order

**What:** AOS and Swiper must initialize after DOM is ready. Alpine runs after DOM. AOS in Vite projects must use `document.addEventListener('DOMContentLoaded', ...)` to avoid timing issues.

**When to use:** Every time an external library reads the DOM on page load.

**Example:**
```javascript
// resources/js/app.js
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import AOS from 'aos';
import 'aos/dist/aos.css';

Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // AOS — must be DOMContentLoaded or animations don't fire in Vite
    AOS.init({
        duration: 700,
        once: true,
        offset: 80,
    });

    // Swiper — skills carousel
    new Swiper('.swiper-skills', {
        modules: [Pagination, Autoplay],
        slidesPerView: 2,
        spaceBetween: 24,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            320: { slidesPerView: 2, spaceBetween: 12 },
            640: { slidesPerView: 3, spaceBetween: 16 },
            1024: { slidesPerView: 5, spaceBetween: 24 },
        },
    });
});
```

**Source:** AOS Vite fix: https://github.com/michalsnik/aos/issues/783; Swiper API: https://swiperjs.com/swiper-api

### Pattern 2: Swiper CSS in app.css vs app.js

**What:** Swiper CSS can be imported two ways: as `@import` in CSS files or as `import` in JS. For Laravel Vite, importing in `app.js` is simpler and more reliable. AOS CSS is also imported in `app.js`.

**When to use:** Both Swiper and AOS CSS must be imported somewhere Vite processes them. Importing in JS is the documented pattern for npm bundles.

**Note:** If importing Swiper CSS in `app.css`, use `@import 'swiper/css'` AFTER `@import "tailwindcss"` to avoid cascade conflicts. Importing in `app.js` sidesteps this ordering concern entirely.

### Pattern 3: Tailwind v4 Theme Token Usage

**What:** The `@theme` tokens from Phase 1 automatically generate utility classes. `--color-accent` → `bg-accent`, `text-accent`, `border-accent`. `--color-bg-primary` → `bg-bg-primary`. `--color-bg-card` → `bg-bg-card`.

**When to use:** Everywhere in HTML. Never hardcode `bg-[#3b82f6]` when `bg-accent` exists.

**Example:**
```html
{{-- Button with accent color --}}
<a href="#contact" class="bg-accent hover:bg-accent/90 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
    Entre em Contato
</a>

{{-- Card with bg-card token --}}
<div class="bg-bg-card border border-gray-800 rounded-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:border-accent/50">
    ...
</div>
```

### Pattern 4: Project Cards with Hover Overlay

**What:** Tailwind's `group` + `group-hover:` pattern enables the hover overlay showing demo/repo links without any JavaScript.

**When to use:** PROJ-04 hover overlay requirement.

**Example:**
```html
<div class="relative group overflow-hidden rounded-xl bg-bg-card">
    <img src="{{ asset('images/projects/' . $project['image']) }}"
         alt="{{ $project['title'] }}"
         class="w-full aspect-video object-cover transition-transform duration-500 group-hover:scale-105">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-bg-primary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4">
        @if($project['url'])
            <a href="{{ $project['url'] }}" target="_blank" rel="noopener"
               class="bg-accent text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-accent/90 transition-colors">
                Demo
            </a>
        @endif
        @if($project['repo'])
            <a href="{{ $project['repo'] }}" target="_blank" rel="noopener"
               class="border border-white text-white px-4 py-2 rounded-lg text-sm font-medium hover:border-accent hover:text-accent transition-colors">
                Repositório
            </a>
        @endif
    </div>
</div>
```

### Pattern 5: AOS Data Attributes

**What:** AOS animates elements declaratively via `data-aos` HTML attribute. No JavaScript per-element needed.

**When to use:** Every section's entry elements (HERO-04, ABOUT-04, VIS-02).

**Example:**
```html
{{-- Hero - staggered reveal --}}
<div data-aos="fade-up">Nome</div>
<div data-aos="fade-up" data-aos-delay="100">Cargo</div>
<div data-aos="fade-up" data-aos-delay="200">CTA Button</div>

{{-- About - side entry --}}
<div data-aos="fade-right">Text column</div>
<div data-aos="fade-left">Image column</div>

{{-- Project cards - stagger by index --}}
@foreach($projects as $i => $project)
    <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
        ...
    </div>
@endforeach
```

### Pattern 6: Skills Data in Controller

**What:** Skills array defined in PortfolioController (not a separate JSON) because SKILL-03 says "configurable" and the controller already reads JSON. For simplicity, a PHP array in the controller is the lightest option.

**When to use:** The controller passes both `$projects` (from JSON) and `$skills` (from inline array).

**Example:**
```php
// app/Http/Controllers/PortfolioController.php
public function index(): View
{
    $projects = collect(json_decode(
        File::get(base_path('data/projects.json')),
        true
    ));

    $skills = [
        ['name' => 'PHP', 'icon' => 'devicon-php-plain colored'],
        ['name' => 'Laravel', 'icon' => 'devicon-laravel-plain colored'],
        ['name' => 'JavaScript', 'icon' => 'devicon-javascript-plain colored'],
        ['name' => 'Vue.js', 'icon' => 'devicon-vuejs-plain colored'],
        ['name' => 'MySQL', 'icon' => 'devicon-mysql-plain colored'],
        ['name' => 'Git', 'icon' => 'devicon-git-plain colored'],
        ['name' => 'Docker', 'icon' => 'devicon-docker-plain colored'],
        ['name' => 'TailwindCSS', 'icon' => 'devicon-tailwindcss-plain colored'],
    ];

    return view('pages.home', compact('projects', 'skills'));
}
```

### Pattern 7: projects.json Schema

**What:** The schema must be defined (PROJ-05) and the JSON populated before cards can render.

**Schema:**
```json
[
  {
    "title": "Nome do Projeto",
    "description": "Descrição breve do projeto em 1-2 frases.",
    "image": "project-slug.jpg",
    "url": "https://demo.example.com",
    "repo": "https://github.com/user/repo",
    "tags": ["PHP", "Laravel", "MySQL"]
  }
]
```

**Null handling in Blade:** `url` and `repo` can be `null` for projects without live demo or public repo. The hover overlay conditionals (`@if($project['url'])`) guard against null values.

### Anti-Patterns to Avoid

- **Hardcoding hex colors:** Use `text-accent`, `bg-bg-card`, `bg-bg-primary` — never `text-[#3b82f6]` or `bg-[#111827]`.
- **Calling AOS.init() without DOMContentLoaded:** In Vite, the module executes before DOM is ready; animations will silently not fire.
- **Calling `new Swiper()` without the `modules` array:** Swiper v9+ requires explicit module registration. `import Swiper from 'swiper/bundle'` is an alternative that skips this but adds ~50KB to the bundle.
- **Putting `@vite` twice:** The master layout already has `@vite(['resources/css/app.css', 'resources/js/app.js'])`. Home view must NOT add another `@vite` call.
- **Using `tailwind.config.js`:** Tailwind v4 is CSS-first. No config file exists and none should be created.
- **CSS ordering conflict:** If importing Swiper or AOS CSS in `app.css`, place imports AFTER `@import "tailwindcss"` to prevent Tailwind from overriding them.
- **Swiper loop with too few slides:** `loop: true` requires `slides >= slidesPerView * 2` (v11+). With `slidesPerView: 5`, you need at least 6-10 skill cards to avoid console warnings and broken loop.

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Touch carousel for skills | Custom CSS scroll + JS snap | Swiper.js (SKILL-01 specifies it) | Swiper handles touch, loop clone, a11y, RTL, keyboard, pagination markup |
| Scroll reveal animations | Manual IntersectionObserver per element | AOS (VIS-02 specifies it) | AOS handles stagger, offset, easing, once, re-fire; writing per-element observers is ~200 lines |
| Tech icons | Custom SVG files committed to repo | Devicon CDN font | 150+ tech icons, colored variants, single `<link>` tag |
| Hover overlay on project cards | Alpine x-show or JS mouseenter | Tailwind `group/group-hover` | Pure CSS, no runtime cost, works without JS enabled |
| Smooth scroll | Alpine or vanilla JS scrollTo | CSS `scroll-smooth` on `<html>` | Already applied in `layouts/app.blade.php` (`class="scroll-smooth"`) |
| Asset URLs | Hardcoded `/images/profile.jpg` | Laravel `asset('images/profile.jpg')` | `asset()` prepends APP_URL and handles subdirectory deploys correctly on Hostinger |

**Key insight:** Both Swiper and AOS are explicitly named in requirements. Do not substitute. The only decision is bundle strategy (modular vs. bundle import) — use modular for smaller output.

---

## Common Pitfalls

### Pitfall 1: AOS Animations Silently Not Firing in Vite

**What goes wrong:** `AOS.init()` is called at module load time; DOM is not yet ready; `data-aos` elements are not found; no animation occurs, no error thrown.
**Why it happens:** Vite's module system executes JS before `DOMContentLoaded`. AOS's `startEvent` defaults to `DOMContentLoaded`, but the listener is registered after the event already fired.
**How to avoid:** Wrap `AOS.init()` in `document.addEventListener('DOMContentLoaded', () => { ... })`. Verified fix from: https://github.com/michalsnik/aos/issues/783
**Warning signs:** Page loads without any `aos-animate` class appearing on elements in DevTools.

### Pitfall 2: Swiper Loop Breaks with Too Few Slides

**What goes wrong:** `loop: true` causes blank slides or jumpy behavior.
**Why it happens:** Swiper v11+ requires `slides count >= slidesPerView + slidesPerGroup`. With `slidesPerView: 5` at 1024px, you need at least 6 skill entries.
**How to avoid:** Ensure the `$skills` array has at least 8-10 entries, OR use `loopAddBlankSlides: true` to auto-pad, OR disable loop when slides are few.
**Warning signs:** Console warning "Swiper loop requires at least X slides."

### Pitfall 3: Swiper CSS Not Loaded / Styles Missing

**What goes wrong:** Swiper renders with no gaps, no arrows, no pagination dots — slides stack vertically.
**Why it happens:** Swiper v9+ ships NO CSS in the JS bundle. CSS must be explicitly imported.
**How to avoid:** `import 'swiper/css'` and `import 'swiper/css/pagination'` in `app.js`, or use `import 'swiper/css/bundle'` for all-in-one.
**Warning signs:** `.swiper-wrapper` elements lay out vertically or without spacing.

### Pitfall 4: Tailwind v4 Purge / JIT Missing Classes

**What goes wrong:** Classes used only in Alpine or dynamic contexts may be purged.
**Why it happens:** Tailwind v4 scans Blade files, but dynamically constructed class strings like `'bg-' . $color` are not detected.
**How to avoid:** Use full class names in Blade templates. For Swiper pagination dots, Swiper's CSS (not Tailwind) styles them. Do not style Swiper internals with Tailwind utility classes — use the `@layer components` block in `app.css` if needed.
**Warning signs:** Expected classes missing from compiled CSS.

### Pitfall 5: PDF Download Without `download` Attribute

**What goes wrong:** Browser navigates to PDF in a new tab instead of downloading it (ABOUT-03).
**Why it happens:** Missing `download` attribute on the anchor tag.
**How to avoid:** `<a href="{{ asset('files/curriculo.pdf') }}" download>`. The `download` attribute prompts the browser to download rather than display.
**Warning signs:** Clicking CV button opens PDF viewer instead of downloading file.

### Pitfall 6: asset() vs url() for Public Files

**What goes wrong:** Images not found after deployment to Hostinger subdirectory.
**Why it happens:** Hardcoded `/images/` paths break when APP_URL is `https://domain.com/portfolio`.
**How to avoid:** Always use `{{ asset('images/profile.jpg') }}` — never `/images/profile.jpg`.
**Warning signs:** Images 404 in production but work locally.

### Pitfall 7: Devicon Classes Silently Failing

**What goes wrong:** Icon shows as a box or missing character.
**Why it happens:** CDN link not included in `<head>`, or class name typo (e.g., `devicon-laravel-plain` — note: Devicon uses "laravel" not "laravelphp").
**How to avoid:** Add `<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">` to `layouts/app.blade.php`. Verify icon names at devicon.dev.
**Warning signs:** Icon elements render empty or with question marks.

---

## Code Examples

### Devicon CDN Link in app.blade.php

```html
{{-- Source: https://devicon.dev, jsDelivr CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
```
Place in `<head>` after the `@vite()` call in `resources/views/layouts/app.blade.php`.

### Skill Card Blade Template

```blade
{{-- Source: Swiper API https://swiperjs.com/swiper-api --}}
<div class="swiper swiper-skills overflow-hidden">
    <div class="swiper-wrapper">
        @foreach($skills as $skill)
            <div class="swiper-slide">
                <div class="bg-bg-card border border-gray-800 rounded-xl p-6 flex flex-col items-center gap-3 hover:border-accent/50 transition-all duration-300">
                    <i class="{{ $skill['icon'] }} text-5xl"></i>
                    <span class="text-sm font-medium text-gray-300">{{ $skill['name'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination mt-6"></div>
</div>
```

### AOS Data Attribute Stagger Pattern

```blade
{{-- Source: https://michalsnik.github.io/aos/ --}}
@foreach($projects as $i => $project)
    <div data-aos="fade-up"
         data-aos-delay="{{ min($i * 100, 400) }}"
         class="bg-bg-card rounded-xl overflow-hidden border border-gray-800">
        ...
    </div>
@endforeach
```

### Hero Section Structure

```blade
<section id="hero" class="min-h-screen flex items-center justify-center bg-bg-primary relative overflow-hidden">
    <div class="container mx-auto px-6 text-center">
        <img src="{{ asset('images/profile.jpg') }}"
             alt="Ygor Stefankowski"
             class="w-32 h-32 rounded-full object-cover border-4 border-accent mx-auto mb-6"
             data-aos="fade-down">

        <h1 class="text-4xl md:text-6xl font-bold text-white mb-2" data-aos="fade-up" data-aos-delay="100">
            Ygor Stefankowski da Silva
        </h1>

        <p class="text-xl md:text-2xl text-accent font-medium mb-8" data-aos="fade-up" data-aos-delay="200">
            Desenvolvedor Full Stack
        </p>

        <a href="#contact"
           class="inline-block bg-accent hover:bg-accent/90 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5"
           data-aos="fade-up" data-aos-delay="300">
            Entre em Contato
        </a>
    </div>
</section>
```

### CV Download Button

```blade
{{-- ABOUT-03: download attribute triggers file download instead of browser preview --}}
<a href="{{ asset('files/curriculo.pdf') }}"
   download="Curriculo-Ygor-Stefankowski.pdf"
   class="inline-flex items-center gap-2 border border-accent text-accent hover:bg-accent hover:text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
    </svg>
    Download CV
</a>
```

---

## State of the Art

| Old Approach | Current Approach | When Changed | Impact |
|--------------|------------------|--------------|--------|
| Swiper `require()` + separate CSS link | ES module `import Swiper from 'swiper'` + `import 'swiper/css'` | Swiper v9 (2023) | Must use named module imports; no global `window.Swiper` |
| Swiper automatic modules | Explicit `modules: [Pagination, Autoplay]` array | Swiper v9 | Missing module array = feature silently disabled |
| AOS global CDN script | `import AOS from 'aos'` + `import 'aos/dist/aos.css'` | Standard npm pattern since AOS 1.2 | Must wrap `AOS.init()` in DOMContentLoaded for Vite |
| Tailwind v3 `tailwind.config.js` | Tailwind v4 CSS `@theme` block | v4.0 (2025) | No config JS file; tokens defined in CSS |
| Tailwind v3 `postcss.config.js` | `@tailwindcss/vite` plugin (no PostCSS config) | v4.0 (2025) | Creating postcss.config.js breaks Tailwind v4 build |
| Swiper SCSS themes | Swiper CSS-only (LESS/SCSS removed) | v12.0 (2025) | Import from `swiper/css`, not `swiper/scss` |

**Deprecated / outdated:**
- `import Swiper from 'swiper/bundle'`: Works but loads all modules (~60KB extra). Prefer modular: `import Swiper from 'swiper'` + explicit modules.
- `loopedSlides` parameter: Removed in Swiper v11. Use `loopAdditionalSlides` if needed.
- `data-aos-mirror="true"`: Causes animations to re-fire every scroll; usually not desired. Omit it — the `once: true` global init option is preferred for a portfolio.

---

## Environment Availability

| Dependency | Required By | Available | Version | Fallback |
|------------|------------|-----------|---------|----------|
| Node.js / npm | Install swiper + aos | Must be present (Phase 1 used npm) | — | — |
| swiper npm package | SKILL-01 | Not yet installed | 12.1.3 (latest) | None — required |
| aos npm package | VIS-02 | Not yet installed | 2.3.4 (latest) | None — required |
| Devicon CDN | SKILL-02 | External CDN (online) | @latest jsDelivr | Inline SVG fallback |
| public/images/profile.jpg | HERO-02, ABOUT-02 | Does NOT exist yet | — | Placeholder image |
| public/files/curriculo.pdf | ABOUT-03 | Does NOT exist yet | — | Placeholder empty PDF |
| public/images/projects/*.jpg | PROJ-03 | Does NOT exist yet | — | Placeholder images |

**Missing dependencies that block execution:**
- `swiper` and `aos` npm packages — must be installed before `app.js` compiles
- `public/images/profile.jpg` — `<img>` will 404 without it; Wave 0 must create placeholder or note requirement for user to supply
- `public/files/curriculo.pdf` — download link 404s without file; Wave 0 must create empty placeholder

**Missing dependencies with fallback:**
- Project images: if `public/images/projects/` is empty, project cards can use a CSS placeholder (`bg-gray-800 aspect-video` div) until real images are provided

---

## Validation Architecture

### Test Framework

| Property | Value |
|----------|-------|
| Framework | Manual browser + CLI verification (no automated test framework — excluded from v1 scope per REQUIREMENTS.md) |
| Config file | None |
| Quick run command | `php artisan serve` then manual browser check |
| Full suite command | `npm run build && php artisan serve` |

**Note:** REQUIREMENTS.md explicitly lists "Testes automatizados" as Out of Scope for v1. Nyquist validation for this phase is browser-based acceptance verification only.

### Phase Requirements → Test Map

| Req ID | Behavior | Test Type | Automated Command | Check |
|--------|----------|-----------|-------------------|-------|
| HERO-01 | Name + "Desenvolvedor Full Stack" visible | Visual | `grep -r "Desenvolvedor Full Stack" resources/views/` | Verify output |
| HERO-02 | Profile photo renders | Visual | `ls public/images/profile.*` | File exists |
| HERO-03 | CTA button present and links to #contact | Visual | `grep -r "href=\"#contact\"" resources/views/pages/home.blade.php` | Verify output |
| HERO-04 | data-aos on hero elements | CLI | `grep -c "data-aos" resources/views/pages/home.blade.php` | Count >= 3 |
| ABOUT-03 | CV download button | CLI | `grep "curriculo.pdf" resources/views/pages/home.blade.php` | Match found |
| SKILL-01 | Swiper markup present | CLI | `grep "swiper-skills" resources/views/pages/home.blade.php` | Match found |
| SKILL-04 | Pagination element | CLI | `grep "swiper-pagination" resources/views/pages/home.blade.php` | Match found |
| PROJ-01 | @foreach over $projects | CLI | `grep "@foreach.*projects" resources/views/pages/home.blade.php` | Match found |
| PROJ-05 | projects.json has schema | CLI | `cat data/projects.json \| php -r "echo count(json_decode(file_get_contents('php://stdin'), true));"` | Count >= 1 |
| VIS-02 | AOS initialized in app.js | CLI | `grep "AOS.init" resources/js/app.js` | Match found |
| ASSET-01 | Profile photo exists | CLI | `ls public/images/profile.*` | File found |
| ASSET-02 | CV PDF exists | CLI | `ls public/files/curriculo.pdf` | File found |
| BUILD | npm run build succeeds | CLI | `npm run build` | Exit 0 |

### Wave 0 Gaps

- [ ] `public/images/profile.jpg` — ASSET-01: placeholder image (or note for user to supply before HERO-02 can be verified)
- [ ] `public/files/curriculo.pdf` — ASSET-02: placeholder PDF (or note for user to supply before ABOUT-03 can be verified)
- [ ] `public/images/projects/` directory — ASSET-03: at minimum an empty directory; placeholder images needed to verify PROJ-03

---

## Open Questions

1. **Profile photo resolution/format**
   - What we know: Must go to `public/images/` (ASSET-01)
   - What's unclear: Whether user will supply a real photo or if a placeholder should be used
   - Recommendation: Plan should include a Wave 0 task creating a placeholder AND a note in the task description asking the user to replace it with their real photo before deployment

2. **Number of real projects for projects.json**
   - What we know: Grid is 3-col desktop, 2-col tablet, 1-col mobile; AOS stagger uses index
   - What's unclear: How many real projects the user wants to show in v1
   - Recommendation: Plan should populate at least 3-4 sample project entries (with placeholder images) as part of the Phase 2 plan. The user replaces them with real data.

3. **Skills list content**
   - What we know: A PHP array in PortfolioController; Devicon class names required
   - What's unclear: Which exact technologies Ygor wants to feature
   - Recommendation: Plan provides 8-10 common full-stack entries (PHP, Laravel, JS, Vue, MySQL, Git, Docker, TailwindCSS) as placeholders. User edits the array.

4. **Contact section scope in Phase 2 vs Phase 3**
   - What we know: Phase 2 success criteria includes "Contact (form UI + social links)"; CONTACT-01 through CONTACT-06 are assigned to Phase 3
   - What's unclear: How much of the contact section Phase 2 builds vs Phase 3
   - Recommendation: Phase 2 builds the HTML structure (form fields, social link icons), styled but non-functional. Phase 3 wires the Laravel Mail backend. This avoids breaking layout continuity.

---

## Sources

### Primary (HIGH confidence)
- Swiper API docs: https://swiperjs.com/swiper-api — autoplay, breakpoints, loop, module imports
- Swiper Get Started: https://swiperjs.com/get-started — installation and ES module pattern
- AOS GitHub: https://github.com/michalsnik/aos — init options, data attributes
- Devicon: https://devicon.dev — CDN link, icon class naming
- npm registry: `npm view swiper version` → 12.1.3; `npm view aos version` → 2.3.4 (verified 2026-03-24)

### Secondary (MEDIUM confidence)
- AOS Vite compatibility fix: https://github.com/michalsnik/aos/issues/783 — DOMContentLoaded workaround confirmed by multiple users
- Swiper v11 migration guide: https://swiperjs.com/migration-guide-v11 — loop minimum slides change
- Swiper v11 blog post: https://swiperjs.com/blog/swiper-v11-back-to-basics — module architecture
- Tailwind v4 @theme docs: https://tailwindcss.com/docs/theme — token-to-utility mapping confirmed

### Tertiary (LOW confidence)
- LinkedIn article "How to add Swiper components to Laravel projects" — general pattern confirmed by official docs

---

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH — versions verified via `npm view` against live registry (2026-03-24)
- Architecture: HIGH — based on official Swiper API docs, AOS docs, Blade contracts from Phase 1 SUMMARY files
- Pitfalls: HIGH for AOS/Vite (confirmed via GitHub issue tracker); MEDIUM for Swiper loop (documented in migration guide)

**Research date:** 2026-03-24
**Valid until:** 2026-04-24 (stable libraries; Swiper and AOS rarely have breaking patches)
