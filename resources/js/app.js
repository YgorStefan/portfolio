import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { ParticleCanvas } from './particles.js';
import { translations, getLang, setLang, t, applyTranslations } from './i18n.js';

Alpine.plugin(intersect);
window.Alpine = Alpine;

// Expose i18n to global scope for inline usage
window.i18n = { translations, getLang, setLang, t };

// Alpine store for reactive language state
Alpine.store('lang', {
    current: getLang(),
    toggle() {
        this.current = this.current === 'pt' ? 'en' : 'pt';
        setLang(this.current);
    },
    t(key) {
        const entry = translations[key];
        if (!entry) return key;
        return entry[this.current] || entry.pt || key;
    }
});

Alpine.data('skillsGrid', (skills) => ({
    skills,
    cat: 'all',
    page: 0,
    perPage: 8,
    autoMs: 5500,
    timer: null,
    cardsVisible: true,
    started: false,

    get filtered() {
        return this.cat === 'all'
            ? this.skills
            : this.skills.filter(s => s.category === this.cat);
    },

    get totalPages() {
        return Math.max(1, Math.ceil(this.filtered.length / this.perPage));
    },

    get isPaginated() {
        return this.totalPages > 1;
    },

    get currentPageSkills() {
        const start = this.page * this.perPage;
        return this.filtered.slice(start, start + this.perPage);
    },

    get ghosts() {
        const count = this.perPage - this.currentPageSkills.length;
        return Array(Math.max(0, count)).fill(null);
    },

    init() {},

    start() {
        if (this.started) return;
        this.started = true;
        this.$nextTick(() => this.scheduleAuto());
    },

    showCards() {
        this.cardsVisible = false;
        this.$nextTick(() => {
            requestAnimationFrame(() => { this.cardsVisible = true; });
        });
    },

    setCategory(cat) {
        this.cat = cat;
        this.page = 0;
        this.showCards();
        this.$nextTick(() => this.scheduleAuto());
    },

    goTo(p) {
        this.page = Math.max(0, Math.min(p, this.totalPages - 1));
        this.showCards();
        this.$nextTick(() => this.scheduleAuto());
    },

    scheduleAuto() {
        clearTimeout(this.timer);
        if (!this.isPaginated) {
            const bar = this.$refs.progressBar;
            if (bar) { bar.style.transition = 'none'; bar.style.width = '0%'; }
            return;
        }
        this.resetProgress();
        this.timer = setTimeout(() => {
            this.page = (this.page + 1) % this.totalPages;
            this.showCards();
            this.scheduleAuto();
        }, this.autoMs);
    },

    resetProgress() {
        const bar = this.$refs.progressBar;
        if (!bar) return;
        bar.style.transition = 'none';
        bar.style.width = '0%';
        bar.offsetWidth; // força reflow
        bar.style.transition = `width ${this.autoMs}ms linear`;
        bar.style.width = '100%';
    },
}));

Alpine.start();

function watchParticles(canvas, selector) {
    const el = document.querySelector(selector);
    if (!el) return;
    new IntersectionObserver((entries) => {
        entries[0].isIntersecting ? canvas.resume() : canvas.pause();
    }, { threshold: 0 }).observe(el);
}

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 700,
        once: false,
        mirror: true,
        offset: 80,
    });

    // Apply i18n translations on first load
    applyTranslations(getLang());
    document.documentElement.lang = getLang() === 'pt' ? 'pt-BR' : 'en';

    // Partículas interativas — instanciado 4x, pausam quando seção sai do viewport
    const heroParticles      = new ParticleCanvas('#hero');
    const aboutParticles     = new ParticleCanvas('#about');
    const projectParticles   = new ParticleCanvas('#projects');
    const minijogosParticles = new ParticleCanvas('#minijogos');

    watchParticles(heroParticles,      '#hero');
    watchParticles(aboutParticles,     '#about');
    watchParticles(projectParticles,   '#projects');
    watchParticles(minijogosParticles, '#minijogos');
});
