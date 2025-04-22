<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Important pour les requêtes AJAX comme dans le footer --}}
    <title>@yield('title', 'StagesBENIN')</title> {{-- Titre par défaut --}}

    {{-- CSS Global --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> {{-- Font Awesome (utilisé dans les deux) --}}

    {{-- CSS Spécifiques (Header, Footer, Application) --}}
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Pour les styles généraux comme le padding du body --}}

    @yield('styles') {{-- Pour ajouter des styles spécifiques à une page --}}
</head>
<body>

    <header>
        {{-- Inclure le partial du header --}}
        @include('components.navbar')
    </header>

    <main class="container mt-4"> {{-- Ajout d'une marge pour l'espacement initial --}}
        {{-- Contenu spécifique de la page --}}
        @yield('content')
    </main>

    {{-- Inclure le partial du footer --}}
    @include('components.footer')


    {{-- JS Global et Librairies --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- JS spécifique à l'application --}}
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts') {{-- Pour ajouter des scripts spécifiques à une page --}}

</body>
</html>