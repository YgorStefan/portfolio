---
phase: 02-core-ui-sections
plan: A
type: execute
wave: 1
depends_on: []
files_modified:
  - package.json
  - resources/js/app.js
  - resources/views/layouts/app.blade.php
  - public/images/profile.jpg
  - public/files/curriculo.pdf
  - public/images/projects/.gitkeep
autonomous: true
requirements: [VIS-02, SKILL-01, ASSET-01, ASSET-02, ASSET-03]

must_haves:
  truths:
    - "npm run build exits 0 after swiper and aos are added to app.js"
    - "AOS.init() is wrapped in DOMContentLoaded to avoid the Vite timing pitfall"
    - "Swiper CSS is imported in app.js (not app.css) to avoid cascade order issues"
    - "Devicon CDN link is in layouts/app.blade.php head"
    - "Placeholder assets exist at the correct public/ paths so <img> tags do not 404"
  artifacts:
    - path: "resources/js/app.js"
      provides: "Swiper + AOS initialization with DOMContentLoaded guard"
      exports: [AOS.init, new Swiper]
    - path: "resources/views/layouts/app.blade.php"
      provides: "Devicon CDN link in <head>"
      contains: "cdn.jsdelivr.net/gh/devicons/devicon"
    - path: "public/images/profile.jpg"
      provides: "Placeholder profile photo so hero/about img tags resolve"
    - path: "public/files/curriculo.pdf"
      provides: "Placeholder PDF so CV download link resolves"
    - path: "public/images/projects/.gitkeep"
      provides: "Projects image directory for ASSET-03"
  key_links:
    - from: "resources/js/app.js"
      to: "swiper npm package"
      via: "import Swiper from 'swiper'"
      pattern: "import Swiper from 'swiper'"
    - from: "resources/js/app.js"
      to: "aos npm package"
      via: "import AOS from 'aos'"
      pattern: "import AOS from 'aos'"
---

<objective>
Install Swiper.js and AOS npm packages, wire both into resources/js/app.js with the correct DOMContentLoaded initialization pattern, add the Devicon CDN link to the master layout, and create placeholder assets in public/ so subsequent plans can reference profile photo, CV PDF, and project images without 404 errors.

Purpose: This is the dependency setup wave. All later plans (B, C, D, E) assume swiper and aos are importable and that public/images/profile.jpg and public/files/curriculo.pdf exist. Without this plan, Plans B-E cannot compile or render correctly.
Output: Updated app.js with Swiper+AOS init, updated layouts/app.blade.php with Devicon link, placeholder asset files in public/.
</objective>

<execution_context>
@$HOME/.claude/get-shit-done/workflows/execute-plan.md
@$HOME/.claude/get-shit-done/templates/summary.md
</execution_context>

<context>
@.planning/PROJECT.md
@.planning/ROADMAP.md
@.planning/STATE.md
@.planning/phases/02-core-ui-sections/02-RESEARCH.md
@.planning/phases/01-foundation/01-A-SUMMARY.md
@.planning/phases/01-foundation/01-B-SUMMARY.md

<interfaces>
<!-- Existing contracts the executor must respect -->

From resources/js/app.js (current content — REPLACE entirely):
```js
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();
```

From resources/views/layouts/app.blade.php (current <head> — ADD Devicon link after @vite):
```html
<head>
    ...
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- ADD Devicon link here -->
</head>
```

Tailwind v4 theme tokens (from app.css @theme block — do not change):
- --color-accent: #3b82f6   → bg-accent, text-accent, border-accent
- --color-bg-primary: #030712  → bg-bg-primary
- --color-bg-card: #111827    → bg-bg-card
</interfaces>
</context>

<tasks>

<task type="auto">
  <name>Task 1: Install Swiper + AOS and rewrite app.js with correct init pattern</name>
  <files>package.json, resources/js/app.js</files>
  <action>
Run: `npm install swiper@12.1.3 aos@2.3.4` from the project root (C:/Users/Ygor/portifolio).

Then REPLACE the entire content of resources/js/app.js with:

```js
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
    // AOS — must be DOMContentLoaded; calling AOS.init() at module scope fails silently in Vite
    AOS.init({
        duration: 700,
        once: true,
        offset: 80,
    });

    // Swiper skills carousel — selector .swiper-skills matches Plan C markup
    new Swiper('.swiper-skills', {
        modules: [Pagination, Autoplay],
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

CRITICAL: Do NOT add a second `@vite` call anywhere. The master layout already has the single @vite directive.
CRITICAL: Import Swiper CSS in app.js, not app.css, to avoid Tailwind v4 cascade ordering issues.
CRITICAL: Wrap both AOS.init() and new Swiper() inside DOMContentLoaded — calling either at module scope silently fails in Vite builds.
  </action>
  <verify>
    <automated>cd C:/Users/Ygor/portifolio && npm run build 2>&1 | tail -5</automated>
    Also run: `grep "DOMContentLoaded" C:/Users/Ygor/portifolio/resources/js/app.js` — must match
    Also run: `grep "AOS.init" C:/Users/Ygor/portifolio/resources/js/app.js` — must match
  </verify>
  <done>npm run build exits 0; app.js contains DOMContentLoaded guard, AOS.init(), new Swiper(); swiper and aos appear in package.json dependencies</done>
</task>

<task type="auto">
  <name>Task 2: Add Devicon CDN to master layout and create placeholder assets</name>
  <files>resources/views/layouts/app.blade.php, public/images/profile.jpg, public/files/curriculo.pdf, public/images/projects/.gitkeep</files>
  <action>
1. Open resources/views/layouts/app.blade.php. After the `@vite(...)` line in `<head>`, add the Devicon CDN link:
   ```html
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
   ```
   The full head should look like:
   ```html
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Ygor Stefankowski — Desenvolvedor Full Stack</title>
       <meta name="description" content="Portfólio de Ygor Stefankowski da Silva, Desenvolvedor Full Stack.">
       @vite(['resources/css/app.css', 'resources/js/app.js'])
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
   </head>
   ```

2. Create the directories and placeholder assets:
   - Create directory: public/images/projects/
   - Create placeholder file: public/images/projects/.gitkeep (empty file)
   - Create public/files/ directory if it doesn't exist
   - Create a minimal placeholder PDF at public/files/curriculo.pdf — a 1-line text file renamed to .pdf is sufficient as a placeholder. The user must replace this with their real CV before deployment. Add a comment in the file: "Placeholder — replace with real PDF before deploy"
   - Create a minimal placeholder image at public/images/profile.jpg. Since we cannot generate a real JPEG in bash, create a 1x1 pixel valid JPEG using PHP:
     ```bash
     cd C:/Users/Ygor/portifolio && php -r "
     \$img = imagecreatetruecolor(400, 400);
     \$bg = imagecolorallocate(\$img, 17, 24, 39);
     \$text = imagecolorallocate(\$img, 59, 130, 246);
     imagefill(\$img, 0, 0, \$bg);
     imagejpeg(\$img, 'public/images/profile.jpg', 85);
     imagedestroy(\$img);
     echo 'created';
     "
     ```
     If PHP GD is unavailable, copy any existing image to public/images/profile.jpg, OR create an SVG placeholder instead and note that the user must supply a real JPEG before deployment.

NOTE for user: public/images/profile.jpg and public/files/curriculo.pdf are placeholders. Replace them with your real photo and CV PDF before the Phase 4 deployment. Project images go in public/images/projects/.
  </action>
  <verify>
    <automated>cd C:/Users/Ygor/portifolio && grep "devicons/devicon" resources/views/layouts/app.blade.php && ls public/files/curriculo.pdf && ls public/images/profile.jpg && ls public/images/projects/</automated>
  </verify>
  <done>layouts/app.blade.php contains Devicon CDN link; public/files/curriculo.pdf exists; public/images/profile.jpg exists; public/images/projects/ directory exists</done>
</task>

</tasks>

<verification>
After both tasks complete:
1. `npm run build` exits 0 — Swiper + AOS compile without errors
2. `grep "DOMContentLoaded" resources/js/app.js` — match
3. `grep "cdn.jsdelivr.net/gh/devicons" resources/views/layouts/app.blade.php` — match
4. `ls public/images/profile.jpg` — file exists
5. `ls public/files/curriculo.pdf` — file exists
6. `ls public/images/projects/` — directory exists
</verification>

<success_criteria>
- swiper@12.1.3 and aos@2.3.4 are in package.json dependencies
- app.js imports Swiper (modular), AOS, their CSS files, and wraps init in DOMContentLoaded
- Devicon CDN link is in layouts/app.blade.php head — skill icons will load from jsDelivr
- Placeholder files exist at public/images/profile.jpg and public/files/curriculo.pdf
- public/images/projects/ directory exists for project image assets
- npm run build exits 0 with all new imports
</success_criteria>

<output>
After completion, create `.planning/phases/02-core-ui-sections/02-A-SUMMARY.md`
</output>
