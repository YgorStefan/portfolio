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
    ctx.fillStyle = '#38bdf8'
    ctx.fillRect(this.x, this.y, this.width, this.height)
    ctx.fillStyle = '#0f172a'
    ctx.fillRect(this.x + 7,  this.y + 10, 9, 9)
    ctx.fillRect(this.x + 24, this.y + 10, 9, 9)
    ctx.fillRect(this.x + 10, this.y + 30, 20, 4)
  }
}
