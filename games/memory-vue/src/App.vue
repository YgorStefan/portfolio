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
// I use isBlocked to freeze input while two cards are face-up, giving the player time to see them before they flip back
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
        <a href="javascript:void(0)" class="back-link" onclick="if(window.opener&&!window.opener.closed){window.opener.focus();window.close();}else{location.href='/';}">← Voltar para o Portfólio</a>
      </div>
      <div class="title-area">
        <h1>🃏 Jogo da Memória Tech</h1>
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
        <span>🃏 {{ matchedCount / 2 }}/8 pares</span>
        <button class="btn btn-sm" @click="resetGame">↺ Reiniciar</button>
      </div>

      <div v-if="allMatched" class="win-banner">
        🎉 Você venceu em {{ attempts }} tentativas e {{ timeFormatted }}!
        <button class="btn" @click="resetGame">Jogar novamente</button>
      </div>

      <Board :cards="cards" :disabled="isBlocked" @flip="flipCard" />
    </main>
  </div>
</template>
