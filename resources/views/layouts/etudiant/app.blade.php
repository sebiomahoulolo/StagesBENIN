<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Étudiant - StagesBENIN')</title>

    {{-- CSS Layout --}}
    <link rel="stylesheet" href="{{ asset('css/layout/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/sidebar.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    
    @livewireStyles
    @stack('styles')

    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
{{-- Initialise Alpine et gère le blocage du scroll --}}
<body x-data="{ isSidebarOpen: false }"
      {{-- Bloque le scroll du body uniquement quand la sidebar est ouverte ET qu'on est sur un petit écran --}}
      :class="{ 'overflow-hidden': isSidebarOpen && window.innerWidth < 992 }"
      class="@stack('body-class')">

    @include('layouts.etudiant.partials.header')

    <div class="app-container">
        @include('layouts.etudiant.partials.sidebar')

        {{-- Contenu Principal --}}
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    {{-- Overlay (couvre le contenu quand la sidebar est ouverte sur petit écran) --}}
    <div class="sidebar-overlay"
         x-show="isSidebarOpen"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="isSidebarOpen = false"
         x-cloak {{-- Important --}}
         style="display: none;"
    ></div>

    
    @livewireScripts
    @stack('scripts')
</body>
</html>