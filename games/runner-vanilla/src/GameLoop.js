import { Player } from './Player.js'
import { Obstacle } from './Obstacle.js'
import { normalizeDelta, calcSpeedMultiplier, shouldSpawn, FRAME_MS } from './physics.js'

const SPAWN_INTERVAL_MS = 1500

export class GameLoop {
  constructor(canvas) {
    this.canvas = canvas
    this.ctx = canvas.getContext('2d')
    this.player = new Player(canvas)
    this.obstacles = []
    this.score = 0
    this.speedMultiplier = 1.0
    this.spawnAccumulator = 0
    this.lastTime = 0
    this.running = false
    this.isGameOver = false
    this.animId = null
    this.lastScore = parseInt(localStorage.getItem('dino_last_score') || '0')
  }

  get speed() { return this.speedMultiplier * 5 }

  _updateSpeed() {
    this.speedMultiplier = calcSpeedMultiplier(this.score)
  }

  _checkCollision(a, b) {
    return (
      a.x              < b.x + b.width  &&
      a.x + a.width    > b.x            &&
      a.y              < b.y + b.height &&
      a.y + a.height   > b.y
    )
  }

  _update(delta) {
    const dt = normalizeDelta(delta)
    this.score += dt
    this._updateSpeed()
    this.player.update(delta)

    this.spawnAccumulator += delta
    if (shouldSpawn(this.spawnAccumulator, SPAWN_INTERVAL_MS)) {
      this.obstacles.push(new Obstacle(this.canvas, this.speed))
      this.spawnAccumulator -= SPAWN_INTERVAL_MS
    }

    this.obstacles.forEach(o => o.update(delta))
    this.obstacles = this.obstacles.filter(o => !o.isOffScreen())

    for (const obs of this.obstacles) {
      if (this._checkCollision(this.player, obs)) {
        this.isGameOver = true
        this.running = false
        localStorage.setItem('dino_last_score', String(Math.floor(this.score)))
        return
      }
    }
  }

  _draw() {
    const { ctx, canvas } = this

    ctx.fillStyle = '#1a1005'
    ctx.fillRect(0, 0, canvas.width, canvas.height)

    ctx.fillStyle = '#3d2510'
    ctx.fillRect(0, canvas.height - 20, canvas.width, 20)

    this.player.draw(ctx)
    this.obstacles.forEach(o => o.draw(ctx))

    ctx.fillStyle = '#fbbf24'
    ctx.font = 'bold 14px monospace'
    ctx.fillText(`Score: ${Math.floor(this.score)}`, 16, 28)
    ctx.fillText(`Vel: ${this.speedMultiplier.toFixed(1)}x`, 16, 48)

    if (this.isGameOver) {
      ctx.fillStyle = 'rgba(0,0,0,0.78)'
      ctx.fillRect(0, 0, canvas.width, canvas.height)
      ctx.textAlign = 'center'
      ctx.fillStyle = '#f59e0b'
      ctx.font = 'bold 28px monospace'
      ctx.fillText('Fim de Jogo', canvas.width / 2, canvas.height / 2 - 28)
      ctx.fillStyle = '#f1f5f9'
      ctx.font = '16px monospace'
      ctx.fillText(`Score: ${Math.floor(this.score)} | Último: ${this.lastScore}`, canvas.width / 2, canvas.height / 2 + 8)
      ctx.fillText('Espaço / Toque para reiniciar', canvas.width / 2, canvas.height / 2 + 36)
      ctx.textAlign = 'left'
    }
  }

  _loop(timestamp) {
    if (!this.running) return
    const delta = this.lastTime === 0 ? FRAME_MS : timestamp - this.lastTime
    this.lastTime = timestamp
    this._update(delta)
    this._draw()
    this.animId = requestAnimationFrame(ts => this._loop(ts))
  }

  start() {
    this.running = true
    this.lastTime = 0
    this.animId = requestAnimationFrame(ts => this._loop(ts))
  }

  stop() { this.running = false; cancelAnimationFrame(this.animId) }
}
