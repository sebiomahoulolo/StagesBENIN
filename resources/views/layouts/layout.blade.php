<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    
</head>
<body>
    <header>
        <!-- Ici, incluez le navbar ou une bannière -->
        @include('components.navbar')
    </header>
    <main class="container">
        @yield('content')
    </main>
    <footer>
        @include('components.footer')
    </footer>
</body>
</html>
