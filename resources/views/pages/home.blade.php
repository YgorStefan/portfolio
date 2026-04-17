@extends('layouts.app')

@section('content')
    {{-- Seções principais --}}

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
                 data-aos="fade-up" data-aos-delay="600" data-aos-once="true">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

        </div>
    </section>

    <section id="about" class="py-24 bg-bg-primary relative overflow-hidden">
        <div class="container mx-auto px-6">

            {{-- Título da seção --}}
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Sobre Mim</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
            </div>

            {{-- Layout em duas colunas --}}
            <div class="flex flex-col lg:flex-row items-center gap-12 max-w-5xl mx-auto">

                {{-- Texto bio --}}
                <div class="flex-1" data-aos="fade-right">
                    <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        Bom dia, boa tarde, boa noite! Sou o Ygor, analista de sistemas e desenvolvedor full stack 
                        apaixonado por criar experiências digitais modernas e funcionais há mais de 10 anos. Com 
                        amplo conhecimento em PHP, Laravel e JavaScript, reuno e transformo ideias em aplicações
                        robustas e escaláveis seguindo a arquitetura MVC.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        Minha trajetória começou pela curiosidade em entender como as coisas funcionam
                        por baixo dos panos, sempre com um perfil autodidata. Hoje trabalho com a stack completa, 
                        do banco de dados (MySQL, PostgreSQL) à interface (HTML, CSS, JavaScript, Vue.js), 
                        sempre prezando pela qualidade do código e experiência do usuário.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-10">
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
                        Download CV
                    </a>
                </div>

                {{-- Coluna da foto --}}
                <div class="flex-shrink-0" data-aos="fade-left">
                    <div class="relative">
                        <img src="{{ asset('images/cartoon.jpeg') }}"
                             alt="Ygor Stefankowski da Silva"
                             class="w-40 rounded-2xl object-contain border-2 border-accent/30 shadow-xl shadow-accent/10">
                        {{-- Borda decorativa --}}
                        <div class="absolute -bottom-3 -right-3 w-full h-full border-2 border-accent/20 rounded-2xl -z-10"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="skills" class="py-24 bg-bg-card">
        <div class="container mx-auto px-6">

            {{-- Título da seção --}}
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Habilidades</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
                <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl mx-auto">
                    Tecnologias e ferramentas com as quais trabalho no dia a dia.
                </p>
            </div>

            {{-- Carrossel de habilidades --}}
            <div class="relative overflow-hidden md:overflow-visible" data-aos="fade-up" data-aos-delay="100">
                <button class="swiper-skills-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10
                               bg-gray-200 dark:bg-gray-800 hover:bg-accent border border-gray-300 dark:border-gray-700 hover:border-accent
                               text-gray-700 dark:text-white rounded-full w-9 h-9 flex items-center justify-center
                               transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="swiper-skills-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10
                               bg-gray-200 dark:bg-gray-800 hover:bg-accent border border-gray-300 dark:border-gray-700 hover:border-accent
                               text-gray-700 dark:text-white rounded-full w-9 h-9 items-center justify-center
                               transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                <div class="swiper swiper-skills">
                    <div class="swiper-wrapper">
                        @foreach($skills as $skill)
                            <div class="swiper-slide">
                                <div class="bg-bg-primary border border-gray-200 dark:border-gray-800 rounded-xl p-6
                                            flex flex-col items-center gap-3
                                            hover:border-accent/50 hover:shadow-md hover:shadow-accent/20
                                            transition-all duration-300 cursor-default">
                                    {{-- Ícone: SVG inline para IA/ML, Devicon para demais --}}
                                    @if($skill['name'] === 'IA/ML')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" viewBox="0 0 24 24" fill="none"
                                             stroke="#a855f7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                             aria-hidden="true">
                                            <path d="M9.5 2a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z"/>
                                            <path d="M14.5 2a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z"/>
                                            <path d="M12 9.5V12"/>
                                            <path d="M9.5 7v2.5"/>
                                            <path d="M14.5 7v2.5"/>
                                            <path d="M5 12a7 7 0 0 0 14 0"/>
                                            <path d="M5 12H3"/>
                                            <path d="M19 12h2"/>
                                            <path d="M12 19v2"/>
                                            <path d="M8.5 17.5l-1.5 1.5"/>
                                            <path d="M15.5 17.5l1.5 1.5"/>
                                        </svg>
                                    @else
                                        <i class="{{ $skill['icon'] }} text-5xl"></i>
                                    @endif
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ $skill['name'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="projects" class="py-24 bg-bg-primary relative overflow-hidden">
        <div class="container mx-auto px-6">

            {{-- Título da seção --}}
            <div class="text-center mb-10" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Projetos</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
                <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl mx-auto">
                    Alguns dos projetos que desenvolvi ou estou desenvolvendo, clique para ver o código ou a demo.
                </p>

                {{-- Banner de acesso restrito --}}
                <div class="max-w-2xl mx-auto mt-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative inline-flex items-center gap-4 bg-accent/5 border border-accent/30 rounded-2xl px-6 py-4
                                hover:border-accent/60 hover:bg-accent/10 transition-all duration-300 group">

                        {{-- Ícone de cadeado --}}
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-accent/15 flex items-center justify-center
                                    group-hover:bg-accent/25 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-accent" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>

                        {{-- Texto --}}
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                            Para uma experiência completa e testes de funcionalidades restritas,
                            <a href="#contact"
                               onclick="setTimeout(() => { document.getElementById('name').focus() }, 50)"
                               class="font-semibold text-accent hover:underline underline-offset-2 transition-all duration-200">
                                peça o login e senha
                            </a>.
                        </p>

                        {{-- Brilho decorativo --}}
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-accent/0 via-accent/5 to-accent/0
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    </div>
                </div>
            </div>

            {{-- Grade de projetos --}}
            {{-- Grid responsivo --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($projects as $i => $project)
                    {{-- Card do projeto --}}
                    {{-- Delay do AOS --}}
                    <div class="relative group overflow-hidden rounded-xl bg-bg-card border border-gray-200 dark:border-gray-800
                                hover:border-accent/30 transition-all duration-300 hover:-translate-y-1"
                         data-aos="fade-up"
                         data-aos-delay="{{ min($i * 100, 400) }}">

                        {{-- Imagem do projeto --}}
                        <div class="aspect-video bg-gray-200 dark:bg-gray-800 overflow-hidden">
                            <img src="{{ asset('images/' . $project['image']) }}"
                                 alt="{{ $project['title'] }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'450\' viewBox=\'0 0 800 450\'%3E%3Crect width=\'800\' height=\'450\' fill=\'%231e293b\'/%3E%3Ctext x=\'400\' y=\'225\' font-family=\'monospace\' font-size=\'14\' fill=\'%2338bdf8\' text-anchor=\'middle\' dominant-baseline=\'middle\'%3E%3C%2Fprojeto%3E%3C%2Ftext%3E%3C%2Fsvg%3E'">
                        </div>

                        {{-- Corpo do card --}}
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $project['title'] }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-4">{{ $project['description'] }}</p>

                            {{-- Tags de tecnologia --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach($project['tags'] as $tag)
                                    <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20
                                                 px-2 py-1 rounded-md">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Overlay de links --}}
                        <div class="absolute inset-0 bg-bg-primary/90 opacity-0 group-hover:opacity-100
                                    transition-opacity duration-300 flex items-center justify-center gap-4">
                            @if($project['url'])
                                <a href="{{ $project['url'] }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="bg-accent hover:bg-accent/90 text-white px-5 py-2.5 rounded-lg
                                          text-sm font-semibold transition-colors duration-300">
                                    Demo
                                </a>
                            @else
                                <span class="bg-accent/40 text-white/60 px-5 py-2.5 rounded-lg
                                             text-sm font-semibold cursor-not-allowed">
                                    Demo
                                </span>
                            @endif
                            @if($project['repo'])
                                <a href="{{ $project['repo'] }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="border border-white text-white hover:border-accent hover:text-accent
                                          px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors duration-300">
                                    Repositório
                                </a>
                            @endif
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <section id="contact" class="py-24 bg-bg-card">
        <div class="container mx-auto px-6">

            {{-- Section heading --}}
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Contato</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
                <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl mx-auto">
                    Tem um projeto em mente? Me mande uma mensagem!
                </p>
            </div>

            <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                {{-- Formulário de contato --}}
                <div data-aos="fade-right">
                    <form action="{{ route('contact.send') }}"
                          method="POST"
                          class="space-y-6"
                          id="contact-form"
                          x-data="{ submitting: false }"
                          @submit="submitting = true">
                        @csrf

                        {{-- Banner de sucesso --}}
                        @if(session('success'))
                            <div class="bg-green-900/30 border border-green-500/30 text-green-400 rounded-lg px-4 py-3 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Banner de erro --}}
                        @if(session('error'))
                            <div class="bg-red-900/30 border border-red-500/30 text-red-400 rounded-lg px-4 py-3 text-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Erros de validação --}}
                        @if($errors->any())
                            <div class="bg-red-900/30 border border-red-500/30 text-red-400 rounded-lg px-4 py-3 text-sm">
                                Por favor, corrija os erros abaixo.
                            </div>
                        @endif

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                                Nome
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   autocomplete="name"
                                   value="{{ old('name') }}"
                                   placeholder="Seu nome completo"
                                   class="w-full bg-bg-primary border rounded-lg px-4 py-3
                                          text-gray-900 dark:text-white placeholder-gray-500
                                          focus:outline-none focus:ring-1 transition-colors duration-300
                                          @error('name') border-red-500 focus:border-red-500 focus:ring-red-500
                                          @else border-gray-300 dark:border-gray-700 focus:border-accent focus:ring-accent @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                                E-mail
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   autocomplete="email"
                                   value="{{ old('email') }}"
                                   placeholder="seu@email.com"
                                   class="w-full bg-bg-primary border rounded-lg px-4 py-3
                                          text-gray-900 dark:text-white placeholder-gray-500
                                          focus:outline-none focus:ring-1 transition-colors duration-300
                                          @error('email') border-red-500 focus:border-red-500 focus:ring-red-500
                                          @else border-gray-300 dark:border-gray-700 focus:border-accent focus:ring-accent @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                                Assunto
                            </label>
                            <input type="text"
                                   id="subject"
                                   name="subject"
                                   autocomplete="off"
                                   value="{{ old('subject') }}"
                                   placeholder="Sobre o que você quer falar?"
                                   class="w-full bg-bg-primary border rounded-lg px-4 py-3
                                          text-gray-900 dark:text-white placeholder-gray-500
                                          focus:outline-none focus:ring-1 transition-colors duration-300
                                          @error('subject') border-red-500 focus:border-red-500 focus:ring-red-500
                                          @else border-gray-300 dark:border-gray-700 focus:border-accent focus:ring-accent @enderror">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                                Mensagem
                            </label>
                            <textarea id="message"
                                      name="message"
                                      rows="5"
                                      autocomplete="off"
                                      placeholder="Escreva sua mensagem aqui..."
                                      class="w-full bg-bg-primary border rounded-lg px-4 py-3
                                             text-gray-900 dark:text-white placeholder-gray-500 resize-none
                                             focus:outline-none focus:ring-1 transition-colors duration-300
                                             @error('message') border-red-500 focus:border-red-500 focus:ring-red-500
                                             @else border-gray-300 dark:border-gray-700 focus:border-accent focus:ring-accent @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                :disabled="submitting"
                                class="w-full bg-accent hover:bg-accent/90 text-white font-semibold
                                       py-3 px-6 rounded-lg transition-all duration-300 hover:-translate-y-0.5
                                       focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-bg-card
                                       disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                                x-text="submitting ? 'Enviando...' : 'Enviar Mensagem'">
                            Enviar Mensagem
                        </button>

                    </form>
                </div>

                {{-- Links sociais --}}
                <div class="space-y-8" data-aos="fade-left">

                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Onde me encontrar:</h3>
                        <div class="space-y-4">

                            {{-- GitHub --}}
                            <a href="https://github.com/YgorStefan"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 text-gray-500 dark:text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-300 dark:border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <i class="devicon-github-plain text-2xl"></i>
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-accent transition-colors duration-300">GitHub</p>
                                    <p class="text-sm">github.com/YgorStefan</p>
                                </div>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/in/ygor-stefan/"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 text-gray-500 dark:text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-300 dark:border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <i class="devicon-linkedin-plain text-2xl text-gray-400 group-hover:text-accent transition-colors duration-300"></i>
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-accent transition-colors duration-300">LinkedIn</p>
                                    <p class="text-sm">linkedin.com/in/ygor-stefan</p>
                                </div>
                            </a>

                            {{-- WhatsApp --}}
                            <a href="https://wa.me/5541996200546"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 text-gray-500 dark:text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-300 dark:border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-accent transition-colors duration-300">WhatsApp</p>
                                    <p class="text-sm">(41) 99620-0546</p>
                                </div>
                            </a>

                            {{-- E-mail --}}
                            <a href="#contact" onclick="setTimeout(() => { document.getElementById('name').focus() }, 50)"
                               class="flex items-center gap-4 text-gray-500 dark:text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-300 dark:border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-accent transition-colors duration-300">E-mail</p>
                                    <p class="text-sm">ygor.stefan@gmail.com</p>
                                </div>
                            </a>

                        </div>
                    </div>

                    {{-- Disponibilidade --}}
                    <div class="bg-bg-primary rounded-xl p-6 border border-gray-300 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></span>
                            <span class="text-gray-900 dark:text-white font-medium">Disponível para novas oportunidades</span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            Estou aberto a propostas de emprego CLT, PJ ou projetos de curto prazo. Respondo em até 24h.
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
