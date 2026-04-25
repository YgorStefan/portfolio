<section id="skills" class="py-24 bg-bg-card">
    <div class="container mx-auto px-6"
         x-data='skillsGrid(@json($skills))'
         x-intersect.once="start()">

        {{-- Título --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Habilidades</h2>
            <div class="w-16 h-1 bg-accent mx-auto rounded-full"></div>
            <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl mx-auto">
                Tecnologias e ferramentas com as quais trabalho no dia a dia.
            </p>
        </div>

        {{-- Tabs --}}
        <div class="flex justify-center flex-wrap gap-2 mb-7" data-aos="fade-up" data-aos-delay="100">
            <template x-for="tab in [
                {key:'all',     label:'Todos'},
                {key:'backend', label:'Backend'},
                {key:'frontend',label:'Frontend'},
                {key:'devops',  label:'DevOps'}
            ]" :key="tab.key">
                <button
                    @click="setCategory(tab.key)"
                    :class="cat === tab.key
                        ? 'bg-accent border-accent text-white shadow-[0_0_20px_rgba(59,130,246,0.4)]'
                        : 'border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400 hover:border-accent/50 hover:text-accent'"
                    class="px-5 py-2 rounded-full text-sm font-semibold border-[1.5px] transition-all duration-250 cursor-pointer"
                    x-text="tab.label">
                </button>
            </template>
        </div>

        {{-- Grid de skills --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 max-w-5xl mx-auto" data-aos="fade-up" data-aos-delay="200">

            {{-- Cards reais --}}
            <template x-for="(skill, idx) in currentPageSkills" :key="skill.name">
                <div class="skill-card bg-bg-primary border border-gray-200 dark:border-gray-800 rounded-xl p-4 flex flex-col items-center justify-center gap-2 min-h-[90px] cursor-default"
                     :class="cardsVisible ? 'skill-card--visible' : ''"
                     :style="{ transitionDelay: cardsVisible ? (idx * 55) + 'ms' : '0ms' }">

                    {{-- Ícone: SVG para IA/ML, Devicon para demais --}}
                    <template x-if="skill.svg">
                        <div class="w-10 h-10 flex items-center justify-center" x-html="skill.svg"></div>
                    </template>
                    <template x-if="!skill.svg">
                        <i :class="skill.icon + ' text-4xl leading-none'"></i>
                    </template>

                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 text-center leading-tight"
                          x-text="skill.name"></span>
                </div>
            </template>

            {{-- Placeholders invisíveis para manter tamanho uniforme dos cards --}}
            <template x-for="(_, gi) in ghosts" :key="'g' + gi">
                <div class="min-h-[90px] invisible"></div>
            </template>
        </div>

        {{-- Navegação (só visível quando há mais de 1 página) --}}
        <div class="flex items-center justify-center gap-4 mt-6 h-9"
             :class="isPaginated ? 'visible' : 'invisible'">

            <button @click="goTo(page - 1)"
                    :disabled="page === 0"
                    class="w-9 h-9 rounded-full border border-gray-200 dark:border-gray-800 bg-bg-primary
                           text-gray-500 dark:text-gray-400 flex items-center justify-center
                           transition-all duration-200
                           hover:border-accent hover:text-accent hover:shadow-[0_0_12px_rgba(59,130,246,0.3)]
                           disabled:opacity-30 disabled:cursor-default
                           disabled:hover:border-gray-200 dark:disabled:hover:border-gray-800
                           disabled:hover:text-gray-500 disabled:hover:shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Dots --}}
            <div class="flex gap-1.5 items-center">
                <template x-for="(_, di) in Array.from({length: totalPages})" :key="di">
                    <button @click="goTo(di)"
                            :class="di === page
                                ? 'w-[18px] bg-accent shadow-[0_0_8px_rgba(59,130,246,0.5)]'
                                : 'w-1.5 bg-gray-300 dark:bg-gray-700'"
                            class="h-1.5 rounded-full transition-all duration-300 cursor-pointer">
                    </button>
                </template>
            </div>

            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 min-w-[48px] text-center"
                  x-text="(page + 1) + ' / ' + totalPages">
            </span>

            <button @click="goTo(page + 1)"
                    :disabled="page >= totalPages - 1"
                    class="w-9 h-9 rounded-full border border-gray-200 dark:border-gray-800 bg-bg-primary
                           text-gray-500 dark:text-gray-400 flex items-center justify-center
                           transition-all duration-200
                           hover:border-accent hover:text-accent hover:shadow-[0_0_12px_rgba(59,130,246,0.3)]
                           disabled:opacity-30 disabled:cursor-default
                           disabled:hover:border-gray-200 dark:disabled:hover:border-gray-800
                           disabled:hover:text-gray-500 disabled:hover:shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        {{-- Barra de progresso (só visível quando há mais de 1 página) --}}
        <div :class="isPaginated ? 'visible' : 'invisible'"
             class="mt-3.5 h-[3px] rounded-full overflow-hidden max-w-xs mx-auto bg-gray-200 dark:bg-gray-800">
            <div x-ref="progressBar"
                 class="h-full rounded-full"
                 style="background: linear-gradient(90deg, #312e81, #3b82f6, #93c5fd); width: 0%;">
            </div>
        </div>

    </div>
</section>
