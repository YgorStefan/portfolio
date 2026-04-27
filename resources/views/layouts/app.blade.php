<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth no-transition">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio Ygor Stefankowski</title>
    <meta name="description"
        content="Portfólio de Ygor Stefankowski da Silva, Analista de Sistemas e Desenvolvedor Full Stack.">
    <meta property="og:title" content="Portfólio Ygor Stefankowski">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:image" content="{{ asset('images/cartoon.jpeg') }}">
    <meta property="og:description"
        content="Portfólio de Ygor Stefankowski da Silva, Analista de Sistemas e Desenvolvedor Full Stack.">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <script>
        (function () {
            var saved = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var theme = saved || (prefersDark ? 'dark' : 'light') || 'dark';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
            // Set language attribute before first paint
            var lang = localStorage.getItem('lang') || 'pt';
            document.documentElement.lang = lang === 'pt' ? 'pt-BR' : 'en';
            // Remover no-transition após o primeiro paint para evitar flash de animação
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    document.documentElement.classList.remove('no-transition');
                });
            });
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
    @production
        {{-- Umami Analytics — sem cookies, GDPR-compliant --}}
        {{-- Instruções: obter o data-website-id em umami.is → Dashboard → Add website → Get tracking code --}}
        <script defer src="https://cloud.umami.is/script.js"
            data-website-id="0a7dce55-bf69-4c69-8642-0a5e7efea7ae"></script>
    @endproduction
</head>

<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white antialiased transition-colors duration-150"
    x-data>
    @include('partials.nav')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
</body>

</html>