# Roadmap: Portfólio Pessoal — Ygor Stefankowski da Silva

## Milestones

- ✅ **v1.0 MVP** — Phases 1-4 (shipped 2026-04-02)
- 🔄 **v2.0 Melhorias & Correções** — Phases 5-7 (in progress)

## Phases

<details>
<summary>✅ v1.0 MVP (Phases 1-4) — SHIPPED 2026-04-02</summary>

- [x] Phase 1: Foundation (3/3 planos) — completo
- [x] Phase 2: Core UI Sections (5/5 planos) — completo 2026-03-25
- [x] Phase 3: Contact Form Backend (4/4 planos) — completo 2026-03-25
- [x] Phase 4: Polish and Deploy (2/2 planos) — completo 2026-04-02

Full details: `.planning/milestones/v1.0-ROADMAP.md`

</details>

### v2.0 Melhorias & Correções

- [ ] **Phase 5: Bug Fixes & New Skills** — Corrigir os 4 bugs visuais/funcionais do MVP e expandir o carrossel de skills
- [ ] **Phase 6: Dark/Light Mode** — Toggle de tema escuro/claro persistido na navbar
- [ ] **Phase 7: 404 Page & Analytics** — Página de erro customizada e rastreamento de visitas sem cookies

## Phase Details

### Phase 5: Bug Fixes & New Skills
**Goal**: O portfólio funciona sem falhas visuais ou funcionais observáveis e o carrossel exibe todas as tecnologias relevantes do desenvolvedor
**Depends on**: Phase 4 (v1.0 shipped)
**Requirements**: BUG-01, BUG-02, BUG-03, BUG-04, SKILL-05
**Success Criteria** (what must be TRUE):
  1. A aba do Chrome para de girar assim que a página termina de carregar, sem spinner indefinido
  2. O ícone do LinkedIn exibe a mesma cor neutra dos demais ícones sociais em estado padrão e muda para azul somente no hover
  3. Ao rolar a página para cima, elementos com AOS exibem a animação de entrada novamente (mirror mode ativo)
  4. O card de skill mantém a borda azul do topo visível durante o hover expand, sem desaparecer
  5. O carrossel de skills exibe as 8 novas tecnologias: PostgreSQL, Node.js, React, Python, Bootstrap, AWS, Git e ícone de IA/ML
**Plans**: 3 planos
Plans:
- [x] 05-01-PLAN.md — BUG-02 (LinkedIn colored) + BUG-03 (AOS mirror mode)
- [x] 05-02-PLAN.md — BUG-04 (skill card border) + SKILL-05 (18 skills + IA/ML SVG)
- [ ] 05-03-PLAN.md — BUG-01 (Chrome spinner: diagnóstico + fix)
**UI hint**: yes

### Phase 6: Dark/Light Mode
**Goal**: Usuário pode alternar o tema visual do site e sua preferência é lembrada entre visitas
**Depends on**: Phase 5
**Requirements**: THEME-01
**Success Criteria** (what must be TRUE):
  1. Um botão toggle visível na navbar alterna o site entre tema escuro e tema claro com um clique
  2. Todos os elementos do site (fundo, textos, cards, navbar, footer) refletem corretamente o tema selecionado
  3. Ao recarregar a página ou abrir o site em nova aba, o tema escolhido anteriormente é restaurado automaticamente
  4. O toggle respeita a preferência de sistema (`prefers-color-scheme`) na primeira visita caso nenhuma preferência tenha sido salva
**Plans**: 2 planos
Plans:
- [x] 06-01-PLAN.md — Infraestrutura: script anti-FOUC no head + CSS @variant dark + variáveis light mode
- [ ] 06-02-PLAN.md — Toggle sol/lua na navbar + classes dark: em home.blade.php e footer.blade.php
**UI hint**: yes

### Phase 7: 404 Page & Analytics
**Goal**: Visitantes que chegam a URLs inexistentes têm uma experiência digna, e o dono do site consegue visualizar o volume de acessos sem comprometer a privacidade dos visitantes
**Depends on**: Phase 5
**Requirements**: ERR-01, ANA-01
**Success Criteria** (what must be TRUE):
  1. Acessar qualquer URL inexistente no domínio exibe uma página 404 customizada com mensagem amigável e link de retorno à home
  2. A página 404 mantém o visual do portfólio (navbar, estilo Tailwind) em vez de exibir a tela de erro padrão do Laravel/servidor
  3. O painel de analytics (Fathom ou Plausible) registra pageviews do site sem instalar cookies no navegador do visitante
**Plans**: TBD

## Progress

| Phase | Milestone | Plans Complete | Status | Completed |
|-------|-----------|----------------|--------|-----------|
| 1. Foundation | v1.0 | 3/3 | Complete | 2026-04-01 |
| 2. Core UI Sections | v1.0 | 5/5 | Complete | 2026-03-25 |
| 3. Contact Form Backend | v1.0 | 4/4 | Complete | 2026-03-25 |
| 4. Polish and Deploy | v1.0 | 2/2 | Complete | 2026-04-02 |
| 5. Bug Fixes & New Skills | v2.0 | 2/3 | In Progress|  |
| 6. Dark/Light Mode | v2.0 | 1/2 | In Progress|  |
| 7. 404 Page & Analytics | v2.0 | 0/? | Not started | - |

---
*v1.0 shipped 2026-04-02 — 4 phases, 14 plans, 41/41 requirements*
*v2.0 roadmap created 2026-04-01 — 3 phases, 9 requirements*
*Archive: .planning/milestones/v1.0-ROADMAP.md*
