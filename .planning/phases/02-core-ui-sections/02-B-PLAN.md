---
phase: 02-core-ui-sections
plan: B
type: execute
wave: 2
depends_on: [02-A]
files_modified:
  - resources/views/pages/home.blade.php
autonomous: true
requirements: [HERO-01, HERO-02, HERO-03, HERO-04, ABOUT-01, ABOUT-02, ABOUT-03, ABOUT-04, VIS-01, VIS-03]

must_haves:
  truths:
    - "Hero section displays 'Ygor Stefankowski da Silva' and 'Desenvolvedor Full Stack'"
    - "Hero section shows profile photo with accent-color border"
    - "Hero CTA button links to #contact"
    - "About section shows personal bio text and professional trajectory"
    - "About section has a CV download button with the download attribute"
    - "Hero and About elements have data-aos attributes for entrance animations"
    - "All colors use theme tokens (bg-accent, bg-bg-primary, bg-bg-card) — no hardcoded hex"
    - "Hover transitions on buttons use transition-all duration-300"
  artifacts:
    - path: "resources/views/pages/home.blade.php"
      provides: "Hero and About section content replacing Phase 1 stubs"
      contains: "Ygor Stefankowski da Silva"
  key_links:
    - from: "hero img tag"
      to: "public/images/profile.jpg"
      via: "{{ asset('images/profile.jpg') }}"
      pattern: "asset\\('images/profile\\.jpg'\\)"
    - from: "CV download button"
      to: "public/files/curriculo.pdf"
      via: "{{ asset('files/curriculo.pdf') }}"
      pattern: "curriculo\\.pdf.*download"
---

<objective>
Fill the Hero and About section stubs in resources/views/pages/home.blade.php with complete, styled content: the hero section with name, role, profile photo, and CTA button; the About section with personal bio, profile photo, and CV download button. All elements include AOS data attributes for scroll-triggered entrance animations.

Purpose: These are the two highest-impact "above the fold" sections. Recruiters see Hero first; About is the first section with substantive text. Both must render correctly before the visual checkpoint in Plan E.
Output: home.blade.php with Hero and About sections fully implemented.
</objective>

<execution_context>
@$HOME/.claude/get-shit-done/workflows/execute-plan.md
@$HOME/.claude/get-shit-done/templates/summary.md
</execution_context>

<context>
@.planning/PROJECT.md
@.planning/ROADMAP.md
@.planning/phases/02-core-ui-sections/02-RESEARCH.md
@.planning/phases/01-foundation/01-B-SUMMARY.md

<interfaces>
<!-- Blade inheritance contract from Phase 1 Plan B -->

home.blade.php structure (DO NOT CHANGE the @extends or @section lines):
```blade
@extends('layouts.app')

@section('content')
    {{-- Replace the 5 section stub <p> tags with real content --}}
    {{-- Section IDs must stay: hero, about, skills, projects, contact --}}
@endsection
```

Available Tailwind v4 tokens (from app.css @theme — use these, never hardcode hex):
- bg-accent, text-accent, border-accent  (electric blue #3b82f6)
- bg-bg-primary    (#030712)
- bg-bg-card       (#111827)

AOS attributes (from 02-RESEARCH.md Pattern 5):
- data-aos="fade-down"    — for profile image (top entry)
- data-aos="fade-up"      — for text elements (bottom-up entry)
- data-aos-delay="100"    — stagger: 0, 100, 200, 300ms per element

asset() helper (from 02-RESEARCH.md Anti-Patterns):
- ALWAYS use {{ asset('images/profile.jpg') }} — never /images/profile.jpg
- ALWAYS use {{ asset('files/curriculo.pdf') }} — never /files/curriculo.pdf

$projects variable is passed by PortfolioController but not used in this plan.
</interfaces>
</context>

<tasks>

<task type="auto">
  <name>Task 1: Build Hero section in home.blade.php</name>
  <files>resources/views/pages/home.blade.php</files>
  <action>
Replace the `#hero` section stub in resources/views/pages/home.blade.php. The other four section stubs (#about, #skills, #projects, #contact) must remain untouched — this task only replaces the hero section content.

Replace:
```blade
<section id="hero" class="min-h-screen flex items-center justify-center">
    <p class="text-gray-400 text-sm">Hero — Phase 2</p>
</section>
```

With:
```blade
<section id="hero" class="min-h-screen flex items-center justify-center bg-bg-primary relative overflow-hidden pt-16">
    <div class="container mx-auto px-6 text-center">

        {{-- Profile photo -- HERO-02 --}}
        <div class="mb-6" data-aos="fade-down">
            <img src="{{ asset('images/profile.jpg') }}"
                 alt="Ygor Stefankowski da Silva"
                 class="w-36 h-36 rounded-full object-cover border-4 border-accent mx-auto shadow-lg shadow-accent/20">
        </div>

        {{-- Name -- HERO-01 --}}
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-3"
            data-aos="fade-up" data-aos-delay="100">
            Ygor Stefankowski da Silva
        </h1>

        {{-- Role -- HERO-01 --}}
        <p class="text-xl md:text-2xl text-accent font-semibold mb-4"
           data-aos="fade-up" data-aos-delay="200">
            Desenvolvedor Full Stack
        </p>

        {{-- Tagline --}}
        <p class="text-gray-400 text-lg mb-10 max-w-xl mx-auto"
           data-aos="fade-up" data-aos-delay="300">
            Criando soluções web modernas com PHP, Laravel e JavaScript.
        </p>

        {{-- CTA buttons -- HERO-03 --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center"
             data-aos="fade-up" data-aos-delay="400">
            <a href="#contact"
               class="inline-block bg-accent hover:bg-accent/90 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                Entre em Contato
            </a>
            <a href="#projects"
               class="inline-block border border-accent text-accent hover:bg-accent hover:text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                Ver Projetos
            </a>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce"
             data-aos="fade-up" data-aos-delay="600">
            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

    </div>
</section>
```

CRITICAL: Use `{{ asset('images/profile.jpg') }}` — not `/images/profile.jpg`.
CRITICAL: The CTA href must be `#contact` (per HERO-03).
CRITICAL: Use `bg-bg-primary`, `text-accent`, `bg-accent`, `border-accent` — never hardcoded hex.
CRITICAL: data-aos delays must be staggered (100ms increments) for HERO-04 entrance animation.
  </action>
  <verify>
    <automated>grep -c "data-aos" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php</automated>
    Also: `grep "Ygor Stefankowski da Silva" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
    Also: `grep 'href="#contact"' C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
  </verify>
  <done>home.blade.php #hero section contains name "Ygor Stefankowski da Silva", "Desenvolvedor Full Stack", profile img using asset() helper, CTA href="#contact", and at least 4 data-aos attributes</done>
</task>

<task type="auto">
  <name>Task 2: Build About section in home.blade.php</name>
  <files>resources/views/pages/home.blade.php</files>
  <action>
Replace only the `#about` section stub in home.blade.php. Hero and the three remaining stubs must stay untouched.

Replace:
```blade
<section id="about" class="min-h-screen flex items-center justify-center">
    <p class="text-gray-400 text-sm">Sobre — Phase 2</p>
</section>
```

With:
```blade
<section id="about" class="py-24 bg-bg-primary">
    <div class="container mx-auto px-6">

        {{-- Section heading --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Sobre Mim</h2>
            <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
        </div>

        {{-- Two-column layout: text left, photo right --}}
        <div class="flex flex-col lg:flex-row items-center gap-12 max-w-5xl mx-auto">

            {{-- Bio text column -- ABOUT-01 --}}
            <div class="flex-1" data-aos="fade-right">
                <p class="text-gray-300 text-lg leading-relaxed mb-6">
                    Olá! Sou o Ygor, desenvolvedor full stack apaixonado por criar experiências
                    digitais modernas e funcionais. Com foco em PHP e Laravel no back-end e
                    JavaScript no front-end, transformo ideias em aplicações web robustas e
                    escaláveis.
                </p>
                <p class="text-gray-300 text-lg leading-relaxed mb-6">
                    Minha trajetória começou pela curiosidade em entender como as coisas funcionam
                    por baixo dos panos. Hoje trabalho com a stack completa — do banco de dados
                    à interface — sempre com atenção à qualidade do código e à experiência do usuário.
                </p>
                <p class="text-gray-300 text-lg leading-relaxed mb-10">
                    Estou em busca de oportunidades onde possa contribuir com soluções técnicas
                    sólidas e continuar crescendo como profissional.
                </p>

                {{-- CV download button -- ABOUT-03 --}}
                <a href="{{ asset('files/curriculo.pdf') }}"
                   download="Curriculo-Ygor-Stefankowski.pdf"
                   class="inline-flex items-center gap-2 border border-accent text-accent hover:bg-accent hover:text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download CV
                </a>
            </div>

            {{-- Profile photo column -- ABOUT-02 --}}
            <div class="flex-shrink-0" data-aos="fade-left">
                <div class="relative">
                    <img src="{{ asset('images/profile.jpg') }}"
                         alt="Ygor Stefankowski da Silva"
                         class="w-64 h-64 rounded-2xl object-cover border-2 border-accent/30 shadow-xl shadow-accent/10">
                    {{-- Decorative accent border offset --}}
                    <div class="absolute -bottom-3 -right-3 w-full h-full border-2 border-accent/20 rounded-2xl -z-10"></div>
                </div>
            </div>

        </div>
    </div>
</section>
```

CRITICAL: `download="Curriculo-Ygor-Stefankowski.pdf"` attribute is required for ABOUT-03 — without it the browser opens the PDF in a tab instead of downloading.
CRITICAL: Use `{{ asset('files/curriculo.pdf') }}` — not a hardcoded path.
CRITICAL: `data-aos="fade-right"` on text column, `data-aos="fade-left"` on photo column (per ABOUT-04 and research Pattern 5).
NOTE: Bio text is a placeholder. User should replace with their real personal bio before deployment.
  </action>
  <verify>
    <automated>grep "curriculo.pdf" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php</automated>
    Also: `grep "download=" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
    Also: `grep "fade-right" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
  </verify>
  <done>home.blade.php #about section contains bio text, profile img, CV download link with download attribute, and data-aos="fade-right" / data-aos="fade-left" on the two columns</done>
</task>

</tasks>

<verification>
After both tasks complete:
1. `grep "Desenvolvedor Full Stack" resources/views/pages/home.blade.php` — match (HERO-01)
2. `grep 'href="#contact"' resources/views/pages/home.blade.php` — match (HERO-03)
3. `grep -c "data-aos" resources/views/pages/home.blade.php` — count >= 6 (HERO-04 + ABOUT-04)
4. `grep "download=" resources/views/pages/home.blade.php` — match (ABOUT-03)
5. `grep "curriculo.pdf" resources/views/pages/home.blade.php` — match (ABOUT-03)
6. `grep "asset('images/profile.jpg')" resources/views/pages/home.blade.php` — match (HERO-02 + ABOUT-02)
7. Section stubs #skills, #projects, #contact still present: `grep "Skills — Phase 2\|Projetos — Phase 2\|Contato — Phase 2" resources/views/pages/home.blade.php` — 3 matches
</verification>

<success_criteria>
- Hero: name, role ("Desenvolvedor Full Stack"), profile photo with accent border, CTA button to #contact, scroll indicator — all with AOS data attributes
- About: personal bio (3 paragraphs), profile photo, CV download button with `download` attribute — text column fades-right, photo fades-left
- All colors use Tailwind v4 theme tokens, no hardcoded hex
- Hover transitions use `transition-all duration-300` (VIS-03)
- Skills, Projects, Contact section stubs unchanged (those are Plans C, D, E)
</success_criteria>

<output>
After completion, create `.planning/phases/02-core-ui-sections/02-B-SUMMARY.md`
</output>
