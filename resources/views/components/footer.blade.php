<footer class="text-light py-5 mt-5 site-footer" style="background-color:rgb(9, 58, 107)">
    <div class="container">
        <div class="row">
            <!-- Logo -->
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo Footer" class="footer-logo mb-3">
                </a>
                <p class="footer-tagline">Votre passerelle vers l'avenir professionnel !</p>
            </div>

            <!-- Liens utiles -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Liens utiles</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ url('/') }}">Accueil</a></li>
                    <li><a href="{{ route('pages.catalogue') }}">Catalogues</a></li>
                    <li><a href="{{ route('pages.services') }}">Nos services</a></li>
                    <li><a href="{{ route('pages.programmes') }}">Nos programmes</a></li>
                    <li><a href="{{ route('pages.evenements') }}">Événements</a></li>
                    <li><a href="{{ route('pages.apropos') }}">À Propos</a></li>
                    <li><a href="{{ route('pages.contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Autres sites -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Autres sites</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="https://fhcgroupebenin.com/">FHC group</a></li>
                    <li><a href="https://africa-location.com/" target="_blank">AfricaLOCATION</a></li>
                    <li><a href="https://fhcschoolbenin.com/" target="_blank">Hosanna school</a></li>
                </ul>
                <h5 class="mt-3">Galerie</h5>
                <div class="footer-gallery">
                    <img src="{{ asset('assets/images/IMG-20240904-WA0025.jpg') }}" alt="Galerie 1">
                    <img src="{{ asset('assets/images/IMG_4438-scaled.jpg') }}" alt="Galerie 2">
                    <img src="{{ asset('assets/images/IMG_4567-scaled.jpg') }}" alt="Galerie 3">
                </div>
                <a href="#" class="btn btn-outline-light btn-sm mt-2">Voir plus</a>
            </div>

            <!-- Contact -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Contact</h5>
                <ul class="list-unstyled footer-contact">
                    <li><i class="bi bi-geo-alt me-2"></i>Kindonou, Cotonou - Bénin</li>
                    <li><i class="bi bi-telephone me-2"></i>+229 01 41 73 28 96</li>
                    <li><i class="bi bi-whatsapp me-2"></i>+229 01 66 69 39 56</li>
                    <li><i class="bi bi-envelope me-2"></i>contact@stagesbenin.com</li>
                </ul>
                <h5 class="mt-4">Suivez-nous</h5>
                <div class="footer-social">
                    <a href="https://www.facebook.com/stagesbenin" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.linkedin.com/company/stagesbenin/" target="_blank"><i class="bi bi-linkedin"></i></a>
                    <a href="https://www.tiktok.com/@stagesbenin6" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="https://wa.me/22966693956" target="_blank"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

<!-- Section Note Clients -->
<div class="col-lg-2 col-md-6 mb-4 d-flex align-items-center justify-content-center">
    <section class="client-rating text-center">
        <img src="{{ asset('assets/images/preview.webp') }}" alt="Note Client" style="width: 80px; height: auto; margin-bottom: 10px;">
        <p class="rating-text mt-2">
            &#x1F31F;&#x1F31F;&#x1F31F;&#x1F31F;&#x1F30F; 4.5/5
            <br>
            StagesBENIN est noté <strong>4.5 sur 5</strong> par <strong>18951 avis clients</strong>.
        </p>
    </section>
</div>


        </div>
</footer>
<hr class="footer-divider">

<!-- Copyright et Politique (En dehors du footer) -->
<section >
    <div class="container">
        <div class="row py-3">
            <div class="col-md-6 text-center text-md-start">
                <p class="footer-copyright mb-0">
                    © {{ date('Y') }} StagesBENIN. Développé par <a href="https://fhcgroupebenin.com/" target="_blank">FHC Groupe Sarl</a>.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="footer-legal mb-0">
                    <a href="#">Politique de confidentialité</a> | <a href="#">Conditions d'utilisation</a>
                </p>
            </div>
        </div>
    </div>
</section>