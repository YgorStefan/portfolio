<script>
  import { onMount, onDestroy } from 'svelte'
  import Enemy from './components/Enemy.svelte'
  import { enemies, lives, score, typed, gameOver, activeEnemy } from './stores/game.js'
  import { shuffleCommands } from './data/commands.js'
  import './app.css'

  let inputValue = ''
  let mobileInputEl = null
  let loopId = null
  let spawnId = null
  let speedTimerId = null
  let enemyId = 0
  let arenaHeight = 400
  let lastTime = 0
  let fallSpeed = 0.4
  const INITIAL_SPEED = 0.4
  $: speedMultiplier = fallSpeed / INITIAL_SPEED
  $: speedColor = speedMultiplier < 2 ? '#22c55e' : speedMultiplier < 3 ? '#eab308' : '#ef4444'
  let shuffledCommands = shuffleCommands()
  let cmdIndex = 0

  const SPAWN_INTERVAL_MS = 3500
  const GROUND_OFFSET = 82

  function getArenaHeight() {
    return window.innerHeight - 120
  }

  function nextCommand() {
    const cmd = shuffledCommands[cmdIndex % shuffledCommands.length]
    cmdIndex++
    if (cmdIndex % shuffledCommands.length === 0) shuffledCommands = shuffleCommands()
    return cmd
  }

  function spawnEnemy() {
    if ($gameOver) return
    const command = nextCommand()
    const maxX = Math.max(window.innerWidth - 200, 100)
    const x = 40 + Math.random() * maxX
    const type = Math.floor(Math.random() * 7)
    enemies.update(list => [...list, { id: enemyId++, command, x, y: -60, destroyed: false, type }])
  }

  function gameLoop(timestamp = 0) {
    if ($gameOver) return
    const delta = lastTime === 0 ? 16.67 : timestamp - lastTime
    lastTime = timestamp
    enemies.update(list =>
      list.map(e => {
        if (e.destroyed) return e
        const newY = e.y + fallSpeed * (delta / 16.67)
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
      clearInterval(speedTimerId)
      return
    }

    loopId = requestAnimationFrame(gameLoop)
  }

  function handleInput(value) {
    inputValue = value
    typed.set(inputValue)
    const target = $activeEnemy
    if (target && inputValue === target.command) {
      enemies.update(list => list.map(e => e.id === target.id ? { ...e, destroyed: true } : e))
      score.update(s => s + 100 + target.command.length * 5)
      inputValue = ''
      typed.set('')
      if (mobileInputEl) mobileInputEl.value = ''
    }
  }

  function handleKeydown(e) {
    if ($gameOver) return
    if (e.key === 'Backspace') {
      handleInput(inputValue.slice(0, -1))
    } else if (e.key.length === 1 && !e.ctrlKey && !e.metaKey) {
      handleInput(inputValue + e.key)
    }
  }

  function handleMobileInput(e) {
    handleInput(e.target.value)
  }

  function restart() {
    enemies.set([])
    lives.set(5)
    score.set(0)
    typed.set('')
    gameOver.set(false)
    inputValue = ''
    enemyId = 0
    fallSpeed = 0.4
    lastTime = 0
    shuffledCommands = shuffleCommands()
    cmdIndex = 0
    if (mobileInputEl) mobileInputEl.value = ''
    spawnEnemy()
    spawnId = setInterval(spawnEnemy, SPAWN_INTERVAL_MS)
    speedTimerId = setInterval(() => { fallSpeed = Math.min(fallSpeed + 0.1, 3.0) }, 10000)
    loopId = requestAnimationFrame(gameLoop)
  }

  onMount(() => {
    arenaHeight = getArenaHeight()
    window.addEventListener('keydown', handleKeydown)
    spawnEnemy()
    spawnId = setInterval(spawnEnemy, SPAWN_INTERVAL_MS)
    speedTimerId = setInterval(() => { fallSpeed = Math.min(fallSpeed + 0.1, 3.0) }, 10000)
    loopId = requestAnimationFrame(gameLoop)
  })

  onDestroy(() => {
    window.removeEventListener('keydown', handleKeydown)
    cancelAnimationFrame(loopId)
    clearInterval(spawnId)
    clearInterval(speedTimerId)
  })
</script>

<div class="app">
  <header class="header">
    <a href="javascript:void(0)" class="back-link"
      on:click={() => { window.close(); setTimeout(() => { if (!window.closed) location.href = '/' }, 300) }}>
      ← Voltar para o Portfólio
    </a>
    <div class="title-area">
      <h1>⌨️ Defesa Espacial</h1>
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
    <span style="color: {speedColor}">⚡ {speedMultiplier.toFixed(1)}×</span>
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
        <span style="color:#0a3a50">$ </span>{$typed}<span class="cursor">_</span>
      </div>
      <input
        bind:this={mobileInputEl}
        class="mobile-input-field"
        type="text"
        autocomplete="off"
        autocorrect="off"
        autocapitalize="off"
        spellcheck="false"
        placeholder="Digite aqui..."
        on:input={handleMobileInput}
      />
    </div>

    {#if $gameOver}
      <div class="game-over-overlay">
        <h2>💀 Fim de Jogo</h2>
        <p>Score final: {$score}</p>
        <button class="btn" on:click={restart}>Reiniciar</button>
      </div>
    {/if}
  </div>
</div>
