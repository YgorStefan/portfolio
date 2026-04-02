# Phase 6: Dark/Light Mode - Context

**Gathered:** 2026-04-02
**Status:** Ready for planning

<domain>
## Phase Boundary

Implementar toggle de tema escuro/claro na navbar com persistência via localStorage e respeito ao `prefers-color-scheme` na primeira visita. O site já é dark-first — esta fase adiciona o modo claro e o mecanismo de alternância.

Fora de escopo: redesign de cores, mudanças estruturais no layout, novos componentes além do toggle.

</domain>

<decisions>
## Implementation Decisions

### Abordagem técnica (decidida em STATE.md — não re-discutida)
- **D-01:** Alpine.js + localStorage + classe `.dark` no elemento `<html>`
- **D-02:** `@variant dark` em `app.css` para as regras de tema claro (dark = estado padrão atual, `.dark` = dark mode class que ativa o tema escuro; light mode é o estado sem `.dark`)
- **D-03:** Script inline no `<head>` (antes do Vite bundle) para ler localStorage e aplicar `.dark` imediatamente — elimina flash de tema (FOUC)

> **Nota de inversão:** O site atual é dark-first sem classe. A abordagem adotada usa `.dark` para representar o dark mode, então o estado padrão do HTML sem classe = light. O script inline aplica `.dark` quando localStorage = "dark" ou (localStorage vazio + prefers-color-scheme = dark).

### Paleta do tema claro
- **D-04:** Cores do light mode:
  - Fundo principal: `#f9fafb` (gray-50)
  - Cards/superfícies: `#ffffff` (white)
  - Texto principal: `#111827` (gray-900)
  - Acento: `#3b82f6` (mantido — mesmo azul elétrico)
- **D-05:** Navbar em light mode: fundo branco/gray-50 semi-transparente com `backdrop-blur-sm`, borda `border-gray-200`
- **D-06:** Elementos que precisam de `@variant dark`: `<html>`, `<body>`, navbar, cards de skills, cards de projetos, footer, seções de fundo alternado

### Ícone do toggle
- **D-07:** SVG inline de sol (no dark mode → clique ativa light) e lua (no light mode → clique ativa dark)
- **D-08:** Animação de `rotate` + `scale` ao alternar (Alpine.js transition ou CSS transform)
- **D-09:** Posicionamento:
  - Desktop: ao lado direito dos links de navegação, antes de qualquer outro elemento de ação
  - Mobile: entre o logo "YS" e o botão hamburger (à esquerda do hamburger)
- **D-10:** Estilo: mesmo visual do botão hamburger atual — `text-gray-300 hover:text-white transition-colors p-2`; em light mode: `text-gray-600 hover:text-gray-900`

### Transição ao trocar tema
- **D-11:** CSS transition suave de **150ms** em `background-color` e `color` nos elementos principais
- **D-12:** O script inline no `<head>` deve adicionar uma classe `no-transition` ao `<html>` durante o carregamento inicial e removê-la após o primeiro render — impede que a transition suave rode no carregamento da página (causaria flash visual)
- **D-13:** Implementação: `transition-colors duration-150` nas classes do Tailwind nos elementos relevantes, ou regra global em `app.css` com `@variant dark` + transition

### Comportamento no primeiro acesso / persistência
- **D-14:** Ordem de prioridade para leitura do tema:
  1. `localStorage.getItem('theme')` — vence sempre se existir
  2. `window.matchMedia('(prefers-color-scheme: dark)')` — fallback para primeira visita
  3. `'dark'` — fallback final (dark como default da marca)
- **D-15:** Ao clicar no toggle: inverter tema, salvar no localStorage (`'dark'` ou `'light'`)
- **D-16:** O Alpine.js data store (ou x-data na raiz) deve sincronizar com o estado atual da classe `.dark` no `<html>` — não gerenciar estado separado

### Claude's Discretion
- SVG exato para sol e lua (pode usar Heroicons ou desenho simples — manter consistência visual com os SVGs já existentes na nav)
- Se adicionar a transition via classe Tailwind individual em cada elemento ou via regra global em app.css
- Quais seções precisam de override explícito de cor (investigar home.blade.php para identificar todos os elementos com cores hardcoded)

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Layout e estrutura
- `resources/views/layouts/app.blade.php` — Onde o script inline do head deve ser inserido; `<html>` e `<body>` com classes de tema
- `resources/views/partials/nav.blade.php` — Onde o toggle button deve ser adicionado (desktop + mobile)
- `resources/views/pages/home.blade.php` — Todas as seções com cores hardcoded que precisam de `@variant dark`

### Estilos
- `resources/css/app.css` — Custom properties atuais (`--color-bg-primary: #030712`, `--color-bg-card: #111827`, `--color-accent: #3b82f6`); aqui entram as regras `@variant dark`

### JavaScript
- `resources/js/app.js` — Verificar se Alpine.js store global é necessário ou se `x-data` no `<html>` é suficiente

No external specs — decisions fully captured above.

</canonical_refs>

<code_context>
## Existing Code Insights

### Estado atual (dark-first sem classe)
- `<html>` sem classe de tema — adicionar classe `.dark` muda isso
- `<body class="bg-gray-950 text-white antialiased">` — classes hardcoded que precisam de override `dark:bg-gray-950` (e light mode sem prefixo = `bg-gray-50`)
- Nav: `bg-gray-950/90` — precisa de variante light
- App.css define `--color-bg-primary: #030712` e `--color-bg-card: #111827` como custom props — podem ser re-mapeadas para o tema claro

### Alpine.js já em uso
- Nav usa `x-data="{ open: false }"` — o toggle pode usar o mesmo padrão ou um store global via `Alpine.store('theme', ...)`
- `<body x-data>` já existe no layout — Alpine está disponível no root

### Padrão de SVG inline na nav
- Os ícones hamburger/fechar já são SVG inline na nav — o ícone de sol/lua deve seguir o mesmo padrão (mesmo tamanho `h-6 w-6`, mesmo stroke style)

</code_context>
