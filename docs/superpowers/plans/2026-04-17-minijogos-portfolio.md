# Minijogos do Portfólio — Plano de Implementação

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Construir 4 minijogos standalone com stacks diferentes, servi-los via `public/games/` no Laravel e adicionar seção `#minijogos` no portfólio.

**Architecture:** Monorepo leve em `games/` com um script `build:all` que constrói cada jogo Vite e copia o `dist/` para `public/games/<nome>/`. Cada jogo é completamente independente, compartilha apenas a convenção de header.

**Tech Stack:** Vue 3 + Vite | React + TypeScript + Tailwind CSS v4 | Vanilla JS + Canvas | Svelte + Vite | Laravel Blade

---

## Mapa de Arquivos

```
games/
├── package.json                        ← CRIAR: build:all script
├── deploy.js                           ← CRIAR: copia dist/ para public/games/
│
├── memory-vue/                         ← CRIAR via scaffold
│   ├── vite.config.js                  ← CRIAR: base /games/memory-vue/
│   ├── index.html                      ← MODIFICAR: título correto
│   └── src/
│       ├── App.vue                     ← CRIAR: orquestrador de estado
│       ├── style.css                   ← CRIAR: reset + variáveis globais
│       ├── data/cards.js               ← CRIAR: dados e shuffle
│       └── components/
│           ├── Card.vue                ← CRIAR: flip animation
│           └── Board.vue               ← CRIAR: grid 4×4
│
├── termo-react/                        ← CRIAR via scaffold
│   ├── vite.config.ts                  ← CRIAR: base + tailwind plugin
│   ├── index.html                      ← MODIFICAR: título
│   └── src/
│       ├── App.tsx                     ← CRIAR: estado principal + LocalStorage
│       ├── index.css                   ← CRIAR: @import tailwindcss
│       ├── types.ts                    ← CRIAR: LetterState, GuessRow, Stats
│       ├── utils/
│       │   ├── wordList.ts             ← CRIAR: banco de palavras
│       │   └── gameLogic.ts            ← CRIAR: validateGuess, getDailyWord
│       └── components/
│           ├── Grid.tsx                ← CRIAR: matriz 6×5
│           └── Keyboard.tsx            ← CRIAR: teclado virtual
│
├── runner-vanilla/                     ← CRIAR via scaffold
│   ├── vite.config.js                  ← CRIAR: base /games/runner-vanilla/
│   ├── index.html                      ← CRIAR: canvas + estrutura
│   └── src/
│       ├── main.js                     ← CRIAR: inicializa canvas + eventos
│       ├── style.css                   ← CRIAR: reset + estilos da tela
│       ├── Player.js                   ← CRIAR: classe com física de pulo
│       ├── Obstacle.js                 ← CRIAR: classe com velocidade
│       └── GameLoop.js                 ← CRIAR: rAF + colisão AABB + score
│
└── typing-svelte/                      ← CRIAR via scaffold
    ├── vite.config.js                  ← CRIAR: base /games/typing-svelte/
    ├── index.html                      ← MODIFICAR: título
    └── src/
        ├── App.svelte                  ← CRIAR: loop + vidas + score + input
        ├── app.css                     ← CRIAR: estilos globais
        ├── data/commands.js            ← CRIAR: lista de comandos
        ├── stores/game.js              ← CRIAR: estado reativo Svelte
        └── components/
            └── Enemy.svelte            ← CRIAR: inimigo + animação CSS

public/games/                           ← GERADO pelo deploy.js (não commitar conteúdo)

resources/views/pages/home.blade.php    ← MODIFICAR: adicionar seção #minijogos
```

---

## Tarefa 1: Estrutura do Monorepo (`games/`)

**Arquivos:**
- Criar: `games/package.json`
- Criar: `games/deploy.js`

- [ ] **Passo 1: Criar diretório `games/` e `package.json`**

```bash
mkdir -p games
```

Conteúdo de `games/package.json`:
```json
{
  "name": "portfolio-games",
  "private": true,
  "scripts": {
    "build:all": "npm run build --prefix memory-vue && npm run build --prefix termo-react && npm run build --prefix runner-vanilla && npm run build --prefix typing-svelte && node deploy.js"
  }
}
```

- [ ] **Passo 2: Criar `games/deploy.js`**

```js
const path = require('path')
const fs = require('fs')

const ROOT = path.resolve(__dirname, '..')
const GAMES = ['memory-vue', 'termo-react', 'runner-vanilla', 'typing-svelte']

GAMES.forEach(game => {
  const src = path.join(__dirname, game, 'dist')
  const dest = path.join(ROOT, 'public', 'games', game)

  if (!fs.existsSync(src)) {
    console.error(`✗ dist não encontrado para ${game} — rode npm run build antes`)
    process.exit(1)
  }

  if (fs.existsSync(dest)) fs.rmSync(dest, { recursive: true })
  fs.cpSync(src, dest, { recursive: true })
  console.log(`✓ ${game} → public/games/${game}`)
})
```

- [ ] **Passo 3: Criar `public/games/` para servir os builds**

```bash
mkdir -p public/games
```

- [ ] **Passo 4: Commit**

```bash
git add games/package.json games/deploy.js public/games/.gitkeep
git commit -m "estrutura base do monorepo de jogos"
```

---

## Tarefa 2: Scaffold do memory-vue

**Arquivos:**
- Criar: `games/memory-vue/` via Vite
- Modificar: `games/memory-vue/vite.config.js`
- Modificar: `games/memory-vue/index.html`

- [ ] **Passo 1: Scaffold Vue 3**

```bash
cd games
npm create vite@latest memory-vue -- --template vue
cd memory-vue
npm install
```

- [ ] **Passo 2: Limpar arquivos desnecessários do scaffold**

```bash
rm -f src/components/HelloWorld.vue src/assets/vue.svg
```

- [ ] **Passo 3: Atualizar `games/memory-vue/vite.config.js`**

```js
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  base: '/games/memory-vue/',
})
```

- [ ] **Passo 4: Atualizar `games/memory-vue/index.html`**

```html
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tech Match — Jogo da Memória</title>
  </head>
  <body>
    <div id="app"></div>
    <script type="module" src="/src/main.js"></script>
  </body>
</html>
```

---

## Tarefa 3: memory-vue — Dados e Card.vue

**Arquivos:**
- Criar: `games/memory-vue/src/data/cards.js`
- Criar: `games/memory-vue/src/components/Card.vue`

- [ ] **Passo 1: Criar `src/data/cards.js`**

```js
// Defino os 8 pares de tecnologias que aparecerão no jogo
export const TECHS = [
  { id: 'js',     label: 'JavaScript', emoji: '🟨' },
  { id: 'react',  label: 'React',      emoji: '⚛️' },
  { id: 'python', label: 'Python',     emoji: '🐍' },
  { id: 'vue',    label: 'Vue',        emoji: '💚' },
  { id: 'css',    label: 'CSS',        emoji: '🎨' },
  { id: 'docker', label: 'Docker',     emoji: '🐳' },
  { id: 'git',    label: 'Git',        emoji: '🔀' },
  { id: 'node',   label: 'Node.js',    emoji: '🟩' },
]

export function createDeck() {
  // Crio dois exemplares de cada tech (formando pares) e embaralho
  return [...TECHS, ...TECHS]
    .map((tech, i) => ({ uid: i, ...tech, isFlipped: false, isMatched: false }))
    .sort(() => Math.random() - 0.5)
}
```

- [ ] **Passo 2: Criar `src/components/Card.vue`**

```vue
<script setup>
const props = defineProps({ card: Object, disabled: Boolean })
const emit = defineEmits(['flip'])

function handleClick() {
  if (!props.disabled && !props.card.isFlipped && !props.card.isMatched) {
    emit('flip', props.card.uid)
  }
}
</script>

<template>
  <div
    class="card"
    :class="{ flipped: card.isFlipped || card.isMatched, matched: card.isMatched }"
    @click="handleClick"
  >
    <div class="card-inner">
      <div class="card-front">❓</div>
      <div class="card-back">
        <span class="emoji">{{ card.emoji }}</span>
        <span class="label">{{ card.label }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  perspective: 1000px;
  cursor: pointer;
  aspect-ratio: 1;
}
.card-inner {
  width: 100%;
  height: 100%;
  position: relative;
  transform-style: preserve-3d;
  transition: transform 0.5s ease;
}
/* Quando a carta está virada, rotaciono o inner 180° em Y para revelar o verso */
.card.flipped .card-inner {
  transform: rotateY(180deg);
}
.card-front,
.card-back {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  backface-visibility: hidden;
  border-radius: 12px;
  font-size: 2rem;
  border: 2px solid #334155;
  background: #1e293b;
  user-select: none;
}
.card-back {
  transform: rotateY(180deg);
  background: #0f172a;
  gap: 6px;
}
.card.matched .card-front,
.card.matched .card-back {
  border-color: #22c55e;
  background: #052e16;
}
.label {
  font-size: 0.65rem;
  color: #94a3b8;
}
</style>
```

---

## Tarefa 4: memory-vue — Board.vue e App.vue

**Arquivos:**
- Criar: `games/memory-vue/src/components/Board.vue`
- Criar: `games/memory-vue/src/App.vue`
- Criar: `games/memory-vue/src/style.css`

- [ ] **Passo 1: Criar `src/components/Board.vue`**

```vue
<script setup>
import Card from './Card.vue'
defineProps({ cards: Array, disabled: Boolean })
defineEmits(['flip'])
</script>

<template>
  <div class="board">
    <Card
      v-for="card in cards"
      :key="card.uid"
      :card="card"
      :disabled="disabled"
      @flip="$emit('flip', $event)"
    />
  </div>
</template>

<style scoped>
.board {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  max-width: 480px;
  width: 100%;
  margin: 0 auto;
}
@media (max-width: 480px) {
  .board { gap: 8px; }
}
</style>
```

- [ ] **Passo 2: Criar `src/style.css`**

```css
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
  background: #0f172a;
  color: #f1f5f9;
  font-family: system-ui, sans-serif;
  min-height: 100vh;
}

.app { min-height: 100vh; display: flex; flex-direction: column; }

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 2rem;
  background: #1e293b;
  border-bottom: 1px solid #334155;
}
.header-left { flex: 1; }
.header-right { flex: 1; }
.title-area { display: flex; flex-direction: column; align-items: center; gap: 8px; }
.back-link { color: #94a3b8; text-decoration: none; font-size: 0.9rem; }
.back-link:hover { color: #38bdf8; }
h1 { font-size: 1.5rem; font-weight: 700; }

.badges { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
.badge {
  background: rgba(56,189,248,0.1);
  border: 1px solid rgba(56,189,248,0.3);
  color: #38bdf8;
  padding: 2px 10px;
  border-radius: 999px;
  font-size: 0.75rem;
  font-weight: 600;
}

main {
  flex: 1;
  padding: 2rem 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
}

.stats { display: flex; gap: 2rem; font-size: 1rem; color: #94a3b8; flex-wrap: wrap; justify-content: center; }

.win-banner {
  background: #052e16;
  border: 1px solid #22c55e;
  color: #22c55e;
  padding: 1rem 2rem;
  border-radius: 12px;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  align-items: center;
  font-weight: 600;
}

.btn {
  background: #38bdf8;
  color: #0f172a;
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 8px;
  font-weight: 700;
  cursor: pointer;
  font-size: 0.9rem;
}
.btn:hover { background: #7dd3fc; }
```

- [ ] **Passo 3: Criar `src/App.vue`**

```vue
<script setup>
import { ref, computed, onUnmounted } from 'vue'
import Board from './components/Board.vue'
import { createDeck } from './data/cards.js'

const cards = ref(createDeck())
const flippedUids = ref([])
const attempts = ref(0)
const seconds = ref(0)
const gameStarted = ref(false)

let timerInterval = null

function startTimer() {
  if (!gameStarted.value) {
    gameStarted.value = true
    timerInterval = setInterval(() => { seconds.value++ }, 1000)
  }
}

function stopTimer() {
  clearInterval(timerInterval)
  timerInterval = null
}

onUnmounted(stopTimer)

const matchedCount = computed(() => cards.value.filter(c => c.isMatched).length)
const allMatched = computed(() => matchedCount.value === cards.value.length)
// Bloqueio novas viradas enquanto o par está sendo avaliado (2 cartas visíveis)
const isBlocked = computed(() => flippedUids.value.length === 2)

function flipCard(uid) {
  startTimer()
  flippedUids.value = [...flippedUids.value, uid]
  const card = cards.value.find(c => c.uid === uid)
  card.isFlipped = true

  if (flippedUids.value.length === 2) {
    attempts.value++
    const [a, b] = flippedUids.value.map(id => cards.value.find(c => c.uid === id))
    if (a.id === b.id) {
      a.isMatched = true
      b.isMatched = true
      flippedUids.value = []
      if (allMatched.value) stopTimer()
    } else {
      setTimeout(() => {
        a.isFlipped = false
        b.isFlipped = false
        flippedUids.value = []
      }, 1000)
    }
  }
}

function resetGame() {
  stopTimer()
  cards.value = createDeck()
  flippedUids.value = []
  attempts.value = 0
  seconds.value = 0
  gameStarted.value = false
}

const timeFormatted = computed(() => {
  const m = Math.floor(seconds.value / 60).toString().padStart(2, '0')
  const s = (seconds.value % 60).toString().padStart(2, '0')
  return `${m}:${s}`
})
</script>

<template>
  <div class="app">
    <header class="header">
      <div class="header-left">
        <a href="/" class="back-link">← Portfólio</a>
      </div>
      <div class="title-area">
        <h1>🃏 Tech Match</h1>
        <div class="badges">
          <span class="badge">Vue 3</span>
          <span class="badge">Vite</span>
          <span class="badge">CSS Puro</span>
        </div>
      </div>
      <div class="header-right"></div>
    </header>

    <main>
      <div class="stats">
        <span>⏱ {{ timeFormatted }}</span>
        <span>🎯 {{ attempts }} tentativas</span>
        <span>✅ {{ matchedCount / 2 }}/8 pares</span>
      </div>

      <div v-if="allMatched" class="win-banner">
        🎉 Você venceu em {{ attempts }} tentativas e {{ timeFormatted }}!
        <button class="btn" @click="resetGame">Jogar novamente</button>
      </div>

      <Board :cards="cards" :disabled="isBlocked" @flip="flipCard" />

      <button class="btn" @click="resetGame">🔄 Reiniciar</button>
    </main>
  </div>
</template>
```

- [ ] **Passo 4: Atualizar `src/main.js`**

```js
import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

createApp(App).mount('#app')
```

---

## Tarefa 5: memory-vue — Build e Validação

- [ ] **Passo 1: Rodar build**

```bash
cd games/memory-vue
npm run build
```

Esperado: pasta `games/memory-vue/dist/` criada sem erros.

- [ ] **Passo 2: Verificar estrutura do dist**

```bash
ls games/memory-vue/dist/
```

Esperado: `index.html` + pasta `assets/` com JS e CSS.

- [ ] **Passo 3: Testar localmente (opcional)**

```bash
cd games/memory-vue
npm run dev
```

Abrir `http://localhost:5173/games/memory-vue/` e verificar: cartas aparecem, flip funciona, par encontrado fica verde, tentativas e timer incrementam, botão reiniciar funciona.

- [ ] **Passo 4: Commit**

```bash
git add games/memory-vue/
git commit -m "feat: jogo da memória Tech Match (Vue 3)"
```

---

## Tarefa 6: Scaffold do termo-react + Tailwind CSS v4

**Arquivos:**
- Criar: `games/termo-react/` via Vite
- Criar: `games/termo-react/vite.config.ts`

- [ ] **Passo 1: Scaffold React + TypeScript**

```bash
cd games
npm create vite@latest termo-react -- --template react-ts
cd termo-react
npm install
```

- [ ] **Passo 2: Instalar Tailwind CSS v4**

```bash
npm install tailwindcss @tailwindcss/vite
```

- [ ] **Passo 3: Limpar scaffold**

```bash
rm -f src/App.css src/assets/react.svg
```

- [ ] **Passo 4: Criar `games/termo-react/vite.config.ts`**

```ts
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  base: '/games/termo-react/',
  plugins: [react(), tailwindcss()],
})
```

- [ ] **Passo 5: Atualizar `src/index.css`**

```css
@import "tailwindcss";
```

- [ ] **Passo 6: Atualizar `index.html`**

```html
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Techdle — Adivinhe a palavra tech</title>
  </head>
  <body>
    <div id="root"></div>
    <script type="module" src="/src/main.tsx"></script>
  </body>
</html>
```

---

## Tarefa 7: termo-react — Types, WordList e GameLogic

**Arquivos:**
- Criar: `games/termo-react/src/types.ts`
- Criar: `games/termo-react/src/utils/wordList.ts`
- Criar: `games/termo-react/src/utils/gameLogic.ts`

- [ ] **Passo 1: Criar `src/types.ts`**

```ts
export type LetterState = 'correct' | 'present' | 'absent' | 'empty'

export interface GuessRow {
  letters: string[]
  states: LetterState[]
  submitted: boolean
}

export interface Stats {
  wins: number
  losses: number
  streak: number
  lastPlayed: string
  lastResult: 'win' | 'loss' | null
}
```

- [ ] **Passo 2: Criar `src/utils/wordList.ts`**

```ts
// Banco de palavras tech de 5 letras em português
export const WORDS: string[] = [
  'PLACA', 'MOUSE', 'LINUX', 'DADOS', 'VETOR',
  'PIXEL', 'CACHE', 'DISCO', 'PILHA', 'PORTA',
  'LOOPS', 'MACRO', 'FETCH', 'CLONE', 'MERGE',
  'STACK', 'PRINT', 'QUERY', 'TOKEN', 'INPUT',
  'DEBUG', 'SHELL', 'ARRAY', 'CLASS', 'PROXY',
]
```

- [ ] **Passo 3: Criar `src/utils/gameLogic.ts`**

```ts
import { WORDS } from './wordList'
import type { LetterState } from '../types'

// Seleciono a palavra do dia usando o índice do dia do ano para que todos joguem a mesma palavra
export function getDailyWord(): string {
  const start = new Date(new Date().getFullYear(), 0, 0)
  const diff = +new Date() - +start
  const dayOfYear = Math.floor(diff / (1000 * 60 * 60 * 24))
  return WORDS[dayOfYear % WORDS.length]
}

// Valido o chute com dois passos: primeiro identifico posições corretas,
// depois identifico letras presentes em posição errada (evitando contar a mesma letra duas vezes)
export function validateGuess(guess: string, target: string): LetterState[] {
  const result: LetterState[] = Array(5).fill('absent')
  const targetArr = target.split('')
  const guessArr = guess.split('')

  // Passo 1: posições exatas
  guessArr.forEach((letter, i) => {
    if (letter === targetArr[i]) {
      result[i] = 'correct'
      targetArr[i] = ''
    }
  })

  // Passo 2: letras presentes em posição errada
  guessArr.forEach((letter, i) => {
    if (result[i] !== 'correct') {
      const idx = targetArr.indexOf(letter)
      if (idx !== -1) {
        result[i] = 'present'
        targetArr[idx] = ''
      }
    }
  })

  return result
}

const STORAGE_KEY = 'techdle_stats'

export function loadStats() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY)
    return raw ? JSON.parse(raw) : { wins: 0, losses: 0, streak: 0, lastPlayed: '', lastResult: null }
  } catch {
    return { wins: 0, losses: 0, streak: 0, lastPlayed: '', lastResult: null }
  }
}

export function saveStats(stats: object) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(stats))
}
```

---

## Tarefa 8: termo-react — Grid.tsx e Keyboard.tsx

**Arquivos:**
- Criar: `games/termo-react/src/components/Grid.tsx`
- Criar: `games/termo-react/src/components/Keyboard.tsx`

- [ ] **Passo 1: Criar `src/components/Grid.tsx`**

```tsx
import type { GuessRow, LetterState } from '../types'

const STATE_CLASSES: Record<LetterState, string> = {
  correct: 'bg-green-600 border-green-600 text-white',
  present: 'bg-yellow-500 border-yellow-500 text-white',
  absent:  'bg-gray-600 border-gray-600 text-white',
  empty:   'bg-transparent border-gray-600 text-white',
}

interface Props {
  rows: GuessRow[]
  currentRow: number
  currentLetters: string[]
}

export default function Grid({ rows, currentRow, currentLetters }: Props) {
  return (
    <div className="grid gap-1.5 mb-6">
      {rows.map((row, ri) => (
        <div key={ri} className="flex gap-1.5">
          {Array(5).fill(null).map((_, ci) => {
            const isCurrentRow = ri === currentRow
            const letter = isCurrentRow ? (currentLetters[ci] ?? '') : (row.letters[ci] ?? '')
            const state: LetterState = row.submitted ? row.states[ci] : 'empty'
            return (
              <div
                key={ci}
                className={`w-14 h-14 flex items-center justify-center border-2 text-xl font-bold uppercase transition-all duration-300 ${STATE_CLASSES[state]}`}
              >
                {letter}
              </div>
            )
          })}
        </div>
      ))}
    </div>
  )
}
```

- [ ] **Passo 2: Criar `src/components/Keyboard.tsx`**

```tsx
import type { LetterState } from '../types'

const ROWS = [
  ['Q','W','E','R','T','Y','U','I','O','P'],
  ['A','S','D','F','G','H','J','K','L'],
  ['ENTER','Z','X','C','V','B','N','M','⌫'],
]

const STATE_CLASSES: Record<LetterState, string> = {
  correct: 'bg-green-600 text-white',
  present: 'bg-yellow-500 text-white',
  absent:  'bg-gray-700 text-gray-400',
  empty:   'bg-gray-500 text-white',
}

interface Props {
  letterStates: Record<string, LetterState>
  onKey: (key: string) => void
}

export default function Keyboard({ letterStates, onKey }: Props) {
  return (
    <div className="flex flex-col items-center gap-1.5">
      {ROWS.map((row, i) => (
        <div key={i} className="flex gap-1">
          {row.map(key => {
            const state = letterStates[key] ?? 'empty'
            const isWide = key === 'ENTER' || key === '⌫'
            return (
              <button
                key={key}
                onClick={() => onKey(key)}
                className={`${isWide ? 'px-3' : 'w-9'} h-14 rounded font-bold text-sm transition-colors duration-200 ${STATE_CLASSES[state]}`}
              >
                {key}
              </button>
            )
          })}
        </div>
      ))}
    </div>
  )
}
```

---

## Tarefa 9: termo-react — App.tsx

**Arquivos:**
- Criar: `games/termo-react/src/App.tsx`

- [ ] **Passo 1: Criar `src/App.tsx`**

```tsx
import { useState, useEffect, useCallback } from 'react'
import Grid from './components/Grid'
import Keyboard from './components/Keyboard'
import type { GuessRow, LetterState, Stats } from './types'
import { getDailyWord, validateGuess, loadStats, saveStats } from './utils/gameLogic'

const MAX_ATTEMPTS = 6
const WORD_LENGTH = 5

function createEmptyRows(): GuessRow[] {
  return Array(MAX_ATTEMPTS).fill(null).map(() => ({
    letters: [],
    states: [],
    submitted: false,
  }))
}

export default function App() {
  const [target] = useState(getDailyWord)
  const [rows, setRows] = useState<GuessRow[]>(createEmptyRows)
  const [currentRow, setCurrentRow] = useState(0)
  const [currentLetters, setCurrentLetters] = useState<string[]>([])
  const [letterStates, setLetterStates] = useState<Record<string, LetterState>>({})
  const [status, setStatus] = useState<'playing' | 'won' | 'lost'>('playing')
  const [stats, setStats] = useState<Stats>(loadStats)
  const [message, setMessage] = useState('')

  function showMessage(msg: string) {
    setMessage(msg)
    setTimeout(() => setMessage(''), 2500)
  }

  // Atualizo o mapa de estados das letras do teclado com base nos chutes já feitos
  function updateLetterStates(guess: string, states: LetterState[]) {
    setLetterStates(prev => {
      const next = { ...prev }
      const priority: LetterState[] = ['correct', 'present', 'absent']
      guess.split('').forEach((letter, i) => {
        const cur = next[letter]
        const newState = states[i]
        if (!cur || priority.indexOf(newState) < priority.indexOf(cur)) {
          next[letter] = newState
        }
      })
      return next
    })
  }

  const handleKey = useCallback((key: string) => {
    if (status !== 'playing') return

    if (key === '⌫' || key === 'Backspace') {
      setCurrentLetters(prev => prev.slice(0, -1))
      return
    }

    if (key === 'ENTER' || key === 'Enter') {
      if (currentLetters.length < WORD_LENGTH) {
        showMessage('Palavra incompleta')
        return
      }
      const guess = currentLetters.join('')
      const states = validateGuess(guess, target)

      setRows(prev => {
        const next = [...prev]
        next[currentRow] = { letters: currentLetters, states, submitted: true }
        return next
      })
      updateLetterStates(guess, states)
      setCurrentLetters([])

      if (guess === target) {
        const newStats: Stats = { ...stats, wins: stats.wins + 1, streak: stats.streak + 1, lastPlayed: new Date().toDateString(), lastResult: 'win' }
        setStats(newStats)
        saveStats(newStats)
        setStatus('won')
        showMessage('🎉 Você acertou!')
      } else if (currentRow + 1 >= MAX_ATTEMPTS) {
        const newStats: Stats = { ...stats, losses: stats.losses + 1, streak: 0, lastPlayed: new Date().toDateString(), lastResult: 'loss' }
        setStats(newStats)
        saveStats(newStats)
        setStatus('lost')
        showMessage(`A palavra era ${target}`)
      } else {
        setCurrentRow(r => r + 1)
      }
      return
    }

    if (/^[A-Za-z]$/.test(key) && currentLetters.length < WORD_LENGTH) {
      setCurrentLetters(prev => [...prev, key.toUpperCase()])
    }
  }, [status, currentLetters, currentRow, target, stats])

  useEffect(() => {
    const handler = (e: KeyboardEvent) => handleKey(e.key)
    window.addEventListener('keydown', handler)
    return () => window.removeEventListener('keydown', handler)
  }, [handleKey])

  return (
    <div className="min-h-screen bg-gray-900 text-white flex flex-col">
      {/* Header */}
      <header className="flex items-center justify-between px-6 py-4 bg-gray-800 border-b border-gray-700">
        <a href="/" className="text-gray-400 hover:text-sky-400 text-sm">← Portfólio</a>
        <div className="flex flex-col items-center gap-2">
          <h1 className="text-xl font-bold">🟩 Techdle</h1>
          <div className="flex gap-2">
            {['React', 'TypeScript', 'Tailwind'].map(b => (
              <span key={b} className="text-xs font-semibold px-2 py-0.5 rounded-full border border-sky-400/40 bg-sky-400/10 text-sky-400">{b}</span>
            ))}
          </div>
        </div>
        <div className="text-sm text-gray-400">🏆 {stats.wins}V / {stats.losses}D</div>
      </header>

      {/* Main */}
      <main className="flex flex-col items-center justify-center flex-1 px-4 py-6">
        {message && (
          <div className="mb-4 px-4 py-2 rounded bg-gray-700 text-white text-sm font-semibold">{message}</div>
        )}
        <Grid rows={rows} currentRow={currentRow} currentLetters={currentLetters} />
        <Keyboard letterStates={letterStates} onKey={handleKey} />
      </main>
    </div>
  )
}
```

- [ ] **Passo 2: Atualizar `src/main.tsx`**

```tsx
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.tsx'

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
```

---

## Tarefa 10: termo-react — Build e Validação

- [ ] **Passo 1: Rodar build**

```bash
cd games/termo-react
npm run build
```

Esperado: `games/termo-react/dist/` criado sem erros de TypeScript.

- [ ] **Passo 2: Testar localmente**

```bash
npm run dev
```

Verificar: grid 6×5 aparece, digitação via teclado físico funciona, cores corretas (verde/amarelo/cinza), teclado virtual responde ao clique, stats persistem no LocalStorage após fechar e reabrir.

- [ ] **Passo 3: Commit**

```bash
git add games/termo-react/
git commit -m "feat: clone do Wordle Techdle (React + TypeScript + Tailwind)"
```

---

## Tarefa 11: Scaffold do runner-vanilla

**Arquivos:**
- Criar: `games/runner-vanilla/` via Vite
- Criar: `games/runner-vanilla/vite.config.js`
- Criar: `games/runner-vanilla/index.html`

- [ ] **Passo 1: Scaffold Vanilla**

```bash
cd games
npm create vite@latest runner-vanilla -- --template vanilla
cd runner-vanilla
npm install
```

- [ ] **Passo 2: Criar `vite.config.js`**

```js
import { defineConfig } from 'vite'

export default defineConfig({
  base: '/games/runner-vanilla/',
})
```

- [ ] **Passo 3: Criar `index.html`**

```html
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dino Bug Run</title>
  </head>
  <body>
    <header class="game-header">
      <a href="/" class="back-link">← Portfólio</a>
      <div class="title-area">
        <h1>🦖 Dino Bug Run</h1>
        <div class="badges">
          <span class="badge">JavaScript</span>
          <span class="badge">Canvas</span>
          <span class="badge">ES6+</span>
        </div>
      </div>
      <div></div>
    </header>
    <main>
      <p class="hint">Pressione <kbd>Espaço</kbd> ou <kbd>↑</kbd> para pular · Toque na tela no mobile</p>
      <canvas id="game-canvas"></canvas>
    </main>
    <script type="module" src="/src/main.js"></script>
  </body>
</html>
```

---

## Tarefa 12: runner-vanilla — Player.js e Obstacle.js

**Arquivos:**
- Criar: `games/runner-vanilla/src/Player.js`
- Criar: `games/runner-vanilla/src/Obstacle.js`

- [ ] **Passo 1: Criar `src/Player.js`**

```js
export class Player {
  constructor(canvas) {
    this.canvas = canvas
    this.width = 40
    this.height = 50
    this.x = 80
    this.groundY = canvas.height - 20 - this.height
    this.y = this.groundY
    this.vy = 0
    this.gravity = 0.7
    this.jumpForce = -15
    this.isOnGround = true
  }

  jump() {
    if (this.isOnGround) {
      this.vy = this.jumpForce
      this.isOnGround = false
    }
  }

  update() {
    this.vy += this.gravity
    this.y += this.vy
    if (this.y >= this.groundY) {
      this.y = this.groundY
      this.vy = 0
      this.isOnGround = true
    }
  }

  draw(ctx) {
    // Corpo
    ctx.fillStyle = '#38bdf8'
    ctx.fillRect(this.x, this.y, this.width, this.height)
    // Olhos
    ctx.fillStyle = '#0f172a'
    ctx.fillRect(this.x + 7,  this.y + 10, 9, 9)
    ctx.fillRect(this.x + 24, this.y + 10, 9, 9)
    // Boca
    ctx.fillRect(this.x + 10, this.y + 30, 20, 4)
  }
}
```

- [ ] **Passo 2: Criar `src/Obstacle.js`**

```js
export class Obstacle {
  constructor(canvas, speed) {
    this.canvas = canvas
    this.width = 20 + Math.random() * 15
    this.height = 35 + Math.random() * 35
    this.x = canvas.width + 10
    this.y = canvas.height - 20 - this.height
    this.speed = speed
  }

  update() {
    this.x -= this.speed
  }

  isOffScreen() {
    return this.x + this.width < 0
  }

  draw(ctx) {
    ctx.fillStyle = '#ef4444'
    ctx.fillRect(this.x, this.y, this.width, this.height)
    ctx.fillStyle = '#fca5a5'
    ctx.fillRect(this.x + 4, this.y + 4, this.width - 8, 8)
    // Label de bug
    ctx.fillStyle = '#fff'
    ctx.font = '16px sans-serif'
    ctx.fillText('🐛', this.x - 2, this.y - 4)
  }
}
```

---

## Tarefa 13: runner-vanilla — GameLoop.js e main.js

**Arquivos:**
- Criar: `games/runner-vanilla/src/GameLoop.js`
- Criar: `games/runner-vanilla/src/main.js`
- Criar: `games/runner-vanilla/src/style.css`

- [ ] **Passo 1: Criar `src/GameLoop.js`**

```js
import { Player } from './Player.js'
import { Obstacle } from './Obstacle.js'

export class GameLoop {
  constructor(canvas) {
    this.canvas = canvas
    this.ctx = canvas.getContext('2d')
    this.player = new Player(canvas)
    this.obstacles = []
    this.score = 0
    this.speed = 5
    this.frameCount = 0
    this.running = false
    this.isGameOver = false
    this.animId = null
    this.spawnInterval = 90
  }

  // A velocidade cresce 0.5 a cada 500 pontos para o jogo ficar progressivamente difícil
  _updateSpeed() {
    this.speed = 5 + Math.floor(this.score / 500) * 0.5
  }

  // Detecção de colisão AABB: verifico se os quatro lados dos retângulos se sobrepõem.
  // Se qualquer lado não se sobrepõe, não há colisão.
  _checkCollision(a, b) {
    return (
      a.x              < b.x + b.width  &&
      a.x + a.width    > b.x            &&
      a.y              < b.y + b.height &&
      a.y + a.height   > b.y
    )
  }

  _update() {
    this.frameCount++
    this.score++
    this._updateSpeed()
    this.player.update()

    if (this.frameCount % this.spawnInterval === 0) {
      this.obstacles.push(new Obstacle(this.canvas, this.speed))
    }

    this.obstacles.forEach(o => o.update())
    this.obstacles = this.obstacles.filter(o => !o.isOffScreen())

    for (const obs of this.obstacles) {
      if (this._checkCollision(this.player, obs)) {
        this.isGameOver = true
        this.running = false
        return
      }
    }
  }

  _draw() {
    const { ctx, canvas } = this

    // Fundo
    ctx.fillStyle = '#0f172a'
    ctx.fillRect(0, 0, canvas.width, canvas.height)

    // Chão
    ctx.fillStyle = '#334155'
    ctx.fillRect(0, canvas.height - 20, canvas.width, 20)

    this.player.draw(ctx)
    this.obstacles.forEach(o => o.draw(ctx))

    // HUD
    ctx.fillStyle = '#f1f5f9'
    ctx.font = 'bold 14px monospace'
    ctx.fillText(`Score: ${this.score}`, 16, 28)
    ctx.fillText(`Vel: ${this.speed.toFixed(1)}x`, 16, 48)

    if (this.isGameOver) {
      ctx.fillStyle = 'rgba(0,0,0,0.75)'
      ctx.fillRect(0, 0, canvas.width, canvas.height)
      ctx.textAlign = 'center'
      ctx.fillStyle = '#ef4444'
      ctx.font = 'bold 28px monospace'
      ctx.fillText('GAME OVER', canvas.width / 2, canvas.height / 2 - 24)
      ctx.fillStyle = '#f1f5f9'
      ctx.font = '16px monospace'
      ctx.fillText(`Score: ${this.score}`, canvas.width / 2, canvas.height / 2 + 12)
      ctx.fillText('Espaço / Toque para reiniciar', canvas.width / 2, canvas.height / 2 + 40)
      ctx.textAlign = 'left'
    }
  }

  _loop() {
    if (!this.running) return
    this._update()
    this._draw()
    this.animId = requestAnimationFrame(() => this._loop())
  }

  start() {
    this.running = true
    this._loop()
  }

  stop() {
    this.running = false
    cancelAnimationFrame(this.animId)
  }
}
```

- [ ] **Passo 2: Criar `src/style.css`**

```css
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #0f172a; color: #f1f5f9; font-family: system-ui, sans-serif; min-height: 100vh; }

.game-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 2rem;
  background: #1e293b;
  border-bottom: 1px solid #334155;
}
.title-area { display: flex; flex-direction: column; align-items: center; gap: 8px; }
.back-link { color: #94a3b8; text-decoration: none; font-size: 0.9rem; }
.back-link:hover { color: #38bdf8; }
h1 { font-size: 1.5rem; font-weight: 700; }
.badges { display: flex; gap: 6px; }
.badge {
  background: rgba(56,189,248,0.1);
  border: 1px solid rgba(56,189,248,0.3);
  color: #38bdf8;
  padding: 2px 10px;
  border-radius: 999px;
  font-size: 0.75rem;
  font-weight: 600;
}

main { display: flex; flex-direction: column; align-items: center; gap: 1rem; padding: 1.5rem 1rem; }
.hint { color: #64748b; font-size: 0.85rem; }
kbd { background: #1e293b; border: 1px solid #334155; padding: 1px 6px; border-radius: 4px; }
#game-canvas { border: 2px solid #334155; border-radius: 8px; display: block; }
```

- [ ] **Passo 3: Criar `src/main.js`**

```js
import './style.css'
import { GameLoop } from './GameLoop.js'

const canvas = document.getElementById('game-canvas')
canvas.width = Math.min(window.innerWidth - 32, 800)
canvas.height = 200

let game = new GameLoop(canvas)
game.start()

function handleJump() {
  if (game.isGameOver) {
    game.stop()
    game = new GameLoop(canvas)
    game.start()
  } else {
    game.player.jump()
  }
}

document.addEventListener('keydown', e => {
  if (e.code === 'Space' || e.code === 'ArrowUp') {
    e.preventDefault()
    handleJump()
  }
})

canvas.addEventListener('click', handleJump)
canvas.addEventListener('touchstart', e => { e.preventDefault(); handleJump() })
```

---

## Tarefa 14: runner-vanilla — Build e Validação

- [ ] **Passo 1: Rodar build**

```bash
cd games/runner-vanilla
npm run build
```

Esperado: `games/runner-vanilla/dist/` criado sem erros.

- [ ] **Passo 2: Testar localmente**

```bash
npm run dev
```

Verificar: canvas aparece, personagem pula ao pressionar Espaço/↑, obstáculos surgem e aumentam de velocidade, colisão termina o jogo, reinício funciona.

- [ ] **Passo 3: Commit**

```bash
git add games/runner-vanilla/
git commit -m "feat: endless runner Dino Bug Run (Vanilla JS + Canvas)"
```

---

## Tarefa 15: Scaffold do typing-svelte

**Arquivos:**
- Criar: `games/typing-svelte/` via Vite
- Criar: `games/typing-svelte/vite.config.js`

- [ ] **Passo 1: Scaffold Svelte**

```bash
cd games
npm create vite@latest typing-svelte -- --template svelte
cd typing-svelte
npm install
```

- [ ] **Passo 2: Limpar scaffold**

```bash
rm -f src/lib/Counter.svelte src/assets/svelte.svg
```

- [ ] **Passo 3: Criar `vite.config.js`**

```js
import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'

export default defineConfig({
  base: '/games/typing-svelte/',
  plugins: [svelte()],
})
```

- [ ] **Passo 4: Atualizar `index.html`**

```html
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Typing Defense — Defenda o Servidor</title>
  </head>
  <body>
    <div id="app"></div>
    <script type="module" src="/src/main.js"></script>
  </body>
</html>
```

---

## Tarefa 16: typing-svelte — Dados e Store

**Arquivos:**
- Criar: `games/typing-svelte/src/data/commands.js`
- Criar: `games/typing-svelte/src/stores/game.js`

- [ ] **Passo 1: Criar `src/data/commands.js`**

```js
export const COMMANDS = [
  'git push',
  'npm install',
  'git commit',
  'npm run dev',
  'git status',
  'npm run build',
  'git pull',
  'npm start',
  'git clone',
  'git merge',
  'git stash',
  'npm test',
  'git log',
  'npm init',
  'git diff',
  'git reset',
  'npm audit',
  'git fetch',
]
```

- [ ] **Passo 2: Criar `src/stores/game.js`**

```js
import { writable, derived } from 'svelte/store'

export const enemies  = writable([])
export const lives    = writable(3)
export const score    = writable(0)
export const typed    = writable('')
export const gameOver = writable(false)

// O inimigo ativo é sempre o primeiro não destruído — o jogador deve digitar o comando dele
export const activeEnemy = derived(enemies, $enemies =>
  $enemies.find(e => !e.destroyed) ?? null
)
```

---

## Tarefa 17: typing-svelte — Enemy.svelte e App.svelte

**Arquivos:**
- Criar: `games/typing-svelte/src/components/Enemy.svelte`
- Criar: `games/typing-svelte/src/App.svelte`
- Criar: `games/typing-svelte/src/app.css`

- [ ] **Passo 1: Criar `src/components/Enemy.svelte`**

```svelte
<script>
  export let enemy
</script>

<div
  class="enemy"
  style="left: {enemy.x}px; top: {enemy.y}px"
>
  <div class="alien">👾</div>
  <div class="command">{enemy.command}</div>
</div>

<style>
.enemy {
  position: absolute;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
  pointer-events: none;
}
.alien { font-size: 2rem; line-height: 1; }
.command {
  background: #1e293b;
  border: 1px solid #334155;
  color: #38bdf8;
  font-family: 'Courier New', monospace;
  font-size: 0.78rem;
  padding: 2px 8px;
  border-radius: 4px;
  white-space: nowrap;
}
</style>
```

- [ ] **Passo 2: Criar `src/app.css`**

```css
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #0f172a; color: #f1f5f9; font-family: system-ui, sans-serif; min-height: 100vh; overflow: hidden; }

.app { min-height: 100vh; display: flex; flex-direction: column; }

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 2rem;
  background: #1e293b;
  border-bottom: 1px solid #334155;
  z-index: 10;
  position: relative;
}
.title-area { display: flex; flex-direction: column; align-items: center; gap: 6px; }
.back-link { color: #94a3b8; text-decoration: none; font-size: 0.85rem; }
.back-link:hover { color: #38bdf8; }
h1 { font-size: 1.3rem; font-weight: 700; }
.badges { display: flex; gap: 6px; }
.badge {
  background: rgba(56,189,248,0.1);
  border: 1px solid rgba(56,189,248,0.3);
  color: #38bdf8;
  padding: 2px 8px;
  border-radius: 999px;
  font-size: 0.7rem;
  font-weight: 600;
}

.hud {
  display: flex;
  justify-content: center;
  gap: 3rem;
  padding: 0.75rem;
  background: #0f172a;
  font-size: 1rem;
  font-weight: 600;
  z-index: 10;
  position: relative;
}

.arena {
  flex: 1;
  position: relative;
  overflow: hidden;
}

.ground {
  position: absolute;
  bottom: 80px;
  left: 0;
  right: 0;
  height: 2px;
  background: #334155;
}

.server {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 80px;
  background: #1e293b;
  border-top: 2px solid #334155;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 4px;
}

.input-display {
  font-family: 'Courier New', monospace;
  font-size: 1.1rem;
  color: #f1f5f9;
  background: #0f172a;
  border: 1px solid #334155;
  border-radius: 6px;
  padding: 4px 12px;
  min-width: 220px;
  text-align: left;
}

.cursor {
  animation: blink 1s step-end infinite;
  color: #38bdf8;
}

@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }

.game-over-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.8);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  z-index: 20;
}
.game-over-overlay h2 { font-size: 2rem; color: #ef4444; }

.btn {
  background: #38bdf8;
  color: #0f172a;
  border: none;
  padding: 0.6rem 1.8rem;
  border-radius: 8px;
  font-weight: 700;
  cursor: pointer;
  font-size: 1rem;
}
.btn:hover { background: #7dd3fc; }

.hint-text { font-size: 0.8rem; color: #64748b; }
```

- [ ] **Passo 3: Criar `src/App.svelte`**

```svelte
<script>
  import { onMount, onDestroy } from 'svelte'
  import Enemy from './components/Enemy.svelte'
  import { enemies, lives, score, typed, gameOver, activeEnemy } from './stores/game.js'
  import { COMMANDS } from './data/commands.js'
  import './app.css'

  let inputValue = ''
  let loopId = null
  let spawnId = null
  let enemyId = 0
  let arenaHeight = 400

  const FALL_SPEED = 0.4
  const SPAWN_INTERVAL_MS = 3500
  const GROUND_OFFSET = 82  // altura da zona do servidor

  function getArenaHeight() {
    return window.innerHeight - 120
  }

  function spawnEnemy() {
    if ($gameOver) return
    const command = COMMANDS[Math.floor(Math.random() * COMMANDS.length)]
    const maxX = Math.max(window.innerWidth - 200, 100)
    const x = 40 + Math.random() * maxX
    enemies.update(list => [...list, { id: enemyId++, command, x, y: -60, destroyed: false }])
  }

  function gameLoop() {
    if ($gameOver) return
    enemies.update(list =>
      list.map(e => {
        if (e.destroyed) return e
        const newY = e.y + FALL_SPEED
        // Inimigo chegou ao servidor — remove uma vida e marca como destruído
        if (newY > arenaHeight - GROUND_OFFSET) {
          lives.update(l => l - 1)
          return { ...e, destroyed: true }
        }
        return { ...e, y: newY }
      }).filter(e => !e.destroyed || e.y < arenaHeight)
    )

    if ($lives <= 0) {
      gameOver.set(true)
      clearInterval(spawnId)
      return
    }

    loopId = requestAnimationFrame(gameLoop)
  }

  // Capturo cada tecla digitada e verifico se bate com o comando do inimigo ativo
  function handleKeydown(e) {
    if ($gameOver) return
    if (e.key === 'Backspace') {
      inputValue = inputValue.slice(0, -1)
    } else if (e.key.length === 1 && !e.ctrlKey && !e.metaKey) {
      inputValue += e.key
    }
    typed.set(inputValue)

    const target = $activeEnemy
    if (target && inputValue === target.command) {
      enemies.update(list => list.map(e => e.id === target.id ? { ...e, destroyed: true } : e))
      score.update(s => s + 100 + target.command.length * 5)
      inputValue = ''
      typed.set('')
    }
  }

  function restart() {
    enemies.set([])
    lives.set(3)
    score.set(0)
    typed.set('')
    gameOver.set(false)
    inputValue = ''
    enemyId = 0
    spawnEnemy()
    spawnId = setInterval(spawnEnemy, SPAWN_INTERVAL_MS)
    loopId = requestAnimationFrame(gameLoop)
  }

  onMount(() => {
    arenaHeight = getArenaHeight()
    window.addEventListener('keydown', handleKeydown)
    spawnEnemy()
    spawnId = setInterval(spawnEnemy, SPAWN_INTERVAL_MS)
    loopId = requestAnimationFrame(gameLoop)
  })

  onDestroy(() => {
    window.removeEventListener('keydown', handleKeydown)
    cancelAnimationFrame(loopId)
    clearInterval(spawnId)
  })
</script>

<div class="app">
  <header class="header">
    <a href="/" class="back-link">← Portfólio</a>
    <div class="title-area">
      <h1>⌨️ Typing Defense</h1>
      <div class="badges">
        <span class="badge">Svelte</span>
        <span class="badge">Vite</span>
        <span class="badge">CSS Animations</span>
      </div>
    </div>
    <div></div>
  </header>

  <div class="hud">
    <span>❤️ {$lives}</span>
    <span>🏆 {$score}</span>
  </div>

  <div class="arena" style="height: {arenaHeight}px">
    {#each $enemies as enemy (enemy.id)}
      {#if !enemy.destroyed}
        <Enemy {enemy} />
      {/if}
    {/each}

    <div class="ground"></div>

    <div class="server">
      <span class="hint-text">Digite o comando do inimigo para destruí-lo</span>
      <div class="input-display">
        <span style="color:#64748b">$ </span>{$typed}<span class="cursor">_</span>
      </div>
    </div>

    {#if $gameOver}
      <div class="game-over-overlay">
        <h2>💀 GAME OVER</h2>
        <p>Score final: {$score}</p>
        <button class="btn" on:click={restart}>Reiniciar</button>
      </div>
    {/if}
  </div>
</div>
```

- [ ] **Passo 4: Atualizar `src/main.js`**

```js
import { mount } from 'svelte'
import App from './App.svelte'

const app = mount(App, { target: document.getElementById('app') })

export default app
```

---

## Tarefa 18: typing-svelte — Build e Validação

- [ ] **Passo 1: Rodar build**

```bash
cd games/typing-svelte
npm run build
```

Esperado: `games/typing-svelte/dist/` criado sem erros.

- [ ] **Passo 2: Testar localmente**

```bash
npm run dev
```

Verificar: inimigos caem com comandos visíveis, digitação em tempo real aparece na barra inferior, inimigo é destruído ao digitar o comando correto, vidas diminuem se inimigo chega ao servidor, game over funciona, reinício funciona.

- [ ] **Passo 3: Commit**

```bash
git add games/typing-svelte/
git commit -m "feat: jogo de digitação Typing Defense (Svelte)"
```

---

## Tarefa 19: Seção #minijogos no Portfólio Laravel

**Arquivos:**
- Modificar: `resources/views/pages/home.blade.php`

- [ ] **Passo 1: Adicionar seção `#minijogos` antes da seção `#contact` em `home.blade.php`**

Inserir o seguinte bloco logo antes da linha `<section id="contact"`:

```blade
    {{-- Seção de Minijogos --}}
    <section id="minijogos" class="py-24 bg-bg-card">
        <div class="container mx-auto px-6">

            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Minijogos</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
                <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl mx-auto">
                    4 jogos construídos com stacks diferentes para demonstrar versatilidade Front-end.
                    Cada um foi desenvolvido do zero com suas próprias tecnologias.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Tech Match --}}
                <div class="bg-bg-primary rounded-xl border border-gray-200 dark:border-gray-800 p-6
                            hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                     data-aos="fade-up" data-aos-delay="0">
                    <div class="text-3xl mb-3">🃏</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Tech Match</h3>
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(['Vue 3', 'Vite', 'CSS Puro'] as $tag)
                            <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                        Jogo da memória com logos de tecnologias. Animação de flip em CSS puro, cronômetro e contador de tentativas.
                    </p>
                    <a href="/games/memory-vue/" target="_blank" rel="noopener noreferrer"
                       class="mt-4 inline-flex items-center justify-center gap-2 bg-accent hover:bg-accent/90
                              text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                </div>

                {{-- Techdle --}}
                <div class="bg-bg-primary rounded-xl border border-gray-200 dark:border-gray-800 p-6
                            hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                     data-aos="fade-up" data-aos-delay="100">
                    <div class="text-3xl mb-3">🟩</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Techdle</h3>
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(['React', 'TypeScript', 'Tailwind'] as $tag)
                            <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                        Clone do Wordle com palavras do universo tech. Teclado virtual, validação de letras e histórico salvo no LocalStorage.
                    </p>
                    <a href="/games/termo-react/" target="_blank" rel="noopener noreferrer"
                       class="mt-4 inline-flex items-center justify-center gap-2 bg-accent hover:bg-accent/90
                              text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                </div>

                {{-- Dino Bug Run --}}
                <div class="bg-bg-primary rounded-xl border border-gray-200 dark:border-gray-800 p-6
                            hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                     data-aos="fade-up" data-aos-delay="200">
                    <div class="text-3xl mb-3">🦖</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Dino Bug Run</h3>
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(['JavaScript', 'Canvas', 'ES6+'] as $tag)
                            <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                        Endless runner em Canvas puro com OOP, detecção de colisão AABB e velocidade progressiva. Pule com Espaço ou toque.
                    </p>
                    <a href="/games/runner-vanilla/" target="_blank" rel="noopener noreferrer"
                       class="mt-4 inline-flex items-center justify-center gap-2 bg-accent hover:bg-accent/90
                              text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                </div>

                {{-- Typing Defense --}}
                <div class="bg-bg-primary rounded-xl border border-gray-200 dark:border-gray-800 p-6
                            hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                     data-aos="fade-up" data-aos-delay="300">
                    <div class="text-3xl mb-3">⌨️</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Typing Defense</h3>
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(['Svelte', 'Vite', 'CSS Animations'] as $tag)
                            <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                        Aliens caem com comandos de terminal. Digite o comando correto para destruí-los antes que cheguem ao servidor.
                    </p>
                    <a href="/games/typing-svelte/" target="_blank" rel="noopener noreferrer"
                       class="mt-4 inline-flex items-center justify-center gap-2 bg-accent hover:bg-accent/90
                              text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                </div>

            </div>
        </div>
    </section>
```

- [ ] **Passo 2: Commit**

```bash
git add resources/views/pages/home.blade.php
git commit -m "feat: seção de minijogos no portfólio"
```

---

## Tarefa 20: Build:all e Deploy Final

- [ ] **Passo 1: Criar `.gitignore` em `public/games/` para não commitar os builds**

Criar `public/games/.gitignore`:
```
memory-vue/
termo-react/
runner-vanilla/
typing-svelte/
```

- [ ] **Passo 2: Rodar `build:all` da raiz de `games/`**

```bash
cd games
npm run build:all
```

Esperado:
```
✓ memory-vue → public/games/memory-vue
✓ termo-react → public/games/termo-react
✓ runner-vanilla → public/games/runner-vanilla
✓ typing-svelte → public/games/typing-svelte
```

- [ ] **Passo 3: Verificar arquivos gerados**

```bash
ls public/games/memory-vue/
ls public/games/termo-react/
ls public/games/runner-vanilla/
ls public/games/typing-svelte/
```

Esperado: cada diretório tem `index.html` + `assets/`.

- [ ] **Passo 4: Commit final**

```bash
git add public/games/.gitignore games/
git commit -m "feat: pipeline build:all e deploy dos minijogos"
```

---

## Notas de Deploy na Hostinger

Após fazer push do repositório para o servidor:

1. Instalar dependências dos jogos: `cd games && npm install --prefix memory-vue && npm install --prefix termo-react && npm install --prefix runner-vanilla && npm install --prefix typing-svelte`
2. Rodar build: `npm run build:all`
3. Os jogos ficam disponíveis em `seudominio.com/games/<nome>/`

Se o Hostinger não permitir Node.js via SSH, fazer o build localmente e fazer upload da pasta `public/games/` via FTP/deploy manual.
