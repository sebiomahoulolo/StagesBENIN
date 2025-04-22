<!-- Modal d'abonnement -->
<div id="subscribeModal" class="subscribe-modal">
    <p class="modal-text">Restez informé de nos dernières offres et actualités.</p>

    <p id="responseMessage" class="response-message" style="display: none;"></p>
    <input type="email" id="emailInput" placeholder="Votre adresse email" class="modal-input">

    <div class="modal-buttons">
        <button id="subscribeBtn" class="btn btn-primary modal-btn">S'abonner</button>
        <button id="closeModalBtn" class="btn btn-outline-danger modal-btn">Fermer</button>
    </div>
</div>

<!-- Bouton Retour en Haut -->
<button id="scrollToTopBtn" class="scroll-to-top-btn" title="Retour en haut">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- Footer principal -->
<footer class="bg-dark text-light py-5 mt-5 site-footer">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo Footer" class="footer-logo mb-3">
                </a>
                <p class="footer-tagline">Votre partenaire pour les stages et l'emploi au Bénin.</p>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Liens utiles</h5>
                 <ul class="list-unstyled footer-links">
                    <li><a href="{{ url('/') }}">Accueil</a></li>
                    <li><a href="{{ route('pages.catalogue') }}">Catalogues</a></li>
                    <li><a href="{{ route('pages.services') }}">Nos services</a></li>
                    <li><a href="{{ route('pages.programmes') }}">Nos programmes</a></li>
                    <li><a href="{{ route('pages.evenements') }}">Événements</a></li>
                    <li><a href="{{ route('pages.apropos') }}">À Propos</a></li>
                    <li><a href="{{ route('pages.contact') }}">Contact</a></li>
                    {{-- Ajouter d'autres liens si nécessaire --}}
                 </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Autres sites</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#" target="_blank" rel="noopener noreferrer">FHC group</a></li>
                    <li><a href="https://africa-location.com/" target="_blank" rel="noopener noreferrer">AfricaLOCATION</a></li>
                    <li><a href="https://fhcschoolbenin.com/" target="_blank" rel="noopener noreferrer">Hosanna school</a></li>
                </ul>
                 <h5 class="mt-3">Galerie</h5>
                <div class="footer-gallery">
                     <img src="{{ asset('assets/images/IMG-20240904-WA0025.jpg') }}" alt="Galerie 1">
                     <img src="{{ asset('assets/images/IMG_4438-scaled.jpg') }}" alt="Galerie 2">
                     <img src="{{ asset('assets/images/IMG_4567-scaled.jpg') }}" alt="Galerie 3">
                </div>
                {{-- Remplacer par un lien vers une page galerie si elle existe --}}
                 <a href="#" class="btn btn-outline-light btn-sm mt-2">Voir plus</a>
            </div>

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
                    <a href="https://www.facebook.com/stagesbenin" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
                    <a href="https://www.tiktok.com/@stagesbenin6?_t=8lH68SpT4HG&_r=1" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="https://wa.me/22966693956" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp"></i></a>
                 </div>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="footer-copyright">© {{ date('Y') }} StagesBENIN. Développé par <a href="#" target="_blank" rel="noopener noreferrer">FHC Groupe Sarl</a>.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
               <p class="footer-legal"><a href="#">Politique de confidentialité</a> | <a href="#">Conditions d'utilisation</a></p>
            </div>
        </div>
    </div>
</footer>