---
phase: 02-core-ui-sections
plan: D
type: execute
wave: 2
depends_on: [02-A, 02-C]
files_modified:
  - data/projects.json
  - resources/views/pages/home.blade.php
autonomous: true
requirements: [PROJ-01, PROJ-02, PROJ-03, PROJ-04, PROJ-05, VIS-02, VIS-03]

must_haves:
  truths:
    - "data/projects.json contains at least 3 project objects matching the documented schema"
    - "Projects section renders a responsive grid: 1 col mobile, 2 col tablet, 3 col desktop"
    - "Each project card shows image, title, description, and tech tag badges"
    - "Hovering a card reveals an overlay with Demo and Repositório buttons"
    - "Project cards load dynamically via @foreach over $projects — no hardcoded cards"
    - "Project cards have staggered AOS data-aos-delay attributes"
  artifacts:
    - path: "data/projects.json"
      provides: "Project data with schema: title, description, image, url, repo, tags[]"
      contains: "title"
    - path: "resources/views/pages/home.blade.php"
      provides: "Projects section with grid layout and hover overlay cards"
      contains: "@foreach.*projects"
  key_links:
    - from: "project card img"
      to: "public/images/projects/"
      via: "{{ asset('images/projects/' . $project['image']) }}"
      pattern: "asset\\('images/projects/"
    - from: "@foreach($projects"
      to: "PortfolioController $projects"
      via: "json_decode File::get data/projects.json"
      pattern: "@foreach.*projects"
---

<objective>
Populate data/projects.json with 3-4 sample project entries using the documented schema (PROJ-05), then build the Projects section in home.blade.php with a responsive grid of project cards featuring hover overlays (PROJ-01 through PROJ-04).

Purpose: Projects is the portfolio's core deliverable — what recruiters look at after Hero. The data-driven approach (JSON) means the user can update projects without touching Blade. The hover overlay with demo/repo links is the primary interactive element.
Output: Populated projects.json; home.blade.php #projects section with responsive grid and hover overlay cards.
</objective>

<execution_context>
@$HOME/.claude/get-shit-done/workflows/execute-plan.md
@$HOME/.claude/get-shit-done/templates/summary.md
</execution_context>

<context>
@.planning/PROJECT.md
@.planning/ROADMAP.md
@.planning/phases/02-core-ui-sections/02-RESEARCH.md
@.planning/phases/01-foundation/01-A-SUMMARY.md
@.planning/phases/01-foundation/01-B-SUMMARY.md

<interfaces>
<!-- PortfolioController reads projects.json — contract already established in Phase 1 -->
```php
// Controller reads data/projects.json and passes $projects as a Collection
$projects = collect(json_decode(
    File::get(base_path('data/projects.json')),
    true
));
// $projects is a Collection of arrays — each element accessed as $project['key']
```

<!-- projects.json schema (PROJ-05 from research Pattern 7) -->
```json
[
  {
    "title": "string — project name",
    "description": "string — 1-2 sentence description",
    "image": "string — filename only, e.g. project-slug.jpg (goes in public/images/projects/)",
    "url": "string|null — live demo URL or null",
    "repo": "string|null — GitHub repo URL or null",
    "tags": ["string", "..."]
  }
]
```

<!-- Hover overlay pattern (from research Pattern 4) -->
Tailwind group/group-hover: parent gets `group` class, overlay child gets `group-hover:opacity-100`
No JavaScript needed — pure CSS hover.

<!-- Tailwind v4 tokens -->
- bg-bg-primary  (#030712) — overlay background
- bg-bg-card     (#111827) — card background
- bg-accent      (#3b82f6) — Demo button fill
- border-accent  (#3b82f6) — Repo button border
</interfaces>
</context>

<tasks>

<task type="auto">
  <name>Task 1: Populate data/projects.json with schema and sample projects</name>
  <files>data/projects.json</files>
  <action>
Replace the current empty array in data/projects.json with 4 sample project entries. These are placeholders — the user replaces them with real projects before deployment.

Write the following to data/projects.json:
```json
[
  {
    "title": "Portfólio Pessoal",
    "description": "Site de portfólio desenvolvido com Laravel 12, Tailwind CSS v4 e Alpine.js. Dark theme com animações AOS e carrossel Swiper para exibição das habilidades técnicas.",
    "image": "portfolio.jpg",
    "url": null,
    "repo": "https://github.com/ygor-stefankowski/portfolio",
    "tags": ["PHP", "Laravel", "Tailwind CSS", "Alpine.js", "JavaScript"]
  },
  {
    "title": "Sistema de Gestão",
    "description": "Aplicação web para gestão de recursos internos com autenticação, CRUD completo e relatórios em PDF gerados via Laravel.",
    "image": "sistema-gestao.jpg",
    "url": null,
    "repo": null,
    "tags": ["PHP", "Laravel", "MySQL", "Blade", "Bootstrap"]
  },
  {
    "title": "API RESTful",
    "description": "API construída com Laravel para consumo por aplicações mobile e SPA. Autenticação via Laravel Sanctum, documentação com Swagger.",
    "image": "api-restful.jpg",
    "url": null,
    "repo": "https://github.com/ygor-stefankowski/api-exemplo",
    "tags": ["PHP", "Laravel", "REST API", "Sanctum", "MySQL"]
  },
  {
    "title": "Dashboard Analytics",
    "description": "Painel administrativo responsivo com gráficos interativos, filtros dinâmicos via Alpine.js e exportação de dados para CSV.",
    "image": "dashboard.jpg",
    "url": null,
    "repo": null,
    "tags": ["JavaScript", "Alpine.js", "Tailwind CSS", "PHP", "Chart.js"]
  }
]
```

IMPORTANT: Image filenames referenced here (portfolio.jpg, sistema-gestao.jpg, api-restful.jpg, dashboard.jpg) do not exist yet in public/images/projects/. The card image will 404 or show a broken icon. Plan E's checkpoint asks the user to supply real images. The card layout uses `bg-gray-800` as a fallback background so cards remain visually acceptable even with missing images.

NOTE: url and repo can be null — the Blade template uses @if($project['url']) guards.
NOTE: User must replace these with real project data before deployment.
  </action>
  <verify>
    <automated>php -r "echo count(json_decode(file_get_contents('C:/Users/Ygor/portifolio/data/projects.json'), true));" </automated>
    Output must be 4. Also validate JSON: `php -r "json_decode(file_get_contents('C:/Users/Ygor/portifolio/data/projects.json')); echo json_last_error() === JSON_ERROR_NONE ? 'valid' : 'invalid';" `
  </verify>
  <done>data/projects.json parses as valid JSON with 4 project objects; each object has title, description, image, url (nullable), repo (nullable), tags (array) keys</done>
</task>

<task type="auto">
  <name>Task 2: Build Projects section in home.blade.php</name>
  <files>resources/views/pages/home.blade.php</files>
  <action>
Replace only the `#projects` section stub in home.blade.php. Hero, About, Skills, and the Contact stub must remain untouched.

Replace:
```blade
<section id="projects" class="min-h-screen flex items-center justify-center">
    <p class="text-gray-400 text-sm">Projetos — Phase 2</p>
</section>
```

With:
```blade
<section id="projects" class="py-24 bg-bg-primary">
    <div class="container mx-auto px-6">

        {{-- Section heading --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Projetos</h2>
            <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
            <p class="text-gray-400 mt-4 max-w-xl mx-auto">
                Alguns dos projetos que desenvolvi — clique para ver o código ou a demo.
            </p>
        </div>

        {{-- Projects grid -- PROJ-01, PROJ-02 --}}
        {{-- 1 col mobile, 2 col tablet (md), 3 col desktop (lg) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($projects as $i => $project)
                {{-- Card -- PROJ-03, PROJ-04 --}}
                {{-- AOS stagger capped at 400ms to avoid long waits on large grids --}}
                <div class="relative group overflow-hidden rounded-xl bg-bg-card border border-gray-800
                            hover:border-accent/30 transition-all duration-300 hover:-translate-y-1"
                     data-aos="fade-up"
                     data-aos-delay="{{ min($i * 100, 400) }}">

                    {{-- Project image with scale-on-hover -- PROJ-03 --}}
                    <div class="aspect-video bg-gray-800 overflow-hidden">
                        <img src="{{ asset('images/projects/' . $project['image']) }}"
                             alt="{{ $project['title'] }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             onerror="this.style.display='none'">
                    </div>

                    {{-- Card body -- PROJ-03 --}}
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-white mb-2">{{ $project['title'] }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ $project['description'] }}</p>

                        {{-- Tech tags -- PROJ-03 --}}
                        <div class="flex flex-wrap gap-2">
                            @foreach($project['tags'] as $tag)
                                <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20
                                             px-2 py-1 rounded-md">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Hover overlay with demo + repo links -- PROJ-04 --}}
                    <div class="absolute inset-0 bg-bg-primary/90 opacity-0 group-hover:opacity-100
                                transition-opacity duration-300 flex items-center justify-center gap-4">
                        @if($project['url'])
                            <a href="{{ $project['url'] }}"
                               target="_blank" rel="noopener noreferrer"
                               class="bg-accent hover:bg-accent/90 text-white px-5 py-2.5 rounded-lg
                                      text-sm font-semibold transition-colors duration-300">
                                Demo
                            </a>
                        @endif
                        @if($project['repo'])
                            <a href="{{ $project['repo'] }}"
                               target="_blank" rel="noopener noreferrer"
                               class="border border-white text-white hover:border-accent hover:text-accent
                                      px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors duration-300">
                                Repositório
                            </a>
                        @endif
                        @if(!$project['url'] && !$project['repo'])
                            <span class="text-gray-400 text-sm">Em breve</span>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>
```

CRITICAL: `group` class on the outer card div is required for `group-hover:opacity-100` on the overlay to work — pure CSS, no JavaScript.
CRITICAL: `overflow-hidden` on the outer card div prevents the overlay from bleeding outside the rounded card.
CRITICAL: `onerror="this.style.display='none'"` on img hides the broken image icon when project images don't exist yet, keeping cards visually clean.
CRITICAL: Use `{{ asset('images/projects/' . $project['image']) }}` — not a hardcoded path.
CRITICAL: AOS delay is capped at `min($i * 100, 400)` — prevents 600ms+ delays on later cards which feel sluggish.
  </action>
  <verify>
    <automated>grep "@foreach.*projects" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php</automated>
    Also: `grep "group-hover:opacity-100" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
    Also: `grep "grid-cols-1 md:grid-cols-2 lg:grid-cols-3" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
  </verify>
  <done>home.blade.php #projects section contains responsive grid (grid-cols-1 md:grid-cols-2 lg:grid-cols-3), @foreach over $projects, card with image/title/description/tags, and hover overlay with group-hover:opacity-100</done>
</task>

</tasks>

<verification>
After both tasks complete:
1. `php -r "echo count(json_decode(file_get_contents('data/projects.json'), true));"` — outputs 4 (PROJ-01, PROJ-05)
2. `grep "@foreach.*projects" resources/views/pages/home.blade.php` — match (PROJ-01)
3. `grep "grid-cols-1 md:grid-cols-2 lg:grid-cols-3" resources/views/pages/home.blade.php` — match (PROJ-02)
4. `grep "group-hover:opacity-100" resources/views/pages/home.blade.php` — match (PROJ-04)
5. `grep "data-aos-delay" resources/views/pages/home.blade.php` — match (VIS-02 stagger)
6. Contact section stub still present: `grep "Contato — Phase 2" resources/views/pages/home.blade.php` — match
</verification>

<success_criteria>
- data/projects.json: valid JSON, 4 objects, each with title/description/image/url/repo/tags fields — PROJ-05
- Projects rendered via @foreach over controller-passed $projects (not hardcoded) — PROJ-01
- Responsive grid 1/2/3 columns at mobile/tablet/desktop — PROJ-02
- Each card: image, title, description, tech tag badges — PROJ-03
- Hover overlay: Demo and Repo links via Tailwind group/group-hover — PROJ-04
- Cards have staggered AOS entrance animations — VIS-02
- Hover transitions on cards and tags use transition-all duration-300 — VIS-03
</success_criteria>

<output>
After completion, create `.planning/phases/02-core-ui-sections/02-D-SUMMARY.md`
</output>
