---
phase: 01-foundation
plan: A
type: execute
wave: 1
depends_on: []
files_modified:
  - vite.config.js
  - resources/css/app.css
  - resources/js/app.js
  - composer.json
  - .env.example
  - package.json
  - data/projects.json
autonomous: true
requirements:
  - INFRA-01
  - INFRA-02
  - INFRA-04
  - VIS-04

must_haves:
  truths:
    - "Running `npm run build` completes with exit code 0 and no errors in the terminal"
    - "`public/build/manifest.json` exists after the build and references app.css and app.js"
    - "`resources/css/app.css` begins with `@import \"tailwindcss\"` and contains a `@layer base` block with a Google Fonts `@import url(...)` and a `@theme {}` block with custom tokens"
    - "`resources/js/app.js` registers `@alpinejs/intersect` via `Alpine.plugin(intersect)` before calling `Alpine.start()`"
    - "`composer.json` requires `\"php\": \"^8.2\"` (not ^8.3)"
    - "`.env.example` documents all required Phase 1 variables including commented-out MAIL_* vars for Phase 3"
    - "`data/projects.json` exists at the project root and contains a valid empty JSON array `[]`"
  artifacts:
    - path: "vite.config.js"
      provides: "Vite build configuration with laravel + tailwindcss v4 plugins"
      contains: "@tailwindcss/vite"
    - path: "resources/css/app.css"
      provides: "CSS entry point with Tailwind v4 import, Google Fonts, design tokens"
      contains: "@import \"tailwindcss\""
    - path: "resources/js/app.js"
      provides: "JS entry point with Alpine.js + intersect plugin registered"
      contains: "Alpine.plugin(intersect)"
    - path: "public/build/manifest.json"
      provides: "Vite production build manifest confirming successful compile"
    - path: "data/projects.json"
      provides: "Projects data stub — empty array, schema populated in Phase 2"
    - path: ".env.example"
      provides: "Documented environment variable reference for all phases"
  key_links:
    - from: "vite.config.js"
      to: "resources/css/app.css + resources/js/app.js"
      via: "laravel-vite-plugin input array"
      pattern: "input: \\['resources/css/app.css', 'resources/js/app.js'\\]"
    - from: "resources/css/app.css"
      to: "fonts.googleapis.com"
      via: "@import url() inside @layer base"
      pattern: "@layer base"
    - from: "resources/js/app.js"
      to: "Alpine.js + @alpinejs/intersect"
      via: "npm import + Alpine.plugin()"
      pattern: "Alpine.plugin\\(intersect\\)"
---

<objective>
Create the Laravel 12 project and wire the complete Vite + Tailwind v4 + Alpine.js asset pipeline so that `npm run build` produces a clean production build in `public/build/`. Also establish the `.env.example` contract and the `data/projects.json` stub.

Purpose: Every subsequent plan in this phase and all later phases depends on this pipeline being correct. A bad Tailwind v4 or Vite configuration causes silent failures (missing CSS classes, no JS) that are hard to diagnose later.

Output: A buildable Laravel 12 project with `public/build/manifest.json` confirming the pipeline works.
</objective>

<execution_context>
@$HOME/.claude/get-shit-done/workflows/execute-plan.md
@$HOME/.claude/get-shit-done/templates/summary.md
</execution_context>

<context>
@.planning/PROJECT.md
@.planning/ROADMAP.md
@.planning/phases/01-foundation/01-RESEARCH.md

<interfaces>
<!-- Key technical facts — no codebase exploration needed. -->

Tailwind v4 is CSS-first. There is NO tailwind.config.js and NO postcss.config.js. Content scanning is automatic via the @tailwindcss/vite Vite plugin.

Required package versions (verified from npm registry 2026-03-24):
  tailwindcss@4.2.2
  @tailwindcss/vite@4.2.2
  laravel-vite-plugin@3.0.0
  alpinejs@3.15.8
  @alpinejs/intersect@3.15.8

Laravel 12 creation command:
  composer create-project laravel/laravel .
  (run from inside the portifolio/ working directory)

PHP constraint: pin "php": "^8.2" in composer.json (local is 8.3, Hostinger ceiling is 8.2).

Anti-pattern: do NOT create tailwind.config.js or postcss.config.js — they conflict with @tailwindcss/vite.
</interfaces>
</context>

<tasks>

<task type="auto">
  <name>Task 1: Create Laravel project and install asset pipeline packages</name>
  <files>
    composer.json
    package.json
    vite.config.js
    resources/css/app.css
    resources/js/app.js
  </files>
  <read_first>
    - C:/Users/Ygor/portifolio/composer.json (read after creation to verify php constraint)
    - C:/Users/Ygor/portifolio/package.json (read after creation to verify installed versions)
    - C:/Users/Ygor/portifolio/vite.config.js (read current content before replacing)
    - C:/Users/Ygor/portifolio/resources/css/app.css (read current content before replacing)
    - C:/Users/Ygor/portifolio/resources/js/app.js (read current content before replacing)
  </read_first>
  <action>
    Step 1 — Create the Laravel project inside the portifolio directory. The working directory IS the project root:
    ```
    cd C:/Users/Ygor/portifolio
    composer create-project laravel/laravel .
    ```

    Step 2 — Pin PHP to 8.2 in composer.json. Open composer.json, find the "require" block, change the "php" line to:
    ```json
    "php": "^8.2"
    ```
    Then run: composer update --no-interaction

    Step 3 — Install Tailwind v4 + Alpine.js packages:
    ```
    npm install tailwindcss@4.2.2 @tailwindcss/vite@4.2.2 alpinejs@3.15.8 @alpinejs/intersect@3.15.8
    ```

    Step 4 — Replace vite.config.js with the exact content below (do NOT keep the default Laravel vite.config.js content):
    ```js
    import { defineConfig } from 'vite';
    import laravel from 'laravel-vite-plugin';
    import tailwindcss from '@tailwindcss/vite';

    export default defineConfig({
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            tailwindcss(),
        ],
    });
    ```

    Step 5 — Replace resources/css/app.css with the exact content below (remove all existing content first):
    ```css
    @import "tailwindcss";

    @layer base {
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    }

    @theme {
        --color-accent: #3b82f6;
        --color-bg-primary: #030712;
        --color-bg-card: #111827;
        --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
    }
    ```

    Step 6 — Replace resources/js/app.js with the exact content below (remove all existing content first):
    ```js
    import Alpine from 'alpinejs';
    import intersect from '@alpinejs/intersect';

    Alpine.plugin(intersect);
    window.Alpine = Alpine;
    Alpine.start();
    ```

    IMPORTANT: Do NOT create tailwind.config.js or postcss.config.js. These files conflict with @tailwindcss/vite and are the v3 pattern — Tailwind v4 does not use them.
  </action>
  <verify>
    Run: npm run build

    Expected: exits with code 0, no errors in terminal output.

    Then check:
    - `ls public/build/` — must show manifest.json and at least one .css and one .js file
    - `cat package.json | grep tailwindcss` — must show "@tailwindcss/vite": "4.2.2" and "tailwindcss": "4.2.2"
    - `cat package.json | grep alpinejs` — must show "alpinejs": "3.15.8"
    - `cat composer.json | grep '"php"'` — must show "^8.2"
    - `ls tailwind.config.js 2>/dev/null || echo "GOOD - file does not exist"` — must print GOOD
    - `ls postcss.config.js 2>/dev/null || echo "GOOD - file does not exist"` — must print GOOD
  </verify>
  <acceptance_criteria>
    - `public/build/manifest.json` exists (grep-verifiable: `ls public/build/manifest.json`)
    - `vite.config.js` contains the string `@tailwindcss/vite` (grep: `grep "@tailwindcss/vite" vite.config.js`)
    - `vite.config.js` contains `resources/css/app.css` and `resources/js/app.js` in the input array (grep: `grep "resources/css/app.css" vite.config.js`)
    - `resources/css/app.css` first line is `@import "tailwindcss"` (grep: `grep -n "^@import" resources/css/app.css | head -1` must show `@import "tailwindcss"`)
    - `resources/css/app.css` contains `@layer base` block (grep: `grep "@layer base" resources/css/app.css`)
    - `resources/css/app.css` contains fonts.googleapis.com import (grep: `grep "fonts.googleapis.com" resources/css/app.css`)
    - `resources/css/app.css` contains `@theme` block with `--color-accent` (grep: `grep "\-\-color-accent" resources/css/app.css`)
    - `resources/js/app.js` contains `Alpine.plugin(intersect)` (grep: `grep "Alpine.plugin(intersect)" resources/js/app.js`)
    - `resources/js/app.js` contains `Alpine.start()` (grep: `grep "Alpine.start()" resources/js/app.js`)
    - `composer.json` contains `"php": "^8.2"` (grep: `grep '"php": "\^8.2"' composer.json`)
    - `tailwind.config.js` does NOT exist (`ls tailwind.config.js 2>/dev/null` returns no output)
    - `postcss.config.js` does NOT exist (`ls postcss.config.js 2>/dev/null` returns no output)
  </acceptance_criteria>
  <done>
    `npm run build` exits 0. `public/build/manifest.json` exists. vite.config.js uses @tailwindcss/vite plugin. app.css starts with @import "tailwindcss" and has Google Fonts inside @layer base and @theme tokens. app.js registers Alpine intersect plugin. composer.json pins php to ^8.2. No tailwind.config.js or postcss.config.js present.
  </done>
</task>

<task type="auto">
  <name>Task 2: Create .env.example and data/projects.json stub</name>
  <files>
    .env.example
    data/projects.json
  </files>
  <read_first>
    - C:/Users/Ygor/portifolio/.env.example (read current content — Laravel generates a default; replace it)
    - C:/Users/Ygor/portifolio/.env (read to confirm APP_KEY was generated by composer create-project)
  </read_first>
  <action>
    Step 1 — Replace .env.example with the exact content below. This is the documented variable reference for all four phases:
    ```dotenv
    APP_NAME=Portfolio
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug

    # Production deploy: set the three variables below before going live
    # APP_ENV=production
    # APP_DEBUG=false
    # APP_URL=https://yourdomain.com

    # Mail variables (configured in Phase 3 — leave commented until then):
    # MAIL_MAILER=smtp
    # MAIL_HOST=
    # MAIL_PORT=587
    # MAIL_USERNAME=
    # MAIL_PASSWORD=
    # MAIL_ENCRYPTION=tls
    # MAIL_FROM_ADDRESS=contato@yourdomain.com
    # MAIL_FROM_NAME="${APP_NAME}"
    # MAIL_OWNER_ADDRESS=ygor@yourdomain.com
    ```

    Step 2 — Create the data/ directory and data/projects.json stub:
    ```
    mkdir -p data
    ```
    Write data/projects.json with exactly this content:
    ```json
    []
    ```
    This is a valid empty JSON array. The schema and real project data are populated in Phase 2 (PROJ-01 through PROJ-05).
  </action>
  <verify>
    - `cat .env.example | grep "APP_KEY="` — must show `APP_KEY=` (blank, no value — user generates per-environment)
    - `cat .env.example | grep "MAIL_MAILER"` — must show the commented line `# MAIL_MAILER=smtp`
    - `cat .env.example | grep "APP_URL"` — must show `APP_URL=http://localhost`
    - `cat .env.example | grep "MAIL_OWNER_ADDRESS"` — must show `# MAIL_OWNER_ADDRESS=ygor@yourdomain.com`
    - `cat data/projects.json` — must output exactly `[]`
    - `php -r "echo json_decode(file_get_contents('data/projects.json')) === null ? 'INVALID' : 'VALID';"` — must print VALID
  </verify>
  <acceptance_criteria>
    - `.env.example` contains `APP_KEY=` with no value after the equals sign (grep: `grep "^APP_KEY=$" .env.example`)
    - `.env.example` contains `APP_DEBUG=true` for local development (grep: `grep "^APP_DEBUG=true" .env.example`)
    - `.env.example` contains commented production override comment (grep: `grep "APP_DEBUG=false" .env.example`)
    - `.env.example` contains commented `MAIL_MAILER=smtp` line (grep: `grep "# MAIL_MAILER=smtp" .env.example`)
    - `.env.example` contains commented `MAIL_OWNER_ADDRESS` line for Phase 3 (grep: `grep "MAIL_OWNER_ADDRESS" .env.example`)
    - `data/projects.json` exists (grep: `ls data/projects.json`)
    - `data/projects.json` content is exactly `[]` (grep: `grep "^\[\]$" data/projects.json`)
  </acceptance_criteria>
  <done>
    .env.example documents all Phase 1 through Phase 3 variables with comments explaining production overrides and Phase 3 mail vars. data/projects.json is a valid empty JSON array at the project root.
  </done>
</task>

</tasks>

<verification>
After both tasks complete:

1. `npm run build` exits 0 with no errors — confirms INFRA-01 and INFRA-02
2. `ls public/build/` shows manifest.json plus compiled .css and .js files — confirms INFRA-02
3. `grep "@tailwindcss/vite" vite.config.js` returns a match — confirms Tailwind v4 CSS-first setup
4. `grep "fonts.googleapis.com" resources/css/app.css` returns a match inside @layer base — confirms VIS-04 foundation
5. `grep "Alpine.plugin(intersect)" resources/js/app.js` returns a match — confirms Alpine + intersect wired
6. `grep '"php": "\^8.2"' composer.json` returns a match — confirms PHP version pinned for Hostinger
7. `cat data/projects.json` outputs `[]` — confirms stub in place
8. `grep "MAIL_OWNER_ADDRESS" .env.example` returns a match — confirms INFRA-04
9. `ls tailwind.config.js 2>/dev/null` returns nothing — confirms no v3 config pollution
</verification>

<success_criteria>
- `npm run build` produces `public/build/manifest.json` with zero terminal errors (INFRA-01, INFRA-02)
- `resources/css/app.css` contains `@import "tailwindcss"` on line 1, `@layer base` with Google Fonts import, and `@theme` with --color-accent, --color-bg-primary, --color-bg-card, --font-sans tokens (VIS-04)
- `resources/js/app.js` initializes Alpine with intersect plugin registered before Alpine.start() (foundation for LAYOUT-03, LAYOUT-04)
- `composer.json` requires `"php": "^8.2"` (Hostinger compatibility)
- `.env.example` documents APP_*, LOG_*, and commented MAIL_* variables with production override comments (INFRA-04)
- `data/projects.json` is a valid empty JSON array (foundation for Phase 2 PROJ-01)
- No tailwind.config.js or postcss.config.js exists in the project root
</success_criteria>

<output>
After completion, create `.planning/phases/01-foundation/01-A-SUMMARY.md` with:
- What was built (pipeline config files, .env.example, projects stub)
- Key decisions made (exact package versions installed, PHP constraint rationale)
- Verification results (build output, manifest.json contents)
- Any deviations from the plan and why
</output>
