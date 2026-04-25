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
                    <div class="shrink-0 w-11 h-11 rounded-xl bg-accent/15 flex items-center justify-center
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
                    <div class="absolute inset-0 rounded-2xl bg-linear-to-r from-accent/0 via-accent/5 to-accent/0
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
                             loading="lazy"
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
                               class="border border-[#707070] text-[#707070] dark:border-white dark:text-white hover:border-accent hover:text-accent
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
