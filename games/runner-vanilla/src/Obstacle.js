import { normalizeDelta } from './physics.js'

const INSECT_TYPES = ['beetle', 'mosquito', 'cockroach', 'cricket', 'spider']

function drawBeetle(ctx, x, y, w, h) {
  ctx.fillStyle = '#7c3aed'
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.55, w*0.45, h*0.35, 0, 0, Math.PI*2); ctx.fill()
  ctx.fillStyle = '#6d28d9'
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.28, w*0.3, h*0.25, 0, 0, Math.PI*2); ctx.fill()
  ctx.strokeStyle = '#7c3aed'; ctx.lineWidth = 1.5
  for (let i = 0; i < 3; i++) {
    const ly = y + h*0.45 + i * h*0.12
    ctx.beginPath(); ctx.moveTo(x + w*0.15, ly); ctx.lineTo(x - w*0.2, ly + h*0.1); ctx.stroke()
    ctx.beginPath(); ctx.moveTo(x + w*0.85, ly); ctx.lineTo(x + w*1.2, ly + h*0.1); ctx.stroke()
  }
  ctx.strokeStyle = '#a78bfa'; ctx.lineWidth = 1
  ctx.beginPath(); ctx.moveTo(x + w*0.4, y + h*0.05); ctx.lineTo(x + w*0.2, y - h*0.2); ctx.stroke()
  ctx.beginPath(); ctx.moveTo(x + w*0.6, y + h*0.05); ctx.lineTo(x + w*0.8, y - h*0.2); ctx.stroke()
}

function drawMosquito(ctx, x, y, w, h) {
  ctx.fillStyle = '#6b7280'
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.5, w*0.12, h*0.42, 0, 0, Math.PI*2); ctx.fill()
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.2, w*0.14, h*0.16, 0, 0, Math.PI*2); ctx.fill()
  ctx.fillStyle = 'rgba(156,163,175,0.5)'
  ctx.beginPath(); ctx.moveTo(x + w/2, y + h*0.3); ctx.lineTo(x, y + h*0.1); ctx.lineTo(x + w*0.2, y + h*0.5); ctx.fill()
  ctx.beginPath(); ctx.moveTo(x + w/2, y + h*0.3); ctx.lineTo(x + w, y + h*0.1); ctx.lineTo(x + w*0.8, y + h*0.5); ctx.fill()
  ctx.strokeStyle = '#9ca3af'; ctx.lineWidth = 1
  ctx.beginPath(); ctx.moveTo(x + w/2, y + h*0.1); ctx.lineTo(x + w/2, y - h*0.25); ctx.stroke()
  for (let i = 0; i < 3; i++) {
    ctx.beginPath(); ctx.moveTo(x + w/2 - w*0.08, y + h*(0.45 + i*0.12))
    ctx.lineTo(x - w*0.3, y + h*(0.4 + i*0.12)); ctx.stroke()
    ctx.beginPath(); ctx.moveTo(x + w/2 + w*0.08, y + h*(0.45 + i*0.12))
    ctx.lineTo(x + w*1.3, y + h*(0.4 + i*0.12)); ctx.stroke()
  }
}

function drawCockroach(ctx, x, y, w, h) {
  ctx.fillStyle = '#92400e'
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.5, w*0.48, h*0.3, 0, 0, Math.PI*2); ctx.fill()
  ctx.fillStyle = '#78350f'
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.22, w*0.28, h*0.2, 0, 0, Math.PI*2); ctx.fill()
  ctx.strokeStyle = '#b45309'; ctx.lineWidth = 1.5
  for (let i = 0; i < 3; i++) {
    const lx = x + w*(0.2 + i*0.25)
    ctx.beginPath(); ctx.moveTo(lx, y + h*0.65); ctx.lineTo(lx - w*0.15, y + h); ctx.stroke()
    ctx.beginPath(); ctx.moveTo(lx, y + h*0.65); ctx.lineTo(lx + w*0.05, y + h); ctx.stroke()
  }
  ctx.strokeStyle = '#d97706'; ctx.lineWidth = 1
  ctx.beginPath(); ctx.moveTo(x + w*0.45, y + h*0.1); ctx.lineTo(x + w*0.2, y - h*0.15); ctx.stroke()
  ctx.beginPath(); ctx.moveTo(x + w*0.55, y + h*0.1); ctx.lineTo(x + w*0.8, y - h*0.15); ctx.stroke()
}

function drawCricket(ctx, x, y, w, h) {
  ctx.fillStyle = '#16a34a'
  ctx.beginPath(); ctx.ellipse(x + w*0.35, y + h*0.5, w*0.35, h*0.28, -0.2, 0, Math.PI*2); ctx.fill()
  ctx.beginPath(); ctx.ellipse(x + w*0.72, y + h*0.45, w*0.2, h*0.22, 0, 0, Math.PI*2); ctx.fill()
  ctx.strokeStyle = '#15803d'; ctx.lineWidth = 1.5
  for (let i = 0; i < 2; i++) {
    const lx = x + w*(0.18 + i*0.25)
    ctx.beginPath(); ctx.moveTo(lx, y + h*0.65); ctx.lineTo(lx - w*0.15, y + h*0.9); ctx.stroke()
  }
  ctx.lineWidth = 2
  ctx.beginPath(); ctx.moveTo(x + w*0.08, y + h*0.7); ctx.lineTo(x - w*0.1, y + h); ctx.stroke()
  ctx.beginPath(); ctx.moveTo(x + w*0.22, y + h*0.7); ctx.lineTo(x + w*0.05, y + h); ctx.stroke()
  ctx.strokeStyle = '#4ade80'; ctx.lineWidth = 1
  ctx.beginPath(); ctx.moveTo(x + w*0.72, y + h*0.3); ctx.lineTo(x + w*0.65, y - h*0.1); ctx.stroke()
  ctx.beginPath(); ctx.moveTo(x + w*0.82, y + h*0.3); ctx.lineTo(x + w*0.95, y - h*0.1); ctx.stroke()
}

function drawSpider(ctx, x, y, w, h) {
  ctx.fillStyle = '#1e1b4b'
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.5, w*0.35, h*0.32, 0, 0, Math.PI*2); ctx.fill()
  ctx.fillStyle = '#312e81'
  ctx.beginPath(); ctx.ellipse(x + w/2, y + h*0.18, w*0.22, h*0.18, 0, 0, Math.PI*2); ctx.fill()
  ctx.fillStyle = '#e11d48'
  ctx.fillRect(x + w*0.38, y + h*0.44, w*0.24, h*0.12)
  ctx.strokeStyle = '#4338ca'; ctx.lineWidth = 1.5
  const legAngles = [-0.6, -0.2, 0.2, 0.6]
  legAngles.forEach(a => {
    ctx.beginPath()
    ctx.moveTo(x + w*0.15, y + h*0.5)
    ctx.quadraticCurveTo(x, y + h*(0.5 + a*0.3), x - w*0.25, y + h*(0.5 + a*0.5))
    ctx.stroke()
    ctx.beginPath()
    ctx.moveTo(x + w*0.85, y + h*0.5)
    ctx.quadraticCurveTo(x + w, y + h*(0.5 + a*0.3), x + w*1.25, y + h*(0.5 + a*0.5))
    ctx.stroke()
  })
}

const DRAW_FNS = { beetle: drawBeetle, mosquito: drawMosquito, cockroach: drawCockroach, cricket: drawCricket, spider: drawSpider }
const SCALES = [0.6, 0.8, 1.0, 1.2, 1.4]

export class Obstacle {
  constructor(canvas, speed) {
    this.canvas = canvas
    const type = INSECT_TYPES[Math.floor(Math.random() * INSECT_TYPES.length)]
    const scale = SCALES[Math.floor(Math.random() * SCALES.length)]
    this.type = type
    this.baseW = 30
    this.baseH = 40
    this.width = this.baseW * scale
    this.height = this.baseH * scale
    this.x = canvas.width + 10
    this.y = canvas.height - 20 - this.height
    this.speed = speed
  }

  update(delta) { this.x -= this.speed * normalizeDelta(delta) }
  isOffScreen() { return this.x + this.width < 0 }

  draw(ctx) {
    DRAW_FNS[this.type](ctx, this.x, this.y, this.width, this.height)
  }
}
