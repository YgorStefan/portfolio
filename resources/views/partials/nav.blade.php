<header>
    <nav
        x-data="{ open: false, dark: document.documentElement.classList.contains('dark') }"
        x-init="$watch('dark', val => {
            if (val) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        })"
        class="fixed top-0 left-0 right-0 z-50 bg-white/90 dark:bg-gray-950/90 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 transition-colors duration-150">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo com hover expand por letra --}}
            <a href="#hero"
               x-data="{ expanded: false }"
               @mouseenter="expanded = true"
               @mouseleave="expanded = false"
               @click.outside="expanded = false"
               class="font-bold text-gray-900 dark:text-white text-lg tracking-tight hover:text-accent transition-colors inline-flex items-center"
               style="white-space: nowrap;"
            >
                Y<span
                    class="inline-block overflow-hidden"
                    style="transition: max-width 300ms ease-in-out, opacity 300ms ease-in-out; white-space: nowrap; vertical-align: baseline;"
                    :style="{ maxWidth: expanded ? '3.5rem' : '0', opacity: expanded ? '1' : '0' }"
                >gor&nbsp;</span>S<span
                    class="inline-block overflow-hidden"
                    style="transition: max-width 300ms ease-in-out, opacity 300ms ease-in-out; white-space: nowrap; vertical-align: baseline;"
                    :style="{ maxWidth: expanded ? '12rem' : '0', opacity: expanded ? '1' : '0' }"
                >tefankowski&nbsp;da&nbsp;</span>S<span
                    class="inline-block overflow-hidden"
                    style="transition: max-width 300ms ease-in-out, opacity 300ms ease-in-out; white-space: nowrap; vertical-align: baseline;"
                    :style="{ maxWidth: expanded ? '3.5rem' : '0', opacity: expanded ? '1' : '0' }"
                >ilva</span>
            </a>

            {{-- Links desktop --}}
            <ul class="hidden md:flex items-center gap-8">
                <li><a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium">Sobre</a></li>
                <li><a href="#skills" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium">Skills</a></li>
                <li><a href="#projects" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium">Projetos</a></li>
                <li><a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium">Contato</a></li>
                {{-- Toggle de tema (desktop) --}}
                <li>
                    <button
                        @click="dark = !dark"
                        :aria-checked="dark"
                        role="switch"
                        aria-label="Alternar tema"
                        class="relative inline-flex items-center w-12 h-6 rounded-full cursor-pointer
                               bg-gray-300 dark:bg-accent
                               transition-colors duration-200"
                    >
                        <span
                            :class="dark ? 'translate-x-6' : 'translate-x-1'"
                            class="inline-flex items-center justify-center w-5 h-5 bg-white rounded-full shadow transition-transform duration-200"
                        >
                            {{-- Sol (light mode) --}}
                            <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                            </svg>
                            {{-- Lua (dark mode) --}}
                            <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </span>
                    </button>
                </li>
            </ul>

            {{-- Toggle de tema (mobile) --}}
            <button
                @click="dark = !dark"
                :aria-checked="dark"
                role="switch"
                aria-label="Alternar tema"
                class="md:hidden relative inline-flex items-center w-12 h-6 rounded-full cursor-pointer
                       bg-gray-300 dark:bg-accent
                       transition-colors duration-200"
            >
                <span
                    :class="dark ? 'translate-x-6' : 'translate-x-1'"
                    class="inline-flex items-center justify-center w-5 h-5 bg-white rounded-full shadow transition-transform duration-200"
                >
                    <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </span>
            </button>

            {{-- Botão menu (mobile) --}}
            <button
                @click="open = !open"
                class="md:hidden text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors p-2"
                aria-label="Abrir menu"
                :aria-expanded="open"
            >
                {{-- Ícone menu --}}
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                {{-- Ícone fechar --}}
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Menu mobile --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 transition-colors duration-150"
        >
            <ul class="px-6 py-4 flex flex-col gap-4">
                <li><a href="#about" @click="open = false" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium block py-2">Sobre</a></li>
                <li><a href="#skills" @click="open = false" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium block py-2">Skills</a></li>
                <li><a href="#projects" @click="open = false" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium block py-2">Projetos</a></li>
                <li><a href="#contact" @click="open = false" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors text-sm font-medium block py-2">Contato</a></li>
            </ul>
        </div>
    </nav>
</header>
