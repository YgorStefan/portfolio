import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { ParticleCanvas } from './particles.js';

Alpine.plugin(intersect);
window.Alpine = Alpine;

Alpine.data('skillsGrid', (skills) => ({
    skills,
    cat: 'all',
    page: 0,
    perPage: 8,
    autoMs: 4500,
    timer: null,
    cardsVisible: true,

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

    init() {
        this.scheduleAuto();
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
        this.scheduleAuto();
    },

    goTo(p) {
        this.page = Math.max(0, Math.min(p, this.totalPages - 1));
        this.showCards();
        this.scheduleAuto();
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

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 700,
        once: false,
        mirror: true,
        offset: 80,
    });

    // Partículas interativas — D-11: instanciado 3x a partir de módulo único
    new ParticleCanvas('#hero');
    new ParticleCanvas('#about');
    new ParticleCanvas('#projects');
    new ParticleCanvas('#minijogos');
});
