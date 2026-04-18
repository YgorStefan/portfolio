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
  const GROUND_OFFSET = 82

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
