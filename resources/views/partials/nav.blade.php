<header>
    <nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-gray-950/90 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo --}}
            <a href="#hero" class="font-bold text-white text-lg tracking-tight hover:text-accent transition-colors">
                YS
            </a>

            {{-- Links desktop --}}
            <ul class="hidden md:flex items-center gap-8">
                <li><a href="#about" class="text-gray-300 hover:text-white transition-colors text-sm font-medium">Sobre</a></li>
                <li><a href="#skills" class="text-gray-300 hover:text-white transition-colors text-sm font-medium">Skills</a></li>
                <li><a href="#projects" class="text-gray-300 hover:text-white transition-colors text-sm font-medium">Projetos</a></li>
                <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors text-sm font-medium">Contato</a></li>
            </ul>

            {{-- Botão menu (mobile) --}}
            <button
                @click="open = !open"
                class="md:hidden text-gray-300 hover:text-white transition-colors p-2"
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
            class="md:hidden border-t border-gray-800 bg-gray-950"
        >
            <ul class="px-6 py-4 flex flex-col gap-4">
                <li><a href="#about" @click="open = false" class="text-gray-300 hover:text-white transition-colors text-sm font-medium block py-2">Sobre</a></li>
                <li><a href="#skills" @click="open = false" class="text-gray-300 hover:text-white transition-colors text-sm font-medium block py-2">Skills</a></li>
                <li><a href="#projects" @click="open = false" class="text-gray-300 hover:text-white transition-colors text-sm font-medium block py-2">Projetos</a></li>
                <li><a href="#contact" @click="open = false" class="text-gray-300 hover:text-white transition-colors text-sm font-medium block py-2">Contato</a></li>
            </ul>
        </div>
    </nav>
</header>
