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
            {{-- .swiper-skills selector must match new Swiper('.swiper-skills') in app.js --}}
            <div class="swiper swiper-skills overflow-hidden" data-aos="fade-up" data-aos-delay="100">
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
                {{-- Swiper pagination -- SKILL-04 --}}
                <div class="swiper-pagination mt-8"></div>
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

    <section id="contact" class="min-h-screen flex items-center justify-center">
        <p class="text-gray-400 text-sm">Contato — Phase 2</p>
    </section>
@endsection
