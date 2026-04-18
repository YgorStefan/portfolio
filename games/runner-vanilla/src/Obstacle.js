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
    ctx.fillStyle = '#fff'
    ctx.font = '16px sans-serif'
    ctx.fillText('🐛', this.x - 2, this.y - 4)
  }
}
