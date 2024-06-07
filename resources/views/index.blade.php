<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container text-center mt-5">
            <h1>Bem vindo ao Ubs App</h1>
            <p>Sua solução completa para gerenciamento de serviços de saúde.</p>

            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="btn btn-primary"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="btn btn-primary"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="btn btn-primary"
                    >
                        Registro
                    </a>
                @endif
            @endauth
        </div>
    </body>
</html>
