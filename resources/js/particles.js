/**
 * particles.js - Engine de constelação interativa (Canvas API puro)
 * Instanciado 3x em app.js: #hero, #about, #projects
 */

const PARTICLE_COUNT_DESKTOP = 85;
const PARTICLE_COUNT_MOBILE = 40;   // largura < 768px
const CONNECT_DISTANCE = 135;  // px - distância máxima para linha de conexão
const REPEL_RADIUS = 110;  // px - raio de fuga do cursor (D-06, D-07)
const REPEL_FORCE = 0.06; // intensidade da repulsão (suave, proporcional)
const BASE_SPEED = 0.5;  // px/frame (D - velocidade base)
const DOT_RADIUS = 2;    // px - raio do dot (D - tamanho)

function getColor() {
  // D-03, D-04, D-05: detectar .dark em documentElement
  return document.documentElement.classList.contains('dark')
    ? 'rgba(255, 255, 255, 0.38)'   // dark mode - branco ~38% opacidade
    : 'rgba(148, 163, 184, 0.45)';  // light mode - slate-300 ~45% opacidade
}

class Particle {
  constructor(w, h) {
    this.reset(w, h);
  }

  reset(w, h) {
    this.x = Math.random() * w;
    this.y = Math.random() * h;
    this.vx = (Math.random() - 0.5) * BASE_SPEED * 2;
    this.vy = (Math.random() - 0.5) * BASE_SPEED * 2;
    // velocidade original para retorno suave após fuga
    this.ovx = this.vx;
    this.ovy = this.vy;
  }

  update(w, h, mouseX, mouseY) {
    // Fuga suave do cursor (D-06, D-07)
    const dx = this.x - mouseX;
    const dy = this.y - mouseY;
    const dist = Math.sqrt(dx * dx + dy * dy);

    if (dist < REPEL_RADIUS && dist > 0) {
      const force = (REPEL_RADIUS - dist) / REPEL_RADIUS;
      this.vx += (dx / dist) * force * REPEL_FORCE * 10;
      this.vy += (dy / dist) * force * REPEL_FORCE * 10;
    }

    // Retorno gradual à velocidade original
    this.vx += (this.ovx - this.vx) * 0.02;
    this.vy += (this.ovy - this.vy) * 0.02;

    // Limitar velocidade máxima
    const speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
    if (speed > BASE_SPEED * 4) {
      this.vx = (this.vx / speed) * BASE_SPEED * 4;
      this.vy = (this.vy / speed) * BASE_SPEED * 4;
    }

    this.x += this.vx;
    this.y += this.vy;

    // Bounce nas bordas
    if (this.x < 0) { this.x = 0; this.vx *= -1; this.ovx *= -1; }
    if (this.x > w) { this.x = w; this.vx *= -1; this.ovx *= -1; }
    if (this.y < 0) { this.y = 0; this.vy *= -1; this.ovy *= -1; }
    if (this.y > h) { this.y = h; this.vy *= -1; this.ovy *= -1; }
  }

  draw(ctx) {
    ctx.beginPath();
    ctx.arc(this.x, this.y, DOT_RADIUS, 0, Math.PI * 2);
    ctx.fill();
  }
}

export class ParticleCanvas {
  constructor(containerSelector) {
    this._containerSelector = containerSelector;
    this._container = document.querySelector(containerSelector);
    if (!this._container) return;

    this._canvas = document.createElement('canvas');
    const s = this._canvas.style;
    s.position = 'absolute';
    s.top = '0';
    s.left = '0';
    s.width = '100%';
    s.height = '100%';
    s.pointerEvents = 'none';   // D-10: não bloqueia cliques
    s.zIndex = '0';      // D-10: atrás do conteúdo (conteúdo usa z-index maior)

    // Inserir como primeiro filho para ficar atrás de todo conteúdo
    this._container.insertBefore(this._canvas, this._container.firstChild);

    this._ctx = this._canvas.getContext('2d');
    this._particles = [];
    this._mouseX = -9999;
    this._mouseY = -9999;
    this._rafId = null;

    this._onResize = this._resize.bind(this);
    this._onMouse = this._trackMouse.bind(this);
    this._onLeave = this._mouseLeave.bind(this);

    window.addEventListener('resize', this._onResize);
    this._container.addEventListener('mousemove', this._onMouse);
    this._container.addEventListener('mouseleave', this._onLeave);

    this._resize();
    this._loop();
  }

  _particleCount() {
    // D-08, D-09: mobile metade
    return window.innerWidth < 768 ? PARTICLE_COUNT_MOBILE : PARTICLE_COUNT_DESKTOP;
  }

  _resize() {
    if (!this._canvas) return;
    const rect = this._container.getBoundingClientRect();
    // DPR para nitidez em telas retina
    const dpr = window.devicePixelRatio || 1;
    this._canvas.width = rect.width * dpr;
    this._canvas.height = rect.height * dpr;
    this._ctx.scale(dpr, dpr);
    this._w = rect.width;
    this._h = rect.height;

    const count = this._particleCount();
    // Resetar partículas ao redimensionar
    this._particles = Array.from({ length: count }, () => new Particle(this._w, this._h));
  }

  _trackMouse(e) {
    const rect = this._container.getBoundingClientRect();
    this._mouseX = e.clientX - rect.left;
    this._mouseY = e.clientY - rect.top;
  }

  _mouseLeave() {
    this._mouseX = -9999;
    this._mouseY = -9999;
  }

  pause() {
    if (this._rafId) {
      cancelAnimationFrame(this._rafId);
      this._rafId = null;
    }
  }

  resume() {
    if (!this._rafId) {
      this._loop();
    }
  }

  _loop() {
    this._rafId = requestAnimationFrame(() => this._loop());

    const ctx = this._ctx;
    ctx.clearRect(0, 0, this._w, this._h);

    const color = getColor();
    ctx.fillStyle = color;
    ctx.strokeStyle = color;

    // Atualizar e desenhar dots
    for (const p of this._particles) {
      p.update(this._w, this._h, this._mouseX, this._mouseY);
      p.draw(ctx);
    }

    // Desenhar linhas de conexão (D-01, D-02)
    ctx.lineWidth = 0.6;
    for (let i = 0; i < this._particles.length; i++) {
      for (let j = i + 1; j < this._particles.length; j++) {
        const a = this._particles[i];
        const b = this._particles[j];
        const dx = a.x - b.x;
        const dy = a.y - b.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < CONNECT_DISTANCE) {
          // Opacidade proporcional à distância (D-02)
          const alpha = 1 - dist / CONNECT_DISTANCE;
          ctx.globalAlpha = alpha * 0.6;
          ctx.beginPath();
          ctx.moveTo(a.x, a.y);
          ctx.lineTo(b.x, b.y);
          ctx.stroke();
        }
      }
    }
    ctx.globalAlpha = 1;
  }

  destroy() {
    if (this._rafId) cancelAnimationFrame(this._rafId);
    window.removeEventListener('resize', this._onResize);
    if (this._container) {
      this._container.removeEventListener('mousemove', this._onMouse);
      this._container.removeEventListener('mouseleave', this._onLeave);
    }
    if (this._canvas && this._canvas.parentNode) {
      this._canvas.parentNode.removeChild(this._canvas);
    }
  }
}
