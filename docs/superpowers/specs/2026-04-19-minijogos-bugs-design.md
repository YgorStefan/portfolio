# Correção de Bugs e Melhorias dos Minijogos

**Data:** 2026-04-19
**Escopo:** 4 minijogos — memory-vue, runner-vanilla, termo-react, typing-svelte

---

## Problemas e Soluções

### 1. Abas duplicadas (todos os jogos)

**Causa raiz:** Os links "Jogar" em `home.blade.php` usam `rel="noopener noreferrer"`, o que força `window.opener = null` dentro de cada jogo. O botão "Voltar para o Portfólio" checa `window.opener` — como é null, cai no fallback `location.href = '/'`, navegando a aba do jogo para o portfólio em vez de fechá-la. Resultado: a aba original do portfólio permanece aberta e a aba do jogo vira uma segunda aba do portfólio.

**Solução:**
- Remover `rel="noopener noreferrer"` dos 4 links "Jogar" em `resources/views/pages/home.blade.php`. Os jogos são na mesma origem — não há risco de segurança.
- Simplificar o botão "Voltar" em todos os jogos para `window.close()`, com fallback `location.href = '/'` caso o browser bloqueie (aba aberta diretamente pelo usuário).

**Arquivos afetados:**
- `resources/views/pages/home.blade.php` (4 links)
- `games/memory-vue/src/App.vue`
- `games/termo-react/src/App.tsx`
- `games/typing-svelte/src/App.svelte`
- `games/runner-vanilla/index.html`

---

### 2. Wordle Tech — Visual quebrado (termo-react)

**Causa raiz:** O projeto usa Tailwind v4 com `@tailwindcss/vite`. No Tailwind v4, os utilitários só são gerados se o arquivo CSS contiver `@import "tailwindcss";`. O `index.css` atual só tem variáveis CSS customizadas — o CSS buildado tem apenas 382 bytes, sem nenhuma classe utilitária. Todas as classes como `w-14 h-14 flex border-2 text-xl font-bold` são ignoradas.

**Solução:**
- Adicionar `@import "tailwindcss";` no topo de `games/termo-react/src/index.css`.
- Rebuildar (`npm run build` dentro de `games/termo-react`).
- Copiar o dist para `public/games/termo-react/`.

**Arquivos afetados:**
- `games/termo-react/src/index.css`

---

### 3. Fuga do Dino — Velocidade varia por hardware (runner-vanilla)

**Causa raiz:** O `GameLoop._update()` é chamado a cada frame via `requestAnimationFrame` sem usar delta time. `this.score++` e o movimento dos obstáculos são incrementados 1× por frame. Em 144Hz o jogo roda 2.4× mais rápido que em 60Hz; em 240Hz, 4× mais rápido.

**Solução:**
- Passar o `timestamp` do rAF para `_loop(timestamp)` → `_update(delta)`.
- Calcular `delta = timestamp - this.lastTime` (em ms). Normalizar toda física por `delta / 16.667` (equivalente a 60fps).
- Score incrementar como `this.score += delta / 16.667` (inteiro arredondado).
- Velocidade dos obstáculos: `speed * (delta / 16.667)` pixels por frame.
- Guardar `this.lastTime = timestamp` a cada frame.

**Arquivos afetados:**
- `games/runner-vanilla/src/GameLoop.js`
- `games/runner-vanilla/src/Obstacle.js` (método `update` precisa receber delta)
- `games/runner-vanilla/src/Player.js` (método `update` precisa receber delta)

---

### 4. Defesa Espacial — Nave espacial (typing-svelte)

**Causa raiz:** Não é um bug — é uma melhoria visual solicitada. O alien está solto, sem uma nave.

**Solução:** Redesenhar `Enemy.svelte` como OVNI Aberto (opção C aprovada): alien com corpo visível sentado em cima de um disco plano, com antenas e luzes coloridas na borda inferior do disco. A variável `color` já existente (7 tipos por `enemy.type`) aplica no corpo do alien, no disco e nas luzes — mantendo os 7 aliens visualmente distintos.

**Layout do SVG:**
- Disco plano (elipse) na parte inferior com borda colorida
- Alien sentado no centro acima do disco
- 2 antenas com bolinhas nas pontas
- 5 luzes na borda inferior do disco
- Badge com o comando abaixo (já existente)

**Arquivos afetados:**
- `games/typing-svelte/src/components/Enemy.svelte`

---

### 5. Defesa Espacial — Comandos repetitivos (typing-svelte)

**Causa raiz:** Os 18 comandos em `commands.js` são todos `git *` ou `npm *`. O usuário percebe a repetição rapidamente.

**Solução:** Expandir para ~33 comandos incluindo outras ferramentas de desenvolvimento:

Novos comandos a adicionar:
- `docker run`, `docker build`, `docker pull`, `docker ps`
- `python manage.py`, `pip install`, `python -m venv`
- `cargo build`, `cargo run`, `cargo test`
- `go run main.go`, `go build`, `go test`
- `yarn dev`, `yarn build`, `yarn add`

**Arquivos afetados:**
- `games/typing-svelte/src/data/commands.js`

---

### 6. Defesa Espacial — Velocidade progressiva imperceptível (typing-svelte)

**Causa raiz:** O timer aumenta `fallSpeed` em `+0.05` a cada 15s. Com velocidade inicial de `0.4`, após 2 minutos a velocidade é apenas `0.9` (2.25× inicial). Aumento muito gradual para ser percebido.

**Solução:**
- Aumentar incremento de `+0.05` para `+0.1` por intervalo.
- Reduzir intervalo de 15s para 10s.
- Adicionar cap de `fallSpeed` em `3.0` para não ficar injogável.
- Mostrar indicador visual de velocidade no HUD (ex: `⚡ 1.5×`).

**Arquivos afetados:**
- `games/typing-svelte/src/App.svelte`

---

## Build e Deploy

Após as correções, rebuildar os 3 jogos afetados e rodar o script de deploy:
- `games/termo-react` → `npm run build`
- `games/typing-svelte` → `npm run build`
- `games/runner-vanilla` → `npm run build`
- Rodar `node games/deploy.js` para copiar todos os dists para `public/games/`

O `memory-vue` não é afetado por nenhuma das correções acima exceto o link "Jogar" no home.blade.php.

---

## Testes

- **Abas:** Abrir jogo → clicar "Voltar" → deve restar apenas 1 aba. Abrir jogo diretamente pela URL → clicar "Voltar" → deve navegar para `/`.
- **Wordle Tech:** Verificar que grid 6×5 renderiza com células quadradas, teclado visível, cores de feedback funcionando.
- **Fuga do Dino:** Testar em 60Hz e 144Hz (ou simular com `setTimeout` throttle) — score e velocidade devem ser iguais após o mesmo tempo de jogo.
- **Defesa Espacial:** Verificar 7 tipos de OVNI com cores distintas; comandos de diferentes ferramentas aparecendo; velocidade visivelmente maior após ~30s de jogo.
