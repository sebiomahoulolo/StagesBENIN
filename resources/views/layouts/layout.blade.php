<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Important pour les requêtes AJAX comme dans le footer --}}
    <title>@yield('title', 'StagesBENIN')</title> {{-- Titre par défaut --}}
    <!-- Ajout de l'icône -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logostagesbenin.jpg') }}">

    {{-- CSS Global --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- Font Awesome (utilisé dans les deux) --}}

    {{-- CSS Spécifiques (Header, Footer, Application) --}}
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Pour les styles généraux comme le padding du body --}}

    @yield('styles') {{-- Pour ajouter des styles spécifiques à une page --}}
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #34495e;
        }

        /* Animations personnalisées */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
       

        .animate-fadeInUp {
            animation: fadeInUp 1s ease-out forwards;
        }

        /* Header Transparent */
        .navbar {
            background-color: transparent !important;
            position: absolute;
            width: 100%;
            z-index: 1000;
            padding-top: 20px;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background-color: white !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            color: white !important;
            position: fixed;
        }

        .navbar.scrolled .nav-link {
            color: var(--dark) !important;
        }
        .navbar.scrolled .nav-link.active {
            color: white !important;
        }
        .navbar.scrolled .nav-link:hover {
            color: white !important;
        }

        .navbar.scrolled .btn-outline-light {
            color: var(--secondary) !important;
            border-color: var(--secondary) !important;
        }

        .navbar.scrolled .btn-outline-light:hover {
            background-color: var(--secondary) !important;
            color: white !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: white;
            font-size: 1.8rem;
            transition: all 0.3s;
        }

        .navbar.scrolled .navbar-brand {
            color: var(--primary);
        }

        .navbar-brand span {
            color: var(--secondary);
        }

        .navbar .nav-link {
           
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--secondary);
            transition: width 0.3s;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .navbar.scrolled .nav-link:after {
            background-color: var(--secondary);
        }

        /* Boutons */
        .btn-primary {
            background-color: var(--secondary);
            border-color: var(--secondary);
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-outline-light {
            border: 2px solid white;
            color: white;
            font-weight: 500;
            padding: 8px 20px;
            margin-left: 10px;
            transition: all 0.3s;
        }

        .btn-outline-light:hover {
            background-color: white;
            color: var(--primary) !important;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 80, 161, 0.373), rgba(1, 52, 104, 0.951)),
                url('https://img.freepik.com/free-photo/african-american-woman-wearing-student-backpack-holding-books-smiling-happy-pointing-with-hand-finger-side_839833-34702.jpg?t=st=1750064728~exp=1750068328~hmac=54838f8084cf20e55b493ff67b939141b6df5d5880e2b4329cc5ad294d419faa&w=826');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 200px 0 120px;
            position: relative;
            overflow: hidden;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 30px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .search-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(0);
            transition: all 0.5s ease;
        }

        .search-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .search-tabs .nav-link {
            color: var(--dark);
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            position: relative;
            background: transparent;
        }

        .search-tabs .nav-link.active {
            color: var(--secondary);
            background: transparent;
        }

        .search-tabs .nav-link.active:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            bottom: 0;
            left: 25%;
            background: var(--secondary);
        }

        .form-control,
        .form-select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        /* Categories Section */
        .section-title {
            position: relative;
            margin-bottom: 60px;
            font-weight: 700;
            color: var(--primary);
        }

        .section-title:after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -15px;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--secondary);
        }

        .section-description {
            color: #666;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 50px;
        }

        .category-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(30px);
        }

        .category-card.animated {
            opacity: 1;
            transform: translateY(0);
        }

        .category-card:hover {
            transform: translateY(-10px) !important;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .category-icon {
            font-size: 2.8rem;
            color: var(--secondary);
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
        }

        .category-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .category-text {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .category-link {
            color: var(--secondary);
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .category-link:hover {
            color: var(--primary);
        }

        .category-link i {
            margin-left: 5px;
            transition: transform 0.3s;
        }

        .category-link:hover i {
            transform: translateX(5px);
        }

        /* Animation au scroll */
        [data-aos] {
            transition: all 0.8s ease;
        }

        .aos-fade {
            opacity: 0;
            transition-property: opacity;
        }

        .aos-fade.aos-animate {
            opacity: 1;
        }

        .aos-slide-up {
            transform: translateY(50px);
            transition-property: transform, opacity;
        }

        .aos-slide-up.aos-animate {
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <!-- Header/Navbar Transparent -->
    @include('components.navbar')
    <main class="container-fluid"> {{-- Ajout d'une marge pour l'espacement initial --}}
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

    <script>
        // Effet de scroll sur la navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animation au scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes de catégories
            const animateOnScroll = function() {
                const cards = document.querySelectorAll('.category-card');
                const windowHeight = window.innerHeight;

                cards.forEach((card, index) => {
                    const cardPosition = card.getBoundingClientRect().top;
                    const animationDelay = index * 100;

                    if (cardPosition < windowHeight - 100) {
                        card.style.animationDelay = `${animationDelay}ms`;
                        card.classList.add('animated');
                    }
                });
            };

            // Initial animation
            animateOnScroll();

            // On scroll animation
            window.addEventListener('scroll', animateOnScroll);

            // Simple scroll animation system
            const aosElements = document.querySelectorAll('[data-aos]');

            const checkIfInView = function() {
                aosElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;

                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('aos-animate');
                    }
                });
            };

            // Initialize
            aosElements.forEach(element => {
                element.classList.add('aos-fade');
                element.classList.add('aos-slide-up');
            });

            checkIfInView();
            window.addEventListener('scroll', checkIfInView);
        });
    </script>
</body>

</html>
