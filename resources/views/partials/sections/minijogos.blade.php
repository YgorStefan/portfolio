{{-- Seção de Minijogos --}}
<section id="minijogos" class="py-24 bg-bg-primary relative overflow-hidden">
    <div class="container mx-auto px-6">

        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Minijogos</h2>
            <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
            <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl mx-auto">
                Jogos construídos por mim com stacks diferentes para demonstrar minha versatilidade no Front-end.
                Cada um foi desenvolvido do zero com suas próprias tecnologias.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Jogo da memória Tech --}}
            <div class="bg-bg-card rounded-xl border border-gray-200 dark:border-gray-800 p-6
                        hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                 data-aos="fade-up" data-aos-delay="0"
                 x-data="{ tutorial: false }">
                <div class="text-3xl mb-3">🃏</div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Jogo da memória Tech</h3>
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach(['Vue 3', 'Vite', 'CSS Puro'] as $tag)
                        <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                    @endforeach
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                    Jogo da memória com logos de tecnologias. Animação de flip em CSS puro, cronômetro e contador de tentativas.
                </p>
                <div class="mt-4 flex gap-2">
                    <a href="/games/memory-vue/" target="game-window"
                       class="flex-1 inline-flex items-center justify-center gap-1 bg-accent hover:bg-accent/90
                              text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                    <button @click="tutorial = true"
                            class="flex-1 inline-flex items-center justify-center gap-1 border border-accent text-accent
                                   hover:bg-accent hover:text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        Como Jogar
                    </button>
                </div>

                {{-- Modal tutorial --}}
                <div x-show="tutorial"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60"
                     @click.self="tutorial = false">
                    <div class="bg-bg-primary border border-gray-200 dark:border-gray-800 rounded-xl p-6 max-w-sm w-full shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">🃏 Jogo da memória Tech</h3>
                            <button @click="tutorial = false" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li class="flex gap-2"><span class="text-accent font-bold">1.</span> Clique em uma carta para virá-la.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">2.</span> Clique em outra carta para tentar combiná-la.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">3.</span> Se os logos forem iguais, o par é encontrado!</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">4.</span> Continue até combinar todos os pares.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">5.</span> Tente finalizar com menos tentativas e no menor tempo.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Wordle Tech --}}
            <div class="bg-bg-card rounded-xl border border-gray-200 dark:border-gray-800 p-6
                        hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                 data-aos="fade-up" data-aos-delay="100"
                 x-data="{ tutorial: false }">
                <div class="mb-3">
                    <svg width="48" height="34" viewBox="0 0 60 42" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0"  y="0"  width="10" height="10" rx="1.5" fill="#6b7280"/>
                        <rect x="12" y="0"  width="10" height="10" rx="1.5" fill="#6b7280"/>
                        <rect x="24" y="0"  width="10" height="10" rx="1.5" fill="#6b7280"/>
                        <rect x="36" y="0"  width="10" height="10" rx="1.5" fill="#6b7280"/>
                        <rect x="48" y="0"  width="10" height="10" rx="1.5" fill="#6b7280"/>
                        <rect x="0"  y="14" width="10" height="10" rx="1.5" fill="#eab308"/>
                        <rect x="12" y="14" width="10" height="10" rx="1.5" fill="#6b7280"/>
                        <rect x="24" y="14" width="10" height="10" rx="1.5" fill="#eab308"/>
                        <rect x="36" y="14" width="10" height="10" rx="1.5" fill="#6b7280"/>
                        <rect x="48" y="14" width="10" height="10" rx="1.5" fill="#22c55e"/>
                        <rect x="0"  y="28" width="10" height="10" rx="1.5" fill="#22c55e"/>
                        <rect x="12" y="28" width="10" height="10" rx="1.5" fill="#22c55e"/>
                        <rect x="24" y="28" width="10" height="10" rx="1.5" fill="#22c55e"/>
                        <rect x="36" y="28" width="10" height="10" rx="1.5" fill="#22c55e"/>
                        <rect x="48" y="28" width="10" height="10" rx="1.5" fill="#22c55e"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Wordle Tech</h3>
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach(['React', 'TypeScript', 'Tailwind'] as $tag)
                        <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                    @endforeach
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                    Clone do Wordle com palavras do universo tech. Teclado virtual, validação de letras e histórico salvo no LocalStorage.
                </p>
                <div class="mt-4 flex gap-2">
                    <a href="/games/termo-react/" target="game-window"
                       class="flex-1 inline-flex items-center justify-center gap-1 bg-accent hover:bg-accent/90
                              text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                    <button @click="tutorial = true"
                            class="flex-1 inline-flex items-center justify-center gap-1 border border-accent text-accent
                                   hover:bg-accent hover:text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        Como Jogar
                    </button>
                </div>

                {{-- Modal tutorial --}}
                <div x-show="tutorial"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60"
                     @click.self="tutorial = false">
                    <div class="bg-bg-primary border border-gray-200 dark:border-gray-800 rounded-xl p-6 max-w-sm w-full shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Wordle Tech</h3>
                            <button @click="tutorial = false" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li class="flex gap-2"><span class="text-accent font-bold">1.</span> Adivinhe a palavra tech em até 6 tentativas.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">2.</span> Digite uma palavra e pressione <kbd class="bg-gray-100 dark:bg-gray-800 px-1 rounded text-xs">Enter</kbd>.</li>
                            <li class="flex gap-2 items-start"><span class="shrink-0">🟩</span> Letra certa no lugar certo.</li>
                            <li class="flex gap-2 items-start"><span class="shrink-0">🟨</span> Letra certa, lugar errado.</li>
                            <li class="flex gap-2 items-start"><span class="shrink-0">⬜</span> Letra não está na palavra.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Fuga do Dino --}}
            <div class="bg-bg-card rounded-xl border border-gray-200 dark:border-gray-800 p-6
                        hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                 data-aos="fade-up" data-aos-delay="200"
                 x-data="{ tutorial: false }">
                <div class="text-3xl mb-3">🦖</div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Fuga do Dino</h3>
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach(['JavaScript', 'Canvas', 'ES6+'] as $tag)
                        <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                    @endforeach
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                    Endless runner em Canvas puro com OOP, detecção de colisão AABB e velocidade progressiva. Pule com Espaço ou toque.
                </p>
                <div class="mt-4 flex gap-2">
                    <a href="/games/runner-vanilla/" target="game-window"
                       class="flex-1 inline-flex items-center justify-center gap-1 bg-accent hover:bg-accent/90
                              text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                    <button @click="tutorial = true"
                            class="flex-1 inline-flex items-center justify-center gap-1 border border-accent text-accent
                                   hover:bg-accent hover:text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        Como Jogar
                    </button>
                </div>

                {{-- Modal tutorial --}}
                <div x-show="tutorial"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60"
                     @click.self="tutorial = false">
                    <div class="bg-bg-primary border border-gray-200 dark:border-gray-800 rounded-xl p-6 max-w-sm w-full shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">🦖 Fuga do Dino</h3>
                            <button @click="tutorial = false" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li class="flex gap-2"><span class="text-accent font-bold">1.</span> O dinossauro corre automaticamente.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">2.</span> Pressione <kbd class="bg-gray-100 dark:bg-gray-800 px-1 rounded text-xs">Espaço</kbd> ou toque na tela para pular.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">3.</span> Evite os bugs que aparecem pelo caminho.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">4.</span> A velocidade aumenta com o tempo.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">5.</span> O jogo termina ao colidir com um bug.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Defesa Espacial --}}
            <div class="bg-bg-card rounded-xl border border-gray-200 dark:border-gray-800 p-6
                        hover:border-accent/30 hover:-translate-y-1 transition-all duration-300 flex flex-col"
                 data-aos="fade-up" data-aos-delay="300"
                 x-data="{ tutorial: false }">
                <div class="text-3xl mb-3">⌨️</div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Defesa Espacial</h3>
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach(['Svelte', 'Vite', 'CSS Animations'] as $tag)
                        <span class="text-xs font-medium text-accent bg-accent/10 border border-accent/20 px-2 py-0.5 rounded-md">{{ $tag }}</span>
                    @endforeach
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed flex-1">
                    Aliens caem com comandos de terminal. Digite o comando correto para destruí-los antes que cheguem ao servidor.
                </p>
                <div class="mt-4 flex gap-2">
                    <a href="/games/typing-svelte/" target="game-window"
                       class="flex-1 inline-flex items-center justify-center gap-1 bg-accent hover:bg-accent/90
                              text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        ▶ Jogar
                    </a>
                    <button @click="tutorial = true"
                            class="flex-1 inline-flex items-center justify-center gap-1 border border-accent text-accent
                                   hover:bg-accent hover:text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                        Como Jogar
                    </button>
                </div>

                {{-- Modal tutorial --}}
                <div x-show="tutorial"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60"
                     @click.self="tutorial = false">
                    <div class="bg-bg-primary border border-gray-200 dark:border-gray-800 rounded-xl p-6 max-w-sm w-full shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">⌨️ Defesa Espacial</h3>
                            <button @click="tutorial = false" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li class="flex gap-2"><span class="text-accent font-bold">1.</span> Aliens com comandos de terminal caem do céu.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">2.</span> Digite o comando exato que aparece no alien.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">3.</span> Pressione <kbd class="bg-gray-100 dark:bg-gray-800 px-1 rounded text-xs">Enter</kbd> para destruí-lo.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">4.</span> Não deixe nenhum alien chegar ao servidor.</li>
                            <li class="flex gap-2"><span class="text-accent font-bold">5.</span> Quanto mais rápido você digitar, mais pontos ganha.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
