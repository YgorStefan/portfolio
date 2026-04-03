# Roadmap: Portfólio Pessoal — Ygor Stefankowski da Silva

## Milestones

- ✅ **v1.0 MVP** — Phases 1-4 (shipped 2026-04-02)
- ✅ **v2.0 Melhorias & Correções** — Phases 5-7 (shipped 2026-04-02)
- 🔄 **v3.0 Visual Polish & Real Content** — Phases 8-9 (in progress)

## Phases

<details>
<summary>✅ v1.0 MVP (Phases 1-4) — SHIPPED 2026-04-02</summary>

- [x] Phase 1: Foundation (3/3 planos) — completo 2026-04-01
- [x] Phase 2: Core UI Sections (5/5 planos) — completo 2026-03-25
- [x] Phase 3: Contact Form Backend (4/4 planos) — completo 2026-03-25
- [x] Phase 4: Polish and Deploy (2/2 planos) — completo 2026-04-02

Full details: `.planning/milestones/v1.0-ROADMAP.md`

</details>

<details>
<summary>✅ v2.0 Melhorias & Correções (Phases 5-7) — SHIPPED 2026-04-02</summary>

- [x] Phase 5: Bug Fixes & New Skills (3/3 planos) — completo 2026-04-02
- [x] Phase 6: Dark/Light Mode (2/2 planos) — completo 2026-04-02
- [x] Phase 7: 404 Page & Analytics (1/1 plano) — completo 2026-04-02

Full details: `.planning/milestones/v2.0-ROADMAP.md`

</details>

### v3.0 Visual Polish & Real Content (Phases 8-9)

- [x] **Phase 8: Content & Visual Fixes** — Conteúdo real e ajustes visuais estáticos (completed 2026-04-03)
- [x] **Phase 9: Particle Animations** — Sistema de partículas interativas em 3 seções (completed 2026-04-03)

## Phase Details

### Phase 8: Content & Visual Fixes
**Goal**: O portfólio exibe conteúdo real e visual consistente — foto correta, projetos reais com links, footer igual ao header, favicon e logo com identidade definida
**Depends on**: Phase 7
**Requirements**: CONTENT-01, CONTENT-02, CONTENT-03, VISUAL-01, VISUAL-02, VISUAL-03
**Success Criteria** (what must be TRUE):
  1. A seção Sobre Mim exibe cartoon.jpeg — a foto correta do proprietário, não um placeholder
  2. A seção Projetos lista Portfólio, CRM e E-commerce com dados reais; os links de repositório do CRM e E-commerce abrem o GitHub correto em nova aba
  3. O footer tem fundo translúcido com blur e borda superior — visualmente consistente com o header
  4. A aba do browser exibe o favicon SVG "YSS" na cor accent (#38bdf8); o logo "YSS" na navbar expande para "Ygor Stefankowski da Silva" no hover com transição suave e volta para "YSS" ao sair
**Plans**: 2 planos
Plans:
- [x] 08-01-PLAN.md — Conteúdo real: foto cartoon.jpeg + 3 projetos reais em projects.json
- [x] 08-02-PLAN.md — Visual: footer com blur, favicon SVG YSS, logo navbar com hover expand
**UI hint**: yes

### Phase 9: Particle Animations
**Goal**: As seções Hero, Sobre Mim e Projetos exibem animação de partículas interativas que reagem ao movimento do mouse, visíveis em dark e light mode sem bloquear o conteúdo
**Depends on**: Phase 8
**Requirements**: ANIM-01, ANIM-02, ANIM-03, ANIM-04
**Success Criteria** (what must be TRUE):
  1. Ao mover o mouse sobre o Hero, Sobre Mim ou Projetos, as partículas se deslocam em resposta ao cursor
  2. As partículas são visíveis tanto no tema escuro quanto no claro — com contraste adequado em ambos os fundos
  3. O conteúdo de cada seção (texto, imagens, botões) permanece clicável e legível com o canvas ativo
  4. A animação usa um único componente JS reutilizado nas 3 seções, sem duplicação de código
**Plans**: 2 planos
Plans:
- [x] 09-01-PLAN.md — Módulo particles.js: engine de partículas interativas (Canvas API puro)
- [x] 09-02-PLAN.md — Integração Blade + app.js + verificação visual nas 3 seções
**UI hint**: yes

## Progress

| Phase | Milestone | Plans Complete | Status | Completed |
|-------|-----------|----------------|--------|-----------|
| 1. Foundation | v1.0 | 3/3 | Complete | 2026-04-01 |
| 2. Core UI Sections | v1.0 | 5/5 | Complete | 2026-03-25 |
| 3. Contact Form Backend | v1.0 | 4/4 | Complete | 2026-03-25 |
| 4. Polish and Deploy | v1.0 | 2/2 | Complete | 2026-04-02 |
| 5. Bug Fixes & New Skills | v2.0 | 3/3 | Complete | 2026-04-02 |
| 6. Dark/Light Mode | v2.0 | 2/2 | Complete | 2026-04-02 |
| 7. 404 Page & Analytics | v2.0 | 1/1 | Complete | 2026-04-02 |
| 8. Content & Visual Fixes | v3.0 | 2/2 | Complete   | 2026-04-03 |
| 9. Particle Animations | v3.0 | 2/2 | Complete   | 2026-04-03 |

---
*v1.0 shipped 2026-04-02 — 4 phases, 14 plans, 41/41 requirements*
*v2.0 shipped 2026-04-02 — 3 phases, 6 plans, 8/8 requirements*
*v3.0 started 2026-04-02 — 2 phases, 10 requirements*
*Archives: .planning/milestones/v1.0-ROADMAP.md | .planning/milestones/v2.0-ROADMAP.md*
