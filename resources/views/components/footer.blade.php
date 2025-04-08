<footer class="bg-dark text-light py-5 mt-5">
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
  background-color: #0056b3;
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
    }, 30000);

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
                setTimeout(closeModal, 5000);
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
        <div class="row" >
          
            <div class="col-md-3 mb-4">
                <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo">
            </a>
            </div>

    
<div class="col-md-3 mb-4">
    <h5>Liens utiles</h5>
    <div class="row">
        <div class="col">
            <ul class="list-unstyled">
                <li><a href="{{ url('/') }}" class="text-light">Accueil</a></li>
                <li><a href="{{ route('pages.services') }}" class="text-light">Nos services</a></li>
                <li><a href="#" class="text-light">Offres disponibles</a></li>
                <li><a href="#" class="text-light">Espace recruteurs</a></li>
            </ul>
        </div>
        <div class="col">
            <ul class="list-unstyled">
                <li><a href="#" class="text-light">Espace candidats</a></li>
                <li><a href="{{ route('pages.programmes') }}" class="text-light">Nos programmes</a></li>
                <li><a href="{{ route('pages.evenements') }}" class="text-light">Événements</a></li>
                <li><a href="{{ route('pages.contact') }}" class="text-light">Contact</a></li>
            </ul>
        </div>
    </div>
</div>


            <!-- Galerie -->
            <div class="col-md-3 mb-4">
                <h5>Galerie</h5>
                <div class="row">
                    <div class="col-4 mb-2">
                        <img src="{{ asset('assets/images/IMG-20240904-WA0025.jpg') }}" class="img-fluid rounded" alt="Galerie 1">
                    </div>
                    <div class="col-4 mb-2">
                        <img src="{{ asset('assets/images/IMG_4438-scaled.jpg') }}" class="img-fluid rounded" alt="Galerie 2">
                    </div>
                    <div class="col-4 mb-2">
                        <img src="{{ asset('assets/images/IMG_4567-scaled.jpg') }}" class="img-fluid rounded" alt="Galerie 3">
                    </div>
                </div>
                 <a href="#" class="service-btn btn btn-primary">Voir plus</a>
            </div>
            <style>
a.text-light {
    text-decoration: none; /* Supprime le soulignement */
}

a.text-light:hover {
    text-decoration: underline; /* Facultatif : ajoute un soulignement au survol */
}</style>
            <!-- Autres sites -->
            <div class="col-md-3 mb-4">
                <h5>Autres sites</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">FHC group</a></li>
                    <li><a href="https://africa-location.com/" class="text-light">AfricaLOCATION</a></li>
                    <li><a href="https://fhcschoolbenin.com/" class="text-light">Hosanna school</a></li>
                </ul>
            </div>
        </div>

        <hr class="bg-light">

        <div class="row">
            <!-- Contact -->
            <div class="col-md-6">
                <h5>Contact</h5>
                <p><i class="bi bi-geo-alt"></i> Kindonou, Cotonou - Bénin</p>
                <p><i class="bi bi-telephone"></i> +229 01 41 73 28 96 /+229 01 66 69 39 56</p>
                <p><i class="bi bi-envelope"></i> contact@stagesbenin.com</p>
            </div>

            <!-- Réseaux sociaux -->
            <div class="col-md-6 text-md-end">
                <h5>Suivez-nous</h5>
                <a href="https://www.facebook.com/stagesbenin" class="text-light me-3"><i class="bi bi-facebook"></i></a>
                <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" class="text-light me-3"><i class="bi bi-linkedin"></i></a>
                <a href="https://www.tiktok.com/@stagesbenin6?_t=8lH68SpT4HG&_r=1" class="text-light me-3"><i class="fa-brands fa-tiktok"></i></a>
                <a href="https://wa.me/22966693956" class="text-light"><i class="bi bi-whatsapp"></i></a>
            </div>
  <hr class="bg-light">
          
<div class="col-md-6">
                
                <p>© StagesBENIN 2025, Développé par FHC Groupe Sarl.</p>
               
         
            </div>
 <!-- Réseaux sociaux -->
            <div class="col-md-6 text-md-end">
              <p>Politique | Confidentialité</p>
            </div>
        </div>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</footer>

