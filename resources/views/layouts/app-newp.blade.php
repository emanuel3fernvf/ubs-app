<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/js/app-newp.js'])

        @if (isset($style))
            {{ $style }}
        @endif
    </head>
    <body class="bg-nav nav-top-margin">
        <div class="app-screen" data-bs-theme="dark">
            <livewire:layout.navigation-newp />

            <livewire:layout.sidebar />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="page-header bg-nav content-p sidebar-margin">
                    <nav aria-label="breadcrumb">
                        <div class="breadcrumb m-0">
                            <div class="breadcrumb-item">
                                @if(request()->routeIs('dashboard.newp'))
                                    {{ __('Dashboard') }}
                                @else
                                    <a href="{{ route('dashboard.newp') }}" wire:navigate>{{ __('Dashboard') }}</a>
                                @endif
                            </div>
                            {{ $header }}
                        </div>
                    </nav>
                </header>
            @endif

            <!-- Page Content -->
            <main class="content-p bg-nav sidebar-margin">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
