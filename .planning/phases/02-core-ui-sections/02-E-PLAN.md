---
phase: 02-core-ui-sections
plan: E
type: execute
wave: 3
depends_on: [02-B, 02-C, 02-D]
files_modified:
  - resources/views/pages/home.blade.php
autonomous: false
requirements: [HERO-01, HERO-02, HERO-03, HERO-04, ABOUT-01, ABOUT-02, ABOUT-03, ABOUT-04, SKILL-01, SKILL-02, SKILL-03, SKILL-04, PROJ-01, PROJ-02, PROJ-03, PROJ-04, PROJ-05, VIS-01, VIS-02, VIS-03, ASSET-01, ASSET-02, ASSET-03]

must_haves:
  truths:
    - "Contact section has a styled form with name, email, subject, and message fields (UI only — backend is Phase 3)"
    - "Contact section has social links for GitHub, LinkedIn, WhatsApp, and Email"
    - "npm run build exits 0 with all five sections populated"
    - "All five sections render at GET / with correct dark theme and accent color"
    - "No horizontal overflow at 320px, 375px, 768px, 1280px viewport widths"
    - "AOS animations fire when sections enter the viewport"
    - "Swiper Skills carousel scrolls and shows pagination dots"
    - "Project cards show hover overlay with Demo/Repo buttons"
  artifacts:
    - path: "resources/views/pages/home.blade.php"
      provides: "Complete home page with all 5 sections — no Phase 2 stubs remaining"
      contains: "id=\"contact\""
  key_links:
    - from: "contact form action"
      to: "Phase 3 POST /contact route"
      via: "action placeholder — wired in Phase 3"
      pattern: "id=\"contact\""
---

<objective>
Build the Contact section UI (form structure + social links, styled but non-functional — backend is Phase 3), run the final production build, and pause for a human visual checkpoint to verify all five portfolio sections render correctly with responsive layout and animations.

Purpose: The contact form HTML must exist before Phase 3 wires the backend. This plan closes Phase 2 — after the checkpoint passes, all visual requirements are verified and Phase 3 can begin.
Output: home.blade.php with all five sections complete; visual verification checkpoint.
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
<!-- Phase 3 contract: contact form action will be POST /contact -->
<!-- Phase 2 builds the HTML structure; Phase 3 adds the route and controller -->
<!-- The form action is intentionally empty/placeholder in this plan -->

<!-- Social links from REQUIREMENTS.md CONTACT-06 -->
Links needed:
  - GitHub:   https://github.com/ygor-stefankowski (placeholder — user updates URL)
  - LinkedIn: https://linkedin.com/in/ygor-stefankowski (placeholder)
  - WhatsApp: https://wa.me/55XXXXXXXXXXX (placeholder — user adds real number)
  - Email:    mailto:ygor@example.com (placeholder — user updates)

<!-- Tailwind v4 tokens -->
- bg-bg-primary  (#030712) — contact section background
- bg-bg-card     (#111827) — form background
- bg-accent      (#3b82f6) — submit button, icon accents
- border-accent  (#3b82f6) — form input focus ring
</interfaces>
</context>

<tasks>

<task type="auto">
  <name>Task 1: Build Contact section UI (form + social links) and run final build</name>
  <files>resources/views/pages/home.blade.php</files>
  <action>
Replace only the `#contact` section stub in home.blade.php. All other sections (Hero, About, Skills, Projects) must remain untouched.

Replace:
```blade
<section id="contact" class="min-h-screen flex items-center justify-center">
    <p class="text-gray-400 text-sm">Contato — Phase 2</p>
</section>
```

With:
```blade
<section id="contact" class="py-24 bg-bg-card">
    <div class="container mx-auto px-6">

        {{-- Section heading --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Contato</h2>
            <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
            <p class="text-gray-400 mt-4 max-w-xl mx-auto">
                Tem um projeto em mente ou quer bater um papo? Manda uma mensagem!
            </p>
        </div>

        <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- Contact form -- CONTACT-01 (UI only; backend wired in Phase 3) --}}
            <div data-aos="fade-right">
                {{-- NOTE: action="" is intentionally empty. Phase 3 adds action="{{ route('contact.send') }}" --}}
                {{-- NOTE: Phase 3 also adds @csrf and method="POST" --}}
                <form action="" method="POST" class="space-y-6" id="contact-form">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                            Nome
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               placeholder="Seu nome completo"
                               class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                      text-white placeholder-gray-500
                                      focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                      transition-colors duration-300">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            E-mail
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               placeholder="seu@email.com"
                               class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                      text-white placeholder-gray-500
                                      focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                      transition-colors duration-300">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">
                            Assunto
                        </label>
                        <input type="text"
                               id="subject"
                               name="subject"
                               placeholder="Sobre o que você quer falar?"
                               class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                      text-white placeholder-gray-500
                                      focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                      transition-colors duration-300">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300 mb-2">
                            Mensagem
                        </label>
                        <textarea id="message"
                                  name="message"
                                  rows="5"
                                  placeholder="Escreva sua mensagem aqui..."
                                  class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                         text-white placeholder-gray-500 resize-none
                                         focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                         transition-colors duration-300"></textarea>
                    </div>

                    {{-- Submit button — Phase 3 will disable this on submission --}}
                    <button type="submit"
                            class="w-full bg-accent hover:bg-accent/90 text-white font-semibold
                                   py-3 px-6 rounded-lg transition-all duration-300 hover:-translate-y-0.5
                                   focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-bg-card">
                        Enviar Mensagem
                    </button>

                </form>
            </div>

            {{-- Social links -- CONTACT-06 --}}
            <div class="space-y-8" data-aos="fade-left">

                <div>
                    <h3 class="text-xl font-bold text-white mb-6">Onde me encontrar</h3>
                    <div class="space-y-4">

                        {{-- GitHub --}}
                        <a href="https://github.com/ygor-stefankowski"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                            <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                         border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                <i class="devicon-github-plain text-2xl"></i>
                            </span>
                            <div>
                                <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">GitHub</p>
                                <p class="text-sm">github.com/ygor-stefankowski</p>
                            </div>
                        </a>

                        {{-- LinkedIn --}}
                        <a href="https://linkedin.com/in/ygor-stefankowski"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                            <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                         border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                <i class="devicon-linkedin-plain colored text-2xl"></i>
                            </span>
                            <div>
                                <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">LinkedIn</p>
                                <p class="text-sm">linkedin.com/in/ygor-stefankowski</p>
                            </div>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/55XXXXXXXXXXX"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                            <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                         border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">WhatsApp</p>
                                <p class="text-sm">Clique para conversar</p>
                            </div>
                        </a>

                        {{-- Email --}}
                        <a href="mailto:ygor@example.com"
                           class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                            <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                         border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">E-mail</p>
                                <p class="text-sm">ygor@example.com</p>
                            </div>
                        </a>

                    </div>
                </div>

                {{-- Availability note --}}
                <div class="bg-bg-primary rounded-xl p-6 border border-gray-700">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="text-white font-medium">Disponível para novas oportunidades</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Estou aberto a propostas de emprego CLT, PJ ou freela. Respondo em até 24h.
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>
```

IMPORTANT: The form action is intentionally empty — Phase 3 adds the route, @csrf token, and controller. Do NOT add @csrf here, as without the route it would cause a CSRF validation error on any test submit.
NOTE: Social link URLs are placeholders. User must update GitHub URL, LinkedIn URL, WhatsApp number (wa.me/55 + DDD + number), and email address before deployment.
NOTE: The `devicon-linkedin-plain colored` and `devicon-github-plain` icons require the Devicon CDN link added in Plan A.

After writing the Contact section, run the final production build:
```bash
cd C:/Users/Ygor/portifolio && npm run build
```
Verify build exits 0 before proceeding to the checkpoint.
  </action>
  <verify>
    <automated>cd C:/Users/Ygor/portifolio && npm run build 2>&1 | tail -10</automated>
    Also: `grep "id=\"contact-form\"" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
    Also: `grep "wa.me" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php`
    Also: `grep "Phase 2" C:/Users/Ygor/portifolio/resources/views/pages/home.blade.php` — must return EMPTY (all stubs replaced)
  </verify>
  <done>Contact section has form with 4 fields + submit button; has 4 social links (GitHub, LinkedIn, WhatsApp, Email); npm run build exits 0; no "Phase 2" stub text remains in home.blade.php</done>
</task>

<task type="checkpoint:human-verify" gate="blocking">
  <what-built>
All five portfolio sections are now complete in home.blade.php:
- Hero: name, role, profile photo, CTA button, AOS staggered entrance
- About: bio text, profile photo, CV download button with AOS side-entry
- Skills: Swiper.js carousel with Devicon icons, pagination dots, autoplay
- Projects: responsive grid from JSON data, hover overlay with Demo/Repo links
- Contact: form UI (4 fields + submit), 4 social links, availability badge

A production build has been compiled (npm run build).
  </what-built>
  <how-to-verify>
1. Start the dev server: `php artisan serve` (http://localhost:8000) and `npm run dev` in a separate terminal (or test from the compiled build)

2. HERO SECTION (http://localhost:8000/#hero):
   - [ ] Name "Ygor Stefankowski da Silva" visible
   - [ ] "Desenvolvedor Full Stack" visible in accent blue
   - [ ] Profile photo renders (or shows as filled square if placeholder)
   - [ ] "Entre em Contato" button links to #contact (smooth scroll)
   - [ ] "Ver Projetos" button links to #projects
   - [ ] Elements animate in on page load (fade-up stagger)

3. ABOUT SECTION (scroll or click nav "Sobre"):
   - [ ] Bio text in two-column layout (single column on mobile)
   - [ ] Profile photo on the right (or below on mobile)
   - [ ] "Download CV" button present (clicking downloads or opens a file)
   - [ ] Section animates in when scrolled into view

4. SKILLS SECTION (scroll or click nav "Habilidades"):
   - [ ] Carousel shows skill cards with icons
   - [ ] Carousel auto-advances every 3 seconds
   - [ ] Pagination dots visible below carousel
   - [ ] Dots are clickable to jump to a slide
   - [ ] On mobile: 2 cards visible; on desktop: 5 cards visible

5. PROJECTS SECTION (scroll or click nav "Projetos"):
   - [ ] 4 project cards visible in grid layout
   - [ ] Cards are 1-column on mobile, 3-column on desktop
   - [ ] Cards show title, description, tech tag badges
   - [ ] Hovering a card reveals the overlay — at least a "Repositório" button (demo links are null in sample data)
   - [ ] Cards animate in on scroll

6. CONTACT SECTION (scroll or click nav "Contato"):
   - [ ] Form visible with Name, Email, Subject, Message fields
   - [ ] Submit button visible ("Enviar Mensagem")
   - [ ] 4 social links visible: GitHub, LinkedIn, WhatsApp, Email
   - [ ] Availability badge with green pulsing dot visible
   - [ ] Form fields have visible focus ring (accent blue) when clicked

7. RESPONSIVE CHECK — resize browser to 375px width (mobile):
   - [ ] No horizontal scrollbar / overflow
   - [ ] Nav hamburger appears; clicking opens mobile menu
   - [ ] Hero stacks to single column
   - [ ] About stacks to single column (photo below text)
   - [ ] Contact form and social links stack vertically

8. DARK THEME CHECK:
   - [ ] All backgrounds are dark (no white sections)
   - [ ] Electric blue accent color on buttons, tags, borders, hover states
   - [ ] No hardcoded colors looking out of place (no red, green, random colors)

9. OVERALL BUILD:
   - [ ] `npm run build` exits 0 (run: `npm run build` in project root)
  </how-to-verify>
  <resume-signal>
If all checks pass: type "approved" to complete Phase 2.
If issues found: describe each problem (e.g., "Swiper carousel not scrolling", "About photo missing"). The executor will fix and re-run the checkpoint.

NOTE: These items are expected before deployment (not blocking for checkpoint approval):
- Profile photo shows as a colored square (placeholder from Plan A) — replace with real photo
- Project images 404 (no real images in public/images/projects/) — replace with real images
- Social link URLs are placeholders — update before go-live
- Form submits but shows error (no backend yet) — Phase 3 wires the backend
  </resume-signal>
</task>

</tasks>

<verification>
After checkpoint approved:
1. `grep "Phase 2" resources/views/pages/home.blade.php` — no output (all stubs replaced)
2. `npm run build` — exits 0
3. `grep -c "data-aos" resources/views/pages/home.blade.php` — count >= 10 across all sections
4. `grep "id=\"contact-form\"" resources/views/pages/home.blade.php` — match
5. All 5 section IDs present: `grep -E 'id="(hero|about|skills|projects|contact)"' resources/views/pages/home.blade.php` — 5 matches
</verification>

<success_criteria>
- Contact section: form with name/email/subject/message fields + submit button (UI only, backend Phase 3)
- Contact section: GitHub, LinkedIn, WhatsApp, Email social links visible
- npm run build exits 0 with all 5 sections compiled
- Human checkpoint passed: all sections render with dark theme, electric blue accent, AOS animations, responsive layout
- No horizontal overflow at 320px-1280px viewport widths
- Phase 2 complete — all HERO, ABOUT, SKILL, PROJ, VIS, ASSET requirements verified
</success_criteria>

<output>
After completion, create `.planning/phases/02-core-ui-sections/02-E-SUMMARY.md`
</output>
