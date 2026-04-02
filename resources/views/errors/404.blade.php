@extends('layouts.app')

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-bg-primary px-6">
        <div class="text-center">
            <p class="text-8xl font-bold text-accent mb-4">404</p>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
                Página não encontrada
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">
                Esta página não existe ou foi removida.
            </p>
            <a href="/"
               class="inline-block bg-accent hover:bg-accent/90 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-0.5">
                Voltar ao início
            </a>
        </div>
    </section>
@endsection
