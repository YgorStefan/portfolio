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

  _updateSpeed() {
    this.speed = 5 + Math.floor(this.score / 500) * 0.5
  }

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

    ctx.fillStyle = '#0f172a'
    ctx.fillRect(0, 0, canvas.width, canvas.height)

    ctx.fillStyle = '#334155'
    ctx.fillRect(0, canvas.height - 20, canvas.width, 20)

    this.player.draw(ctx)
    this.obstacles.forEach(o => o.draw(ctx))

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
