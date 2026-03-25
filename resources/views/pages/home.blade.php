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

    <section id="about" class="min-h-screen flex items-center justify-center">
        <p class="text-gray-400 text-sm">Sobre — Phase 2</p>
    </section>

    <section id="skills" class="min-h-screen flex items-center justify-center">
        <p class="text-gray-400 text-sm">Skills — Phase 2</p>
    </section>

    <section id="projects" class="min-h-screen flex items-center justify-center">
        <p class="text-gray-400 text-sm">Projetos — Phase 2</p>
    </section>

    <section id="contact" class="min-h-screen flex items-center justify-center">
        <p class="text-gray-400 text-sm">Contato — Phase 2</p>
    </section>
@endsection
