import { normalizeDelta } from './physics.js'

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
    this.frame = 0
    this.frameTimer = 0
  }

  jump() {
    if (this.isOnGround) {
      this.vy = this.jumpForce
      this.isOnGround = false
    }
  }

  update(delta) {
    const dt = normalizeDelta(delta)
    this.vy += this.gravity * dt
    this.y += this.vy * dt
    if (this.y >= this.groundY) {
      this.y = this.groundY
      this.vy = 0
      this.isOnGround = true
    }
    if (this.isOnGround) {
      this.frameTimer += dt
      if (this.frameTimer >= 8) { this.frame = (this.frame + 1) % 2; this.frameTimer = 0 }
    }
  }

  draw(ctx) {
    const { x, y, width: w, height: h } = this
    ctx.fillStyle = '#2d6a1f'
    ctx.fillRect(x + 4, y + 14, w - 8, h - 14)
    ctx.fillRect(x + 8, y, w - 10, 18)
    ctx.fillStyle = '#fff'
    ctx.fillRect(x + w - 10, y + 4, 8, 8)
    ctx.fillStyle = '#111'
    ctx.fillRect(x + w - 8, y + 6, 4, 4)
    ctx.fillStyle = '#3a8a28'
    if (!this.isOnGround) {
      ctx.fillRect(x + 8,  y + h - 12, 8, 16)
      ctx.fillRect(x + 22, y + h - 12, 8, 16)
    } else if (this.frame === 0) {
      ctx.fillRect(x + 8,  y + h - 6,  8, 14)
      ctx.fillRect(x + 22, y + h - 14, 8, 8)
    } else {
      ctx.fillRect(x + 8,  y + h - 14, 8, 8)
      ctx.fillRect(x + 22, y + h - 6,  8, 14)
    }
  }
}
