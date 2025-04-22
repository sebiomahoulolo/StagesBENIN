document.addEventListener('DOMContentLoaded', function() {

    // --- Script Date/Heure (Header) ---
    const dateTimeElement = document.getElementById("date-time");
    if (dateTimeElement) {
        function updateDateTime() {
            // Formatage plus lisible
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            // Utiliser 'fr-FR' pour le format français
            dateTimeElement.innerHTML = `<i class="bi bi-clock"></i> ${now.toLocaleString('fr-FR', options)}`;
        }
        updateDateTime(); // Appel initial
        setInterval(updateDateTime, 1000); // Mise à jour chaque seconde
    }

    // --- Script Modal d'Abonnement (Footer) ---
    const subscribeModal = document.getElementById("subscribeModal");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const subscribeBtn = document.getElementById("subscribeBtn");
    const responseMessage = document.getElementById("responseMessage");
    const emailInput = document.getElementById("emailInput");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (subscribeModal && closeModalBtn && subscribeBtn && responseMessage && emailInput && csrfToken) {
        // Afficher le modal après 30 secondes (30000 ms)
        const modalTimer = setTimeout(() => {
            subscribeModal.classList.add('show'); // Utiliser la classe pour l'animation
        }, 30000); // 30 secondes

        function closeModal() {
            subscribeModal.classList.remove('show');
            // Optionnel: on pourrait supprimer le timer si l'utilisateur ferme manuellement
            clearTimeout(modalTimer);
        }

        closeModalBtn.addEventListener("click", closeModal);

        subscribeBtn.addEventListener("click", function () {
            const email = emailInput.value.trim(); // trim() pour enlever les espaces

            // Validation simple de l'email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                responseMessage.textContent = "Veuillez entrer une adresse email valide.";
                responseMessage.className = 'response-message error'; // Classe pour couleur rouge
                responseMessage.style.display = "block";
                return;
            }

            // Désactiver le bouton pendant la requête
            subscribeBtn.disabled = true;
            subscribeBtn.textContent = 'Envoi...';

            // Utiliser une URL relative pour la requête fetch
            fetch('/subscribe', { // Assurez-vous que cette route existe dans web.php
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken,
                    'Accept': 'application/json' // Préciser qu'on attend du JSON
                },
                body: JSON.stringify({ email: email }),
            })
            .then(response => {
                if (!response.ok) {
                    // Gérer les erreurs HTTP (ex: 404, 500)
                    return response.json().then(err => { throw new Error(err.message || 'Erreur serveur'); });
                }
                return response.json();
            })
            .then(data => {
                responseMessage.textContent = data.message;
                responseMessage.className = data.success ? 'response-message success' : 'response-message error'; // Classe pour couleur
                responseMessage.style.display = "block";

                if (data.success) {
                    emailInput.value = ''; // Vider le champ si succès
                    // Fermer automatiquement après 5 secondes en cas de succès
                    setTimeout(closeModal, 5000);
                }
            })
            .catch(error => {
                console.error("Erreur lors de l'abonnement:", error);
                responseMessage.textContent = "Erreur : " + error.message;
                responseMessage.className = 'response-message error';
                responseMessage.style.display = "block";
            })
            .finally(() => {
                 // Réactiver le bouton après la requête
                 subscribeBtn.disabled = false;
                 subscribeBtn.textContent = "S'abonner";
            });
        });

        // Fermer le modal si on clique en dehors (optionnel)
        // window.addEventListener('click', (event) => {
        //     if (event.target === subscribeModal) {
        //         closeModal();
        //     }
        // });

    } else {
        console.warn("Certains éléments du modal d'abonnement n'ont pas été trouvés.");
    }


    // --- Script Bouton Scroll to Top (Footer) ---
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    if (scrollToTopBtn) {
        window.addEventListener("scroll", function () {
            // Afficher le bouton si on a scrollé de plus de 300px
            if (window.scrollY > 300) {
                scrollToTopBtn.style.display = "block";
                 // Petit effet d'apparition (optionnel)
                requestAnimationFrame(() => {
                   scrollToTopBtn.style.opacity = '1';
                   scrollToTopBtn.style.transform = 'scale(1)';
                });
            } else {
                 // Cacher avec effet (optionnel)
                 scrollToTopBtn.style.opacity = '0';
                 scrollToTopBtn.style.transform = 'scale(0.8)';
                 // Attendre la fin de la transition pour cacher réellement
                 setTimeout(() => {
                     if (window.scrollY <= 300) { // Re-vérifier au cas où l'utilisateur remonte vite
                        scrollToTopBtn.style.display = "none";
                     }
                 }, 300); // Doit correspondre à la durée de la transition CSS
            }
        }, { passive: true }); // Optimisation pour le scroll

        scrollToTopBtn.addEventListener("click", function () {
            // Scroll fluide vers le haut
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }

}); // Fin de DOMContentLoaded