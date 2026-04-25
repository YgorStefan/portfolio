<section id="hero" class="min-h-screen flex items-center justify-center bg-bg-primary relative overflow-hidden pt-16">
    <div class="container mx-auto px-6 text-center">

        {{-- Foto de perfil --}}
        <div class="mb-6" data-aos="fade-down" data-aos-once="true">
            <img src="{{ asset('images/profile.jpg') }}"
                 alt="Ygor Stefankowski da Silva"
                 class="w-36 h-36 rounded-full object-cover border-4 border-accent mx-auto shadow-lg shadow-accent/20">
        </div>

        {{-- Nome --}}
        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-3"
            data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
            Ygor Stefankowski da Silva
        </h1>

        {{-- Cargo --}}
        <p class="text-xl md:text-2xl text-accent font-semibold mb-4"
           data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
            Analista de Sistemas e Desenvolvedor Full Stack
        </p>

        {{-- Slogan --}}
        <p class="text-gray-500 dark:text-gray-400 text-lg mb-10 max-w-xl mx-auto"
           data-aos="fade-up" data-aos-delay="300" data-aos-once="true">
            Criando soluções modernas com PHP, Laravel e JavaScript.
        </p>

        {{-- Botões de ação --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center"
             data-aos="fade-up" data-aos-delay="400" data-aos-once="true">
            <a href="#contact"
               class="inline-block bg-accent hover:bg-accent/90 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                Entre em Contato
            </a>
            <a href="#projects"
               class="inline-block border border-accent text-accent hover:bg-accent hover:text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                Ver Projetos
            </a>
        </div>

        {{-- Indicador de rolagem --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce"
             data-aos="fade-up" data-aos-delay="500" data-aos-once="true" data-aos-offset="0">
            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

    </div>
</section>
