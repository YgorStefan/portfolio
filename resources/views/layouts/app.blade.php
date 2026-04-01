<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
</head>
<body class="bg-gray-950 text-white antialiased" x-data>
    @include('partials.nav')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>
