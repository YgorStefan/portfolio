/**
 * i18n – client-side language switcher (PT-BR ↔ EN)
 *
 * Usage:
 *   - Static text: add data-i18n="key" to the element
 *   - Placeholder:  add data-i18n-placeholder="key"
 *   - Alpine x-text: use $store.lang.t('key') or the translations object directly
 */

const translations = {
    // ── Nav ──
    'nav.about': { pt: 'Sobre', en: 'About' },
    'nav.skills': { pt: 'Habilidades', en: 'Skills' },
    'nav.projects': { pt: 'Projetos', en: 'Projects' },
    'nav.minigames': { pt: 'Minijogos', en: 'Mini Games' },
    'nav.contact': { pt: 'Contato', en: 'Contact' },

    // ── Hero ──
    'hero.role': { pt: 'Analista de Sistemas e Desenvolvedor Full Stack', en: 'Systems Analyst & Full Stack Developer' },
    'hero.slogan': { pt: 'Criando soluções modernas com PHP, Laravel e JavaScript.', en: 'Building modern solutions with PHP, Laravel and JavaScript.' },
    'hero.cta': { pt: 'Entre em Contato', en: 'Get in Touch' },
    'hero.projects': { pt: 'Ver Projetos', en: 'View Projects' },

    // ── About ──
    'about.title': { pt: 'Sobre Mim', en: 'About Me' },
    'about.p1': {
        pt: 'Bom dia, boa tarde, boa noite! Sou o Ygor, analista de sistemas e desenvolvedor full stack apaixonado por criar experiências digitais modernas e funcionais há mais de 10 anos. Com amplo conhecimento em PHP, Laravel e JavaScript, reuno e transformo ideias em aplicações robustas e escaláveis seguindo a arquitetura MVC.',
        en: 'Good morning, good afternoon, good evening! I\'m Ygor, a systems analyst and full stack developer passionate about creating modern and functional digital experiences for over 10 years. With extensive knowledge in PHP, Laravel and JavaScript, I gather and transform ideas into robust and scalable applications following the MVC architecture.'
    },
    'about.p2': {
        pt: 'Minha trajetória começou pela curiosidade em entender como as coisas funcionam por baixo dos panos, sempre com um perfil autodidata. Hoje trabalho com a stack completa, do banco de dados (MySQL, PostgreSQL) à interface (HTML, CSS, JavaScript, Tailwind CSS, Vue.js, etc.), sempre prezando pela qualidade do código e experiência do usuário.',
        en: 'My journey started with the curiosity to understand how things work under the hood, always with a self-taught mindset. Today I work with the full stack, from databases (MySQL, PostgreSQL) to the interface (HTML, CSS, JavaScript, Tailwind CSS, Vue.js, etc.), always prioritizing code quality and user experience.'
    },
    'about.p3': {
        pt: 'Sempre estou em busca de novas oportunidades onde possa contribuir com soluções técnicas, sólidas, escaláveis e continuar evoluindo como pessoa e profissional.',
        en: 'I\'m always looking for new opportunities where I can contribute with solid, scalable technical solutions and continue evolving as a person and professional.'
    },
    'about.cv': { pt: 'Baixar Currículo', en: 'Download Resume' },

    // ── Skills ──
    'skills.title': { pt: 'Habilidades', en: 'Skills' },
    'skills.subtitle': {
        pt: 'Tecnologias e ferramentas com as quais trabalho no dia a dia.',
        en: 'Technologies and tools I work with on a daily basis.'
    },
    'skills.all': { pt: 'Todos', en: 'All' },
    'skills.backend': { pt: 'Backend', en: 'Backend' },
    'skills.frontend': { pt: 'Frontend', en: 'Frontend' },
    'skills.devops': { pt: 'DevOps', en: 'DevOps' },

    // ── Projects ──
    'projects.title': { pt: 'Projetos', en: 'Projects' },
    'projects.subtitle': {
        pt: 'Alguns dos projetos que desenvolvi ou estou desenvolvendo, clique para ver o código ou a demo.',
        en: 'Some of the projects I\'ve built or am currently building - click to see the code or demo.'
    },
    'projects.restricted': {
        pt: 'Para uma experiência completa e testes de funcionalidades restritas,',
        en: 'For a complete experience and testing of restricted features,'
    },
    'projects.ask_login': { pt: 'peça o login e senha', en: 'request login credentials' },
    'projects.repo': { pt: 'Repositório', en: 'Repository' },

    // ── Project descriptions (from JSON) ──
    'project.cdp.desc': {
        pt: 'Aplicação React para gerenciamento de produtos organizados por marcas, com drawer lateral para formulários, cores personalizadas por marca e persistência via localStorage.',
        en: 'React application for product management organized by brands, with side drawer for forms, custom colors per brand and localStorage persistence.'
    },
    'project.crm.desc': {
        pt: 'Sistema empresarial de gestão de clientes com kanban, usando PHP, MySQL, Chart.js, Tailwind e JavaScript.',
        en: 'Enterprise customer management system with kanban, using PHP, MySQL, Chart.js, Tailwind and JavaScript.'
    },
    'project.ecommerce.desc': {
        pt: 'Plataforma e-commerce full stack com Next.js, NestJS e PostgreSQL.',
        en: 'Full stack e-commerce platform with Next.js, NestJS and PostgreSQL.'
    },
    'project.eduflow.desc': {
        pt: 'Sistema de retenção e operação de alunos do checkout ao portal, com detecção automática de churn.',
        en: 'Student retention and operations system from checkout to portal, with automatic churn detection.'
    },
    'project.portfolio.desc': {
        pt: 'Site desse portfólio desenvolvido com Laravel 12, Tailwind CSS v4 e Alpine.js. Dark theme com animações AOS e carrossel Swiper para exibição das minhas habilidades.',
        en: 'This portfolio website built with Laravel 12, Tailwind CSS v4 and Alpine.js. Dark theme with AOS animations and Swiper carousel for showcasing my skills.'
    },
    'project.cvtranslator.desc': {
        pt: 'Ferramenta gratuita para traduzir documentos Word (.docx) para o inglês preservando a formatação original, com exportação para PDF direto pelo navegador.',
        en: 'Free tool to translate Word (.docx) resumes to English while preserving the original formatting, with PDF export directly from the browser.'
    },

    // ── Minijogos ──
    'minigames.title': { pt: 'Minijogos', en: 'Mini Games' },
    'minigames.subtitle': {
        pt: 'Jogos construídos por mim com stacks diferentes para demonstrar minha versatilidade no Front-end. Cada um foi desenvolvido do zero com suas próprias tecnologias.',
        en: 'Games built by me with different stacks to demonstrate my front-end versatility. Each one was developed from scratch with its own technologies.'
    },

    // Memory game
    'game.memory.title': { pt: 'Jogo da memória Tech', en: 'Tech Memory Game' },
    'game.memory.desc': {
        pt: 'Jogo da memória com logos de tecnologias. Animação de flip em CSS puro, cronômetro e contador de tentativas.',
        en: 'Memory game with tech logos. Pure CSS flip animation, timer and attempt counter.'
    },
    'game.play': { pt: '▶ Jogar', en: '▶ Play' },
    'game.howto': { pt: 'Como Jogar', en: 'How to Play' },
    'game.memory.t1': { pt: 'Clique em uma carta para virá-la.', en: 'Click a card to flip it.' },
    'game.memory.t2': { pt: 'Clique em outra carta para tentar combiná-la.', en: 'Click another card to try to match it.' },
    'game.memory.t3': { pt: 'Se os logos forem iguais, o par é encontrado!', en: 'If the logos match, the pair is found!' },
    'game.memory.t4': { pt: 'Continue até combinar todos os pares.', en: 'Continue until all pairs are matched.' },
    'game.memory.t5': { pt: 'Tente finalizar com menos tentativas e no menor tempo.', en: 'Try to finish with fewer attempts and less time.' },

    // Wordle
    'game.wordle.desc': {
        pt: 'Clone do Wordle com palavras do universo tech. Teclado virtual, validação de letras e histórico salvo no LocalStorage.',
        en: 'Wordle clone with tech words. Virtual keyboard, letter validation and history saved in LocalStorage.'
    },
    'game.wordle.t1': { pt: 'Adivinhe a palavra tech em até 6 tentativas.', en: 'Guess the tech word in up to 6 attempts.' },
    'game.wordle.t2': { pt: 'Digite uma palavra e pressione', en: 'Type a word and press' },
    'game.wordle.t3': { pt: 'Letra certa no lugar certo.', en: 'Right letter in the right place.' },
    'game.wordle.t4': { pt: 'Letra certa, lugar errado.', en: 'Right letter, wrong place.' },
    'game.wordle.t5': { pt: 'Letra não está na palavra.', en: 'Letter is not in the word.' },

    // Dino
    'game.dino.title': { pt: 'Fuga do Dino', en: 'Dino Escape' },
    'game.dino.desc': {
        pt: 'Endless runner em Canvas puro com OOP, detecção de colisão AABB e velocidade progressiva. Pule com Espaço ou toque.',
        en: 'Endless runner in pure Canvas with OOP, AABB collision detection and progressive speed. Jump with Space or touch.'
    },
    'game.dino.t1': { pt: 'O dinossauro corre automaticamente.', en: 'The dinosaur runs automatically.' },
    'game.dino.t2': { pt: 'Pressione', en: 'Press' },
    'game.dino.t2b': { pt: 'ou toque na tela para pular.', en: 'or tap the screen to jump.' },
    'game.dino.t3': { pt: 'Evite os bugs que aparecem pelo caminho.', en: 'Avoid the bugs that appear along the way.' },
    'game.dino.t4': { pt: 'A velocidade aumenta com o tempo.', en: 'Speed increases over time.' },
    'game.dino.t5': { pt: 'O jogo termina ao colidir com um bug.', en: 'The game ends when you collide with a bug.' },

    // Space Defense
    'game.space.title': { pt: 'Defesa Espacial', en: 'Space Defense' },
    'game.space.desc': {
        pt: 'Aliens caem com comandos de terminal. Digite o comando correto para destruí-los antes que cheguem ao servidor.',
        en: 'Aliens fall with terminal commands. Type the correct command to destroy them before they reach the server.'
    },
    'game.space.t1': { pt: 'Aliens com comandos de terminal caem do céu.', en: 'Aliens with terminal commands fall from the sky.' },
    'game.space.t2': { pt: 'Digite o comando exato que aparece no alien.', en: 'Type the exact command shown on the alien.' },
    'game.space.t3': { pt: 'Pressione', en: 'Press' },
    'game.space.t3b': { pt: 'para destruí-lo.', en: 'to destroy it.' },
    'game.space.t4': { pt: 'Não deixe nenhum alien chegar ao servidor.', en: 'Don\'t let any alien reach the server.' },
    'game.space.t5': { pt: 'Quanto mais rápido você digitar, mais pontos ganha.', en: 'The faster you type, the more points you earn.' },

    // ── Contact ──
    'contact.title': { pt: 'Contato', en: 'Contact' },
    'contact.subtitle': { pt: 'Tem um projeto em mente? Me mande uma mensagem!', en: 'Have a project in mind? Send me a message!' },
    'contact.name': { pt: 'Nome', en: 'Name' },
    'contact.name_ph': { pt: 'Seu nome completo', en: 'Your full name' },
    'contact.email': { pt: 'E-mail', en: 'Email' },
    'contact.subject': { pt: 'Assunto', en: 'Subject' },
    'contact.subject_ph': { pt: 'Sobre o que você quer falar?', en: 'What would you like to talk about?' },
    'contact.message': { pt: 'Mensagem', en: 'Message' },
    'contact.message_ph': { pt: 'Escreva sua mensagem aqui...', en: 'Write your message here...' },
    'contact.send': { pt: 'Enviar Mensagem', en: 'Send Message' },
    'contact.sending': { pt: 'Enviando...', en: 'Sending...' },
    'contact.errors': { pt: 'Por favor, corrija os erros abaixo.', en: 'Please fix the errors below.' },
    'contact.find_me': { pt: 'Onde me encontrar:', en: 'Where to find me:' },
    'contact.available': { pt: 'Disponível para novas oportunidades', en: 'Available for new opportunities' },
    'contact.available_desc': {
        pt: 'Estou aberto a propostas de emprego CLT, PJ ou projetos de curto prazo. Respondo em até 24h.',
        en: 'I\'m open to full-time, contract, or freelance opportunities. I respond within 24h.'
    },

    // ── Footer ──
    'footer.rights': { pt: 'Todos os direitos reservados.', en: 'All rights reserved.' },
};

/* ─── helpers ─── */

function getLang() {
    return localStorage.getItem('lang') || 'pt';
}

function setLang(lang) {
    localStorage.setItem('lang', lang);
    document.documentElement.lang = lang === 'pt' ? 'pt-BR' : 'en';
    applyTranslations(lang);
    // Dispatch custom event so Alpine reactive components can update
    window.dispatchEvent(new CustomEvent('lang-changed', { detail: { lang } }));
}

function t(key) {
    const entry = translations[key];
    if (!entry) return key;
    return entry[getLang()] || entry.pt || key;
}

function applyTranslations(lang) {
    // data-i18n  → textContent
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        const entry = translations[key];
        if (entry) el.textContent = entry[lang];
    });

    // data-i18n-placeholder → placeholder attribute
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
        const key = el.getAttribute('data-i18n-placeholder');
        const entry = translations[key];
        if (entry) el.placeholder = entry[lang];
    });

    // data-i18n-html → innerHTML (for mixed content with inline elements)
    document.querySelectorAll('[data-i18n-html]').forEach(el => {
        const key = el.getAttribute('data-i18n-html');
        const entry = translations[key];
        if (entry) el.innerHTML = entry[lang];
    });
}

/* ─── exports ─── */
export { translations, getLang, setLang, t, applyTranslations };
