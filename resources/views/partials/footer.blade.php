{{-- Estado compartilhado entre sentinel e botão voltar ao topo --}}
<div x-data="{ show: false }">
    {{-- Sentinel observado pelo Alpine intersect --}}
    <div
        id="scroll-sentinel"
        x-intersect:leave="show = true"
        x-intersect:enter="show = false"
        class="absolute top-0 left-0 h-1 w-1 pointer-events-none"
    ></div>

    {{-- Botão voltar ao topo --}}
    <button
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-40 bg-accent hover:bg-blue-400 text-white rounded-full p-3 shadow-lg transition-colors cursor-pointer"
        style="cursor: pointer;"
        aria-label="Voltar ao topo"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>
</div>

<footer class="bg-bg-card border-t border-gray-200 dark:border-gray-800 py-8 mt-16 transition-colors duration-150">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} Ygor Stefankowski da Silva. Todos os direitos reservados.
        </p>
    </div>
</footer>
