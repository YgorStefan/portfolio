# Games Improvement — Design Spec
**Data:** 2026-04-18
**Abordagem aprovada:** A (portfólio primeiro, depois jogo por jogo)

---

## Visão Geral

Melhorias em 4 frentes para os minijogos do portfólio:
1. Correção de bugs de gameplay
2. Novos backgrounds/paletas por jogo
3. Responsividade mobile
4. Melhorias visuais gerais

---

## 1. Portfólio — Mudanças Compartilhadas (`home.blade.php`)

### Abas (sem duplicação)
- Todos os 4 botões "Jogar" mudam de `target="_blank"` para `target="game-window"`
- Todos os jogos sempre reusam a mesma aba do navegador

### "Voltar para o Portfólio" (nos 4 jogos)
- Texto: `← Portfólio` → `← Voltar para o Portfólio`
- Comportamento via `onclick`:
  ```js
  if (window.opener && !window.opener.closed) {
    window.opener.focus();
    window.close();
  } else {
    location.href = '/';
  }
  ```
- Aplica em: `memory-vue`, `runner-vanilla`, `termo-react`, `typing-svelte`

---

## 2. Jogo da Memória Tech (`memory-vue`)

### Identidade
- **Título da aba:** `Jogo da Memória Tech`
- **Header:** `🃏 Jogo da Memória Tech`
- **Paleta:** roxo/violeta suave
  - `body bg`: `#0d0a1a`
  - `header bg`: `#1a1230`
  - `border/accent`: `#8b5cf6` (violet-500)
  - badges, botões, hover: tons de violet

### Bugs / Melhorias
- **Ícone JS:** substituir quadrado amarelo pelo SVG oficial do JavaScript (amarelo com "JS")
- **Ícone Node.js:** substituir quadrado verde pelo logo oficial do Node.js
- **Botão Reiniciar:** movido para inline com o contador de stats, estilo compacto com ícone de refresh (↺) e borda violet

### Layout stats (após mudança)
```
⏱ 00:32   🃏 4/8 pares   [↺ Reiniciar]
```

### Responsividade
- Grid de cards: 4 colunas → 2 colunas em mobile (≤ 480px)
- Header: padding reduzido em telas pequenas, back-link e title empilham se necessário

---

## 3. Wordle Tech (`termo-react`)

### Identidade
- **Título da aba:** `Wordle Tech`
- **Header:** `🟩 Wordle Tech`
- **Paleta:** verde suave
  - `body bg`: `#071a0d`
  - `header bg`: `#0f2a18`
  - `accent`: `#22c55e` (green-500)
  - letras corretas: `#22c55e`, presentes: `#eab308`, ausentes: `#374151`

### Bugs corrigidos
- **Palavras:** expandir lista para ~40 palavras tech de 5 letras em pt-BR
  - Exemplos: pilha, fila, vetor, cache, clone, linux, fetch, array, query, token, https, porta, dados, ciclo, frame, banco, chave, redes, nuvem, debug, merge, fluxo, build, teste, agile, troca, borda, saida, loops, senha, papel, campo, mutex, bloco, pacot, proto
- **Bug "não troca ao vencer":** `resetGame()` avança para próxima palavra da lista (índice + 1) em vez de chamar `getDailyWord()` que retorna sempre a mesma
- **Palavra revelada:** mostrar a palavra-alvo no overlay de fim de jogo em ambos os casos (vitória e derrota)

### Overlay de fim de jogo (novo)
- Sobreposição fullscreen com `backdrop-blur`
- **Vitória:**
  - Fundo verde escuro semitransparente
  - "🎉 Você acertou!" em destaque
  - Palavra revelada em letras grandes (cards verdes)
  - "Em X tentativas"
  - Botão "Próxima Palavra"
- **Derrota:**
  - Fundo vermelho escuro semitransparente
  - "😞 Fim de Jogo"
  - Palavra revelada em letras grandes
  - Botão "Tentar Novamente"

### Placar (novo estilo)
- Substituir `🏆 2V / 1D` por dois badges separados:
  - Badge verde: `✓ 5 vitórias`
  - Badge vermelho: `✗ 2 derrotas`
  - Badge laranja: `🔥 3 seguidas` (streak)

### Imagem do header
- Verificar qual imagem está incorreta e substituir pelo SVG de grid de quadrados coloridos (já usado no portfólio)

### Responsividade
- Teclado virtual: teclas reduzem tamanho em mobile (≤ 480px)
- Grid de letras: células menores em telas pequenas

---

## 4. Fuga do Dino (`runner-vanilla`)

### Identidade
- **Título da aba:** `Fuga do Dino`
- **Header:** `🦖 Fuga do Dino`
- **Paleta:** âmbar/laranja suave
  - `body bg`: `#1a1005`
  - `header bg`: `#2a1a08`
  - `chão/plataforma`: `#3d2510`
  - `accent`: `#f59e0b` (amber-500)
  - HUD, badges, borda canvas: tons âmbar

### Velocidade (bug corrigido)
- Velocidade inicial: `1.0x` (constante base corrigida no código)
- Incremento: `+0.5x` a cada 1500 pontos de score
- HUD exibe: `Vel: 1.0x` → `Vel: 1.5x` → etc.

### Dinossauro (player)
- Substitui quadrado azul por sprite desenhado no canvas:
  - Corpo verde escuro retangular
  - Cabeça com olho branco/preto
  - 2 pernas animadas em 2 frames (corrida)
  - Em pulo: pernas estendidas para baixo (frame especial)

### Insetos (obstáculos)
- Remover retângulo vermelho base
- 5 tipos desenhados no canvas com formas simples:
  1. **Besouro:** oval + antenas + 6 patas
  2. **Mosquito:** corpo fino + 2 asas triangulares
  3. **Barata:** oval achatado + 6 patas espalhadas
  4. **Grilo:** corpo longo + pernas traseiras longas
  5. **Aranha:** corpo redondo + 8 patas curvas
- Cada tipo tem 5 tamanhos (escala 0.6× a 1.4×)
- Todos os tamanhos calculados para serem puláveis pelo dino (hitbox calibrada)

### Texto
- "Game Over" → "Fim de Jogo"

### Último score
- Salvo em `localStorage` com chave `dino_last_score`
- Exibido no overlay de fim: `Score: 1840 | Último: 1200`

### Responsividade
- Canvas: largura = `min(window.innerWidth - 32, 800)`, altura proporcional (25% da largura, min 140px)

---

## 5. Defesa Espacial (`typing-svelte`)

### Identidade
- **Título da aba:** `Defesa Espacial`
- **Header:** `⌨️ Defesa Espacial`
- **Paleta:** ciano/espacial
  - `body bg`: `#01101a`
  - `header bg`: `#021828`
  - `arena bg`: `#011520`
  - `accent`: `#06b6d4` (cyan-500)
  - server/base: `#0a2030`
  - HUD, badges, input border: tons ciano

### Mobile — input (bug corrigido)
- Problema: `keydown` no `window` não dispara em mobile sem foco
- Solução: adicionar `<input type="text">` visível na barra do servidor em mobile (detectado por `window.innerWidth < 768` ou media query)
- Input sincroniza com o estado `typed` do store
- Em desktop: comportamento atual mantido (teclado físico, input oculto)

### Palavras randomizadas
- Embaralhar lista com Fisher-Yates no início de cada partida
- Usar índice circular para não repetir sequências

### 7 aliens diferentes
- 7 variantes com cores distintas desenhadas como componente Svelte:
  1. Ciano (`#06b6d4`) — formato clássico
  2. Verde (`#22c55e`) — antenas largas
  3. Roxo (`#a855f7`) — corpo oval
  4. Laranja (`#f97316`) — formato triangular invertido
  5. Rosa (`#ec4899`) — corpo pequeno + antenas longas
  6. Vermelho (`#ef4444`) — formato quadrado
  7. Amarelo (`#eab308`) — corpo achatado
- Cada spawn sorteia tipo aleatório

### Velocidade progressiva
- Timer separado: a cada 15 segundos, `FALL_SPEED += 0.05`
- Timer reseta ao reiniciar a partida

### Vidas
- Iniciar com 5 vidas (era 3)
- Reiniciar reseta para 5

### Texto
- "Game Over" → "Fim de Jogo"

### Responsividade
- `arenaHeight` calculado dinamicamente: `window.innerHeight - headerHeight - hudHeight - serverHeight`
- Aliens spawnam dentro de `window.innerWidth - 200` para não ficarem cortados
- Server bar sempre visível no fundo

---

## Ordem de implementação (Abordagem A)

1. `home.blade.php` — target="game-window" + rebuild CSS
2. `memory-vue` — paleta, ícones, botão, responsividade → build
3. `termo-react` — paleta, palavras, overlay, placar, responsividade → build
4. `runner-vanilla` — paleta, velocidade, dino, insetos, responsividade → build
5. `typing-svelte` — paleta, mobile input, aliens, velocidade, vidas → build
6. Copiar dists para `public/games/` e commitar tudo
