{{-- Sentinel element observed by Alpine intersect. Placed at the top of the hero section area.
     x-intersect:leave fires when this element scrolls OUT of view (user has scrolled down).
     x-intersect:enter fires when this element scrolls BACK into view (user is at top). --}}
<div
    id="scroll-sentinel"
    x-data="{ show: false }"
    x-intersect:leave="show = true"
    x-intersect:enter="show = false"
    class="absolute top-0 left-0 h-1 w-1 pointer-events-none"
>
    {{-- Back-to-top button (fixed position, appears after scrolling past sentinel) --}}
    <button
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-40 bg-accent hover:bg-blue-400 text-white rounded-full p-3 shadow-lg transition-colors pointer-events-auto"
        aria-label="Voltar ao topo"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>
</div>

<footer class="border-t border-gray-800 py-8 mt-16">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} Ygor Stefankowski da Silva. Todos os direitos reservados.
        </p>
    </div>
</footer>
