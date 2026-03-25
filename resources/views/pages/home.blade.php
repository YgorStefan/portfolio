@extends('layouts.app')

@section('content')
    {{-- Phase 1: section stubs with correct IDs. Phase 2 fills content. --}}

    <section id="hero" class="min-h-screen flex items-center justify-center bg-bg-primary relative overflow-hidden pt-16">
        <div class="container mx-auto px-6 text-center">

            {{-- Profile photo -- HERO-02 --}}
            <div class="mb-6" data-aos="fade-down">
                <img src="{{ asset('images/profile.jpg') }}"
                     alt="Ygor Stefankowski da Silva"
                     class="w-36 h-36 rounded-full object-cover border-4 border-accent mx-auto shadow-lg shadow-accent/20">
            </div>

            {{-- Name -- HERO-01 --}}
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-3"
                data-aos="fade-up" data-aos-delay="100">
                Ygor Stefankowski da Silva
            </h1>

            {{-- Role -- HERO-01 --}}
            <p class="text-xl md:text-2xl text-accent font-semibold mb-4"
               data-aos="fade-up" data-aos-delay="200">
                Desenvolvedor Full Stack
            </p>

            {{-- Tagline --}}
            <p class="text-gray-400 text-lg mb-10 max-w-xl mx-auto"
               data-aos="fade-up" data-aos-delay="300">
                Criando soluções web modernas com PHP, Laravel e JavaScript.
            </p>

            {{-- CTA buttons -- HERO-03 --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center"
                 data-aos="fade-up" data-aos-delay="400">
                <a href="#contact"
                   class="inline-block bg-accent hover:bg-accent/90 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                    Entre em Contato
                </a>
                <a href="#projects"
                   class="inline-block border border-accent text-accent hover:bg-accent hover:text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                    Ver Projetos
                </a>
            </div>

            {{-- Scroll indicator --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce"
                 data-aos="fade-up" data-aos-delay="600">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

        </div>
    </section>

    <section id="about" class="py-24 bg-bg-primary">
        <div class="container mx-auto px-6">

            {{-- Section heading --}}
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Sobre Mim</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
            </div>

            {{-- Two-column layout: text left, photo right --}}
            <div class="flex flex-col lg:flex-row items-center gap-12 max-w-5xl mx-auto">

                {{-- Bio text column -- ABOUT-01 --}}
                <div class="flex-1" data-aos="fade-right">
                    <p class="text-gray-300 text-lg leading-relaxed mb-6">
                        Olá! Sou o Ygor, desenvolvedor full stack apaixonado por criar experiências
                        digitais modernas e funcionais. Com foco em PHP e Laravel no back-end e
                        JavaScript no front-end, transformo ideias em aplicações web robustas e
                        escaláveis.
                    </p>
                    <p class="text-gray-300 text-lg leading-relaxed mb-6">
                        Minha trajetória começou pela curiosidade em entender como as coisas funcionam
                        por baixo dos panos. Hoje trabalho com a stack completa — do banco de dados
                        à interface — sempre com atenção à qualidade do código e à experiência do usuário.
                    </p>
                    <p class="text-gray-300 text-lg leading-relaxed mb-10">
                        Estou em busca de oportunidades onde possa contribuir com soluções técnicas
                        sólidas e continuar crescendo como profissional.
                    </p>

                    {{-- CV download button -- ABOUT-03 --}}
                    <a href="{{ asset('files/curriculo.pdf') }}"
                       download="Curriculo-Ygor-Stefankowski.pdf"
                       class="inline-flex items-center gap-2 border border-accent text-accent hover:bg-accent hover:text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download CV
                    </a>
                </div>

                {{-- Profile photo column -- ABOUT-02 --}}
                <div class="flex-shrink-0" data-aos="fade-left">
                    <div class="relative">
                        <img src="{{ asset('images/profile.jpg') }}"
                             alt="Ygor Stefankowski da Silva"
                             class="w-64 h-64 rounded-2xl object-cover border-2 border-accent/30 shadow-xl shadow-accent/10">
                        {{-- Decorative accent border offset --}}
                        <div class="absolute -bottom-3 -right-3 w-full h-full border-2 border-accent/20 rounded-2xl -z-10"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="skills" class="py-24 bg-bg-card">
        <div class="container mx-auto px-6">

            {{-- Section heading --}}
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Habilidades</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
                <p class="text-gray-400 mt-4 max-w-xl mx-auto">
                    Tecnologias e ferramentas com as quais trabalho no dia a dia.
                </p>
            </div>

            {{-- Swiper carousel -- SKILL-01, SKILL-02, SKILL-03, SKILL-04 --}}
            {{-- Pagination is a sibling of .swiper (not inside it) to avoid absolute-position overlap --}}
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="swiper swiper-skills">
                    <div class="swiper-wrapper">
                        @foreach($skills as $skill)
                            <div class="swiper-slide">
                                <div class="bg-bg-primary border border-gray-800 rounded-xl p-6
                                            flex flex-col items-center gap-3
                                            hover:border-accent/50 hover:-translate-y-1
                                            transition-all duration-300 cursor-default">
                                    {{-- Devicon icon -- SKILL-02 --}}
                                    <i class="{{ $skill['icon'] }} text-5xl"></i>
                                    <span class="text-sm font-medium text-gray-300">{{ $skill['name'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Swiper pagination outside .swiper so it flows naturally below cards --}}
                <div class="swiper-pagination mt-6"></div>
            </div>

        </div>
    </section>

    <section id="projects" class="py-24 bg-bg-primary">
        <div class="container mx-auto px-6">

            {{-- Section heading --}}
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Projetos</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
                <p class="text-gray-400 mt-4 max-w-xl mx-auto">
                    Alguns dos projetos que desenvolvi — clique para ver o código ou a demo.
                </p>
            </div>

            {{-- Projects grid -- PROJ-01, PROJ-02 --}}
            {{-- 1 col mobile, 2 col tablet (md), 3 col desktop (lg) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($projects as $i => $project)
                    {{-- Card -- PROJ-03, PROJ-04 --}}
                    {{-- AOS stagger capped at 400ms to avoid long waits on large grids --}}
                    <div class="relative group overflow-hidden rounded-xl bg-bg-card border border-gray-800
                                hover:border-accent/30 transition-all duration-300 hover:-translate-y-1"
                         data-aos="fade-up"
                         data-aos-delay="{{ min($i * 100, 400) }}">

                        {{-- Project image with scale-on-hover -- PROJ-03 --}}
                        <div class="aspect-video bg-gray-800 overflow-hidden">
                            <img src="{{ asset('images/projects/' . $project['image']) }}"
                                 alt="{{ $project['title'] }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 onerror="this.style.display='none'">
                        </div>

                        {{-- Card body -- PROJ-03 --}}
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-white mb-2">{{ $project['title'] }}</h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ $project['description'] }}</p>

                            {{-- Tech tags -- PROJ-03 --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach($project['tags'] as $tag)
                                    <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20
                                                 px-2 py-1 rounded-md">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Hover overlay with demo + repo links -- PROJ-04 --}}
                        <div class="absolute inset-0 bg-bg-primary/90 opacity-0 group-hover:opacity-100
                                    transition-opacity duration-300 flex items-center justify-center gap-4">
                            @if($project['url'])
                                <a href="{{ $project['url'] }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="bg-accent hover:bg-accent/90 text-white px-5 py-2.5 rounded-lg
                                          text-sm font-semibold transition-colors duration-300">
                                    Demo
                                </a>
                            @endif
                            @if($project['repo'])
                                <a href="{{ $project['repo'] }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="border border-white text-white hover:border-accent hover:text-accent
                                          px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors duration-300">
                                    Repositório
                                </a>
                            @endif
                            @if(!$project['url'] && !$project['repo'])
                                <span class="text-gray-400 text-sm">Em breve</span>
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
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Contato</h2>
                <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
                <p class="text-gray-400 mt-4 max-w-xl mx-auto">
                    Tem um projeto em mente ou quer bater um papo? Manda uma mensagem!
                </p>
            </div>

            <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                {{-- Contact form -- CONTACT-01 (UI only; backend wired in Phase 3) --}}
                <div data-aos="fade-right">
                    {{-- NOTE: action="" is intentionally empty. Phase 3 adds action="{{ route('contact.send') }}" --}}
                    {{-- NOTE: Phase 3 also adds @csrf and method="POST" --}}
                    <form action="" method="POST" class="space-y-6" id="contact-form">

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                Nome
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   placeholder="Seu nome completo"
                                   class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                          text-white placeholder-gray-500
                                          focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                          transition-colors duration-300">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                E-mail
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   placeholder="seu@email.com"
                                   class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                          text-white placeholder-gray-500
                                          focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                          transition-colors duration-300">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">
                                Assunto
                            </label>
                            <input type="text"
                                   id="subject"
                                   name="subject"
                                   placeholder="Sobre o que você quer falar?"
                                   class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                          text-white placeholder-gray-500
                                          focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                          transition-colors duration-300">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">
                                Mensagem
                            </label>
                            <textarea id="message"
                                      name="message"
                                      rows="5"
                                      placeholder="Escreva sua mensagem aqui..."
                                      class="w-full bg-bg-primary border border-gray-700 rounded-lg px-4 py-3
                                             text-white placeholder-gray-500 resize-none
                                             focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent
                                             transition-colors duration-300"></textarea>
                        </div>

                        {{-- Submit button — Phase 3 will disable this on submission --}}
                        <button type="submit"
                                class="w-full bg-accent hover:bg-accent/90 text-white font-semibold
                                       py-3 px-6 rounded-lg transition-all duration-300 hover:-translate-y-0.5
                                       focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-bg-card">
                            Enviar Mensagem
                        </button>

                    </form>
                </div>

                {{-- Social links -- CONTACT-06 --}}
                <div class="space-y-8" data-aos="fade-left">

                    <div>
                        <h3 class="text-xl font-bold text-white mb-6">Onde me encontrar</h3>
                        <div class="space-y-4">

                            {{-- GitHub --}}
                            <a href="https://github.com/ygor-stefankowski"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <i class="devicon-github-plain text-2xl"></i>
                                </span>
                                <div>
                                    <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">GitHub</p>
                                    <p class="text-sm">github.com/ygor-stefankowski</p>
                                </div>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://linkedin.com/in/ygor-stefankowski"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <i class="devicon-linkedin-plain colored text-2xl"></i>
                                </span>
                                <div>
                                    <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">LinkedIn</p>
                                    <p class="text-sm">linkedin.com/in/ygor-stefankowski</p>
                                </div>
                            </a>

                            {{-- WhatsApp --}}
                            <a href="https://wa.me/55XXXXXXXXXXX"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">WhatsApp</p>
                                    <p class="text-sm">Clique para conversar</p>
                                </div>
                            </a>

                            {{-- Email --}}
                            <a href="mailto:ygor@example.com"
                               class="flex items-center gap-4 text-gray-400 hover:text-accent transition-colors duration-300 group">
                                <span class="w-12 h-12 bg-bg-primary rounded-xl flex items-center justify-center
                                             border border-gray-700 group-hover:border-accent/50 transition-colors duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium text-white group-hover:text-accent transition-colors duration-300">E-mail</p>
                                    <p class="text-sm">ygor@example.com</p>
                                </div>
                            </a>

                        </div>
                    </div>

                    {{-- Availability note --}}
                    <div class="bg-bg-primary rounded-xl p-6 border border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></span>
                            <span class="text-white font-medium">Disponível para novas oportunidades</span>
                        </div>
                        <p class="text-gray-400 text-sm">
                            Estou aberto a propostas de emprego CLT, PJ ou freela. Respondo em até 24h.
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
