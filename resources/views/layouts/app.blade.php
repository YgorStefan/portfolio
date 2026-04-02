<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth no-transition">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ygor Stefankowski da Silva — Desenvolvedor Full Stack</title>
    <meta name="description" content="Portfólio de Ygor Stefankowski da Silva, Desenvolvedor Full Stack.">
    <meta property="og:title" content="Ygor Stefankowski da Silva — Desenvolvedor Full Stack">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:image" content="{{ asset('images/profile.jpg') }}">
    <meta property="og:description" content="Portfólio de Ygor Stefankowski da Silva, Desenvolvedor Full Stack.">
    <script>
        (function() {
            var saved = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var theme = saved || (prefersDark ? 'dark' : 'light') || 'dark';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
            // Remover no-transition após o primeiro paint para evitar flash de animação
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    document.documentElement.classList.remove('no-transition');
                });
            });
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white antialiased transition-colors duration-150" x-data>
    @include('partials.nav')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>
