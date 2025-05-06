<footer class="text-light py-5 mt-5 site-footer" style="background-color:rgb(9, 58, 107)">
    
    <div id="subscribeModal" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -50%) scale(0.95); width: 90%; max-width: 380px; background: rgb(136, 187, 238); padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); text-align: center; z-index: 10000; transition: transform 0.3s ease-out, opacity 0.3s ease-out; opacity: 0;">
    <p style="font-size: 14px; color: black; margin-bottom: 10px;">Restez informé de nos dernières offres et actualités.</p>
     
    <p id="responseMessage" style="font-size: 14px; color: green; display: none; margin-top: 10px;"></p>
    <input type="email" id="emailInput" placeholder="Votre adresse email" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
        <button id="subscribeBtn" style="flex: 1; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">S'abonner</button>
        <button id="closeModalBtn" style="flex: 1; padding: 10px; background: none; border: 1px solid rgb(243, 28, 31); color: rgb(243, 28, 31); border-radius: 5px; cursor: pointer; font-size: 14px;">Fermer</button>
    </div>
  
</div>
<!-- Bouton Retour en Haut avec icône -->
<button id="scrollToTopBtn" style="display: none; position: fixed; bottom: 20px; right: 20px; background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 50%; cursor: pointer;">
  <i class="fas fa-arrow-up"></i>
</button>
  <style>
  #scrollToTopBtn:hover {
  background-color:rgb(136, 194, 255);
}

    </style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener("DOMContentLoaded", function () {
    const subscribeModal = document.getElementById("subscribeModal");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const subscribeBtn = document.getElementById("subscribeBtn");
    const responseMessage = document.getElementById("responseMessage");

    // Afficher le modal après 30s
    setTimeout(function () {
        subscribeModal.style.display = "block";
        setTimeout(() => {
            subscribeModal.style.opacity = "1";
            subscribeModal.style.transform = "translate(-50%, -50%) scale(1)";
        }, 10);
    }, 20000);

    function closeModal() {
        subscribeModal.style.opacity = "0";
        subscribeModal.style.transform = "translate(-50%, -50%) scale(0.95)";
        setTimeout(() => {
            subscribeModal.style.display = "none";
        }, 300);
    }

    closeModalBtn.addEventListener("click", closeModal);
    
    subscribeBtn.addEventListener("click", function () {
        const emailInput = document.getElementById("emailInput").value;
        if (!emailInput) {
            responseMessage.style.display = "block";
            responseMessage.style.color = "red";
            responseMessage.textContent = "Veuillez entrer une adresse email valide.";
            return;
        }
        
        fetch('http://127.0.0.1:8000/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ email: emailInput }),
        })
        .then(response => response.json())
        .then(data => {
            responseMessage.style.display = "block";
            responseMessage.style.color = data.success ? "green" : "success";
            responseMessage.textContent = data.message;

            // Fermer en 5s si le message est "Merci pour l’abonnement" ou "Déjà abonné"
            if (data.message === "Merci pour votre abonnement !" || data.message === "Vous êtes déjà abonné(e). Merci pour votre fidélité.") {
                setTimeout(closeModal, 3000);
            }
        })
        .catch(error => {
            responseMessage.style.display = "block";
            responseMessage.style.color = "success";
            responseMessage.textContent = "Erreur : " + error.message;
        });
    });
});

    document.addEventListener("scroll", function () {
        const scrollToTopBtn = document.getElementById("scrollToTopBtn");

        
        if (window.scrollY > 300) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    });

    document.getElementById("scrollToTopBtn").addEventListener("click", function () {
        
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });


</script>
    
    
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