---
phase: 02-core-ui-sections
plan: C
type: execute
wave: 2
depends_on: [02-A, 02-B]
files_modified:
  - app/Http/Controllers/PortfolioController.php
  - resources/views/pages/home.blade.php
autonomous: true
requirements: [SKILL-01, SKILL-02, SKILL-03, SKILL-04, VIS-01, VIS-02, VIS-03]

must_haves:
  truths:
    - "Skills section renders a Swiper carousel with the class .swiper-skills"
    - "Each skill card shows a Devicon icon and the skill name"
    - "PortfolioController passes a $skills array to the view"
    - "Swiper pagination element (.swiper-pagination) is present in markup"
    - "At least 10 skill entries exist so Swiper loop does not break (loop requires slides >= slidesPerView * 2)"
    - "Skills section has AOS scroll animation"
  artifacts:
    - path: "app/Http/Controllers/PortfolioController.php"
      provides: "$skills array with icon class names and names"
      contains: "skills"
    - path: "resources/views/pages/home.blade.php"
      provides: "Skills section with .swiper-skills markup and @foreach over $skills"
      contains: "swiper-skills"
  key_links:
    - from: "resources/views/pages/home.blade.php"
      to: "app/Http/Controllers/PortfolioController.php"
      via: "$skills variable in compact()"
      pattern: "compact\\(.*skills"
    - from: ".swiper-skills"
      to: "resources/js/app.js"
      via: "new Swiper('.swiper-skills', ...)"
      pattern: "swiper-skills"
---

<objective>
Add the $skills array to PortfolioController (SKILL-03) and build the Skills carousel section in home.blade.php using Swiper.js markup (SKILL-01, SKILL-02, SKILL-04). Devicon icon classes are already available via the CDN link added in Plan A.

Purpose: The Skills section is the primary tech showcase. The Swiper JS init is already wired in app.js (Plan A) targeting .swiper-skills — this plan creates the HTML that matches that selector.
Output: PortfolioController with $skills array; home.blade.php #skills section with Swiper carousel markup.
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
<!-- PortfolioController current state (from 01-B-SUMMARY.md) — must add $skills -->
```php
// app/Http/Controllers/PortfolioController.php — CURRENT
public function index(): View
{
    $projects = collect(json_decode(
        File::get(base_path('data/projects.json')),
        true
    ));
    return view('pages.home', compact('projects'));
    // NEEDS: also pass compact('projects', 'skills')
}
```

<!-- Swiper JS init from app.js (Plan A output) — target selector must match -->
```js
new Swiper('.swiper-skills', {   // <- this selector
    modules: [Pagination, Autoplay],
    loop: true,
    pagination: { el: '.swiper-pagination', clickable: true },
    breakpoints: {
        320: { slidesPerView: 2, spaceBetween: 12 },
        640: { slidesPerView: 3, spaceBetween: 16 },
        1024: { slidesPerView: 5, spaceBetween: 24 },
    },
});
```

Swiper loop constraint: loop: true requires slides >= (slidesPerView * 2).
At 1024px+ slidesPerView is 5, so the $skills array MUST have >= 10 entries.

Devicon class naming (verified against devicon.dev):
- PHP:        devicon-php-plain colored
- Laravel:    devicon-laravel-plain colored
- JavaScript: devicon-javascript-plain colored
- TypeScript: devicon-typescript-plain colored
- Vue.js:     devicon-vuejs-plain colored
- MySQL:      devicon-mysql-plain colored
- Git:        devicon-git-plain colored
- Docker:     devicon-docker-plain colored
- TailwindCSS:devicon-tailwindcss-plain colored
- HTML5:      devicon-html5-plain colored
- CSS3:       devicon-css3-plain colored
- Linux:      devicon-linux-plain
</interfaces>
</context>

<tasks>

<task type="auto">
  <name>Task 1: Add $skills array to PortfolioController</name>
  <files>app/Http/Controllers/PortfolioController.php</files>
  <action>
Replace the entire content of app/Http/Controllers/PortfolioController.php with the following. The only change from the current version is adding the $skills array and including it in compact():

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $projects = collect(json_decode(
            File::get(base_path('data/projects.json')),
            true
        ));

        // SKILL-03: Skills defined as configurable array in controller.
        // Edit this array to update the Skills carousel without touching Blade files.
        // MUST have >= 10 entries for Swiper loop to work at 1024px (slidesPerView: 5, loop: true).
        $skills = [
            ['name' => 'PHP',         'icon' => 'devicon-php-plain colored'],
            ['name' => 'Laravel',     'icon' => 'devicon-laravel-plain colored'],
            ['name' => 'JavaScript',  'icon' => 'devicon-javascript-plain colored'],
            ['name' => 'TypeScript',  'icon' => 'devicon-typescript-plain colored'],
            ['name' => 'Vue.js',      'icon' => 'devicon-vuejs-plain colored'],
            ['name' => 'MySQL',       'icon' => 'devicon-mysql-plain colored'],
            ['name' => 'Git',         'icon' => 'devicon-git-plain colored'],
            ['name' => 'Docker',      'icon' => 'devicon-docker-plain colored'],
            ['name' => 'TailwindCSS', 'icon' => 'devicon-tailwindcss-plain colored'],
            ['name' => 'HTML5',       'icon' => 'devicon-html5-plain colored'],
            ['name' => 'CSS3',        'icon' => 'devicon-css3-plain colored'],
            ['name' => 'Linux',       'icon' => 'devicon-linux-plain'],
        ];

        return view('pages.home', compact('projects', 'skills'));
    }
}
```

NOTE: 12 entries ensures loop works at all breakpoints (even at slidesPerView: 5, 12 >= 5*2=10).
NOTE: User should edit this array to reflect their actual tech stack before deployment.
  </action>
  <verify>
    <automated>grep "compact('projects', 'skills')" C:/Users/Ygor/portifolio/app/Http/Controllers/PortfolioController.php</automated>
    Also: `php -r "echo count(json_decode(file_get_contents('C:/Users/Ygor/portifolio/data/projects.json'), true));"` — should return 0 (stub) without errors
  </verify>
  <done>PortfolioController passes both $projects and $skills to the view; $skills array has 12 entries with name and icon keys; php syntax is valid</done>
</task>

<task type="auto">
  <name>Task 2: Build Skills carousel section in home.blade.php</name>
  <files>resources/views/pages/home.blade.php</files>
  <action>
Replace only the `#skills` section stub in home.blade.php. Hero, About, and the remaining stubs (#projects, #contact) must remain untouched.

Replace:
```blade
<section id="skills" class="min-h-screen flex items-center justify-center">
    <p class="text-gray-400 text-sm">Skills — Phase 2</p>
</section>
```

With:
```blade
<section id="skills" class="py-24 bg-bg-card">
    <div class="container mx-auto px-6">

        {{-- Section heading --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Habilidades</h2>
            <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
            <p class="text-gray-400 mt-4 max-w-xl mx-auto">
                Tecnologias e ferramentas com as quais trabalho no dia a dia.
            </p>
        </div>

        {{-- Swiper carousel -- SKILL-01, SKILL-02, SKILL-03, SKILL-04 --}}
        {{-- .swiper-skills selector must match new Swiper('.swiper-skills') in app.js --}}
        <div class="swiper swiper-skills overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                @foreach($skills as $skill)
                    <div class="swiper-slide">
                        <div class="bg-bg-primary border border-gray-800 rounded-xl p-6
                                    flex flex-col items-center gap-3
                                    hover:border-accent/50 hover:-translate-y-1
                                    transition-all duration-300 cursor-default">
                            {{-- Devicon icon -- SKILL-02 --}}
                            <i class="{{ $skill['icon'] }} text-5xl"></i>
                            <span class="text-sm font-medium text-gray-300">{{ $skill['name'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- Swiper pagination -- SKILL-04 --}}
            <div class="swiper-pagination mt-8"></div>
        </div>

    </div>
</section>
```

CRITICAL: The outer div class must be `swiper swiper-skills` — the JS init in app.js targets `.swiper-skills`.
CRITICAL: `swiper-wrapper` and `swiper-slide` classes are required by Swiper's internal DOM expectations.
CRITICAL: `overflow-hidden` on the swiper container prevents slides from bleeding outside the section during carousel motion.
CRITICAL: `swiper-pagination` div must be OUTSIDE `swiper-wrapper` (sibling, not child).
NOTE: Devicon icons require the CDN link in app.blade.php head (added in Plan A). If icons show as boxes, the CDN link is missing.
  </action>
  <verify>
    <automated>grep "swiper-skills" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php</automated>
    Also: `grep "swiper-pagination" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
    Also: `grep "@foreach.*skills" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
  </verify>
  <done>home.blade.php #skills section contains .swiper-skills, .swiper-wrapper, .swiper-slide, @foreach over $skills, Devicon icon class output, and .swiper-pagination element</done>
</task>

</tasks>

<verification>
After both tasks complete:
1. `grep "compact('projects', 'skills')" app/Http/Controllers/PortfolioController.php` — match (SKILL-03)
2. `grep "swiper-skills" resources/views/pages/home.blade.php` — match (SKILL-01)
3. `grep "swiper-pagination" resources/views/pages/home.blade.php` — match (SKILL-04)
4. `grep "@foreach.*skills" resources/views/pages/home.blade.php` — match (SKILL-02)
5. `grep 'devicon-' resources/views/pages/home.blade.php` — match (SKILL-02 Devicon classes in foreach)
6. `php artisan serve` + visit http://localhost:8000 — Skills section renders carousel (visual check deferred to Plan E checkpoint)
</verification>

<success_criteria>
- PortfolioController passes $skills (12 entries) to view — SKILL-03
- Skills section uses .swiper-skills class matching the JS init selector — SKILL-01
- Each swiper-slide renders Devicon icon + skill name via @foreach — SKILL-02
- .swiper-pagination element present for clickable dots — SKILL-04
- Section heading has data-aos="fade-up" — VIS-02
- Hover state on skill cards uses transition-all duration-300 — VIS-03
</success_criteria>

<output>
After completion, create `.planning/phases/02-core-ui-sections/02-C-SUMMARY.md`
</output>
