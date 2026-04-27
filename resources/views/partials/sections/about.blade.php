<section id="about" class="py-24 bg-bg-primary relative overflow-hidden">
    <div class="container mx-auto px-6">

        {{-- Título da seção --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4" data-i18n="about.title">Sobre Mim</h2>
            <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
        </div>

        {{-- Layout em duas colunas --}}
        <div class="flex flex-col lg:flex-row items-center gap-12 max-w-5xl mx-auto">

            {{-- Texto bio --}}
            <div class="flex-1" data-aos="fade-right">
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-6" data-i18n="about.p1">
                    Bom dia, boa tarde, boa noite! Sou o Ygor, analista de sistemas e desenvolvedor full stack
                    apaixonado por criar experiências digitais modernas e funcionais há mais de 10 anos. Com
                    amplo conhecimento em PHP, Laravel e JavaScript, reuno e transformo ideias em aplicações
                    robustas e escaláveis seguindo a arquitetura MVC.
                </p>
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-6" data-i18n="about.p2">
                    Minha trajetória começou pela curiosidade em entender como as coisas funcionam
                    por baixo dos panos, sempre com um perfil autodidata. Hoje trabalho com a stack completa,
                    do banco de dados (MySQL, PostgreSQL) à interface (HTML, CSS, JavaScript, Vue.js),
                    sempre prezando pela qualidade do código e experiência do usuário.
                </p>
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-10" data-i18n="about.p3">
                    Sempre estou em busca de novas oportunidades onde possa contribuir com soluções técnicas,
                    sólidas, escaláveis e continuar evoluindo como pessoa e profissional.
                </p>

                {{-- Download do CV --}}
                <a href="{{ asset('files/Currículo Ygor Stefankowski da Silva.pdf') }}"
                   download="Curriculo-Ygor-Stefankowski-da-Silva.pdf"
                   class="inline-flex items-center gap-2 border border-accent text-accent hover:bg-accent hover:text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span data-i18n="about.cv">Download CV</span>
                </a>
            </div>

            {{-- Coluna da foto --}}
            <div class="shrink-0" data-aos="fade-left">
                <div class="relative">
                    <img src="{{ asset('images/cartoon.jpeg') }}"
                         alt="Ygor Stefankowski da Silva"
                         width="160"
                         class="w-40 rounded-2xl object-contain border-2 border-accent/30 shadow-xl shadow-accent/10">
                    {{-- Borda decorativa --}}
                    <div class="absolute -bottom-3 -right-3 w-full h-full border-2 border-accent/20 rounded-2xl -z-10"></div>
                </div>
            </div>

        </div>
    </div>
</section>
