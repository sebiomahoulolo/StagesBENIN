<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidature StagesBENIN - Recrutement Août 2025</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #27ae60;
            --border-radius: 8px;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f5f7fa;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        header {
            background: var(--primary);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        header p {
            color: var(--light);
            font-size: 1.1rem;
        }

        .logo {
            width: 120px;
            margin-bottom: 1rem;
        }

        .form-container {
            padding: 2rem;
            position: relative;
            min-height: 500px;
        }

        .progress-bar {
            height: 6px;
            background: #e0e0e0;
            margin-bottom: 2rem;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: linear-gradient(90deg, var(--secondary), var(--primary));
            width: 0;
            transition: width 0.5s ease;
        }

        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-step.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .required:after {
            content: " *";
            color: var(--accent);
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .file-upload {
            border: 2px dashed #e0e0e0;
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .file-upload:hover {
            border-color: var(--secondary);
            background: rgba(52, 152, 219, 0.05);
        }

        .file-upload input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #7f8c8d;
        }

        .file-upload-label i {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 2rem 0;
        }

        .checkbox-group input {
            width: auto;
            margin-right: 10px;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }

        button {
            padding: 12px 24px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-next {
            background: var(--primary);
            color: white;
        }

        .btn-next:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-prev {
            background: #95a5a6;
            color: white;
        }

        .btn-prev:hover {
            background: #7f8c8d;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            width: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        button i {
            margin-right: 8px;
        }

        .error {
            color: var(--accent);
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }

        input:invalid, select:invalid, textarea:invalid {
            border-color: var(--accent);
        }

        input:invalid + .error, select:invalid + .error, textarea:invalid + .error {
            display: block;
        }

        .confirmation {
            text-align: center;
            padding: 3rem 2rem;
            display: none;
        }

        .confirmation i {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 1.5rem;
            animation: bounceIn 1s;
        }

        .confirmation h2 {
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .confirmation p {
            margin-bottom: 1rem;
            color: #7f8c8d;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }

        @media (max-width: 768px) {
            header {
                padding: 1.5rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
            
            .file-upload {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 1.5rem;
            }
            
            header p {
                font-size: 1rem;
            }
            
            .navigation-buttons {
                flex-direction: column;
            }
            
            .navigation-buttons button {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
         
            <h1>Candidature StagesBENIN</h1>
            <p>Recrutement Multi-poste - Août 2025</p>
        </header>

        <div class="form-container">
            <div class="progress-bar">
                <div class="progress" id="progressBar"></div>
            </div>

          
                <form id="candidatureForm" action="{{ route('submit.application') }}" method="POST" enctype="multipart/form-data">
    @csrf
                <!-- Étape 1 - Poste et informations personnelles -->
                <div class="form-step active" id="step1">
                    <div class="form-group">
                        <label for="poste" class="required">Poste souhaité</label>
                        <select id="poste" name="poste" required>
                            <option value="">-- Sélectionnez un poste --</option>
                            <option value="1. ASSISTANTE DE DIRECTION – Vêdoko (Femme uniquement)">1. ASSISTANTE DE DIRECTION – Vêdoko (Femme uniquement)</option>
                            <option value="2. DIRECTEUR COMMERCIAL – Vêdoko (Homme)">2. DIRECTEUR COMMERCIAL – Vêdoko (Homme)</option>
                            <option value="3. ASSISTANTE DE DIRECTION – Akpakpa (Femme)">3. ASSISTANTE DE DIRECTION – Akpakpa (Femme)</option>
                            <option value="4. TECHNICIENS EN GÉNIE CIVIL – Akpakpa (H/F)">4. TECHNICIENS EN GÉNIE CIVIL – Akpakpa (H/F)</option>
                            <option value="5. COMPTABLE STAGIAIRE – Zogbadjè (Femme)">5. COMPTABLE STAGIAIRE – Zogbadjè (Femme)</option>
                            <option value="6. HÔTESSES COMMERCIALES – Cotonou (Femme Uniquement sur Cotonou)">6. HÔTESSES COMMERCIALES – Cotonou (Femme Uniquement sur Cotonou)</option>
                            <option value="7. AGENTS IMMOBILIERS – Parana (H/F)">7. AGENTS IMMOBILIERS – Parana (H/F)</option>
                            <option value="8. RESPONSABLE COMMERCIAL – Parana (H/F)">8. RESPONSABLE COMMERCIAL – Parana (H/F)</option>
                            <option value="9. DIRECTEUR COMMERCIAL – Parana (H/F)">9. DIRECTEUR COMMERCIAL – Parana (H/F)</option>
                            <option value="10. HÔTESSES COMMERCIALES POUR AGENCE D'ASSURANCES– Cotonou (Femme uniquement)">10. HÔTESSES COMMERCIALES POUR AGENCE D'ASSURANCES– Cotonou (Femme uniquement)</option>
                            <option value="11. AGENTS DE COLLECTE GREEN CARD – Localités variées (H/F)">11. AGENTS DE COLLECTE GREEN CARD – Localités variées (H/F)</option>
                        </select>
                        <div class="error">Veuillez sélectionner un poste</div>
                    </div>

                    <div class="form-group">
                        <label for="civilite" class="required">Civilité</label>
                        <select id="civilite" name="civilite" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="M.">M.</option>
                            <option value="Mme">Mme</option>
                            <option value="Mlle">Mlle</option>
                        </select>
                        <div class="error">Veuillez sélectionner votre civilité</div>
                    </div>

                    <div class="form-group">
                        <label for="nom" class="required">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                        <div class="error">Veuillez entrer votre nom</div>
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="required">Prénom(s)</label>
                        <input type="text" id="prenom" name="prenom" required>
                        <div class="error">Veuillez entrer votre prénom</div>
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" class="btn-next" onclick="nextStep(1, 2)">
                            <i class="fas fa-arrow-right"></i> Suivant
                        </button>
                    </div>
                </div>

                <!-- Étape 2 - Coordonnées -->
                <div class="form-step" id="step2">
                    <div class="form-group">
                        <label for="email" class="required">Email</label>
                        <input type="email" id="email" name="email" required>
                        <div class="error">Veuillez entrer une adresse email valide</div>
                    </div>

                    <div class="form-group">
                        <label for="telephone" class="required">Téléphone</label>
                        <input type="tel" id="telephone" name="telephone" required>
                        <div class="error">Veuillez entrer votre numéro de téléphone</div>
                    </div>

                    <div class="form-group">
                        <label for="adresse" class="required">Adresse</label>
                        <input type="text" id="adresse" name="adresse" required>
                        <div class="error">Veuillez entrer votre adresse</div>
                    </div>

                    <div class="form-group">
                        <label for="ville" class="required">Ville de résidence</label>
                        <input type="text" id="ville" name="ville" required>
                        <div class="error">Veuillez entrer votre ville de résidence</div>
                    </div>

                    <div class="form-group">
                        <label for="naissance" class="required">Date de naissance</label>
                        <input type="date" id="naissance" name="naissance" required>
                        <div class="error">Veuillez entrer votre date de naissance</div>
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" class="btn-prev" onclick="prevStep(2, 1)">
                            <i class="fas fa-arrow-left"></i> Précédent
                        </button>
                        <button type="button" class="btn-next" onclick="nextStep(2, 3)">
                            <i class="fas fa-arrow-right"></i> Suivant
                        </button>
                    </div>
                </div>

                <!-- Étape 3 - Formation et expérience -->
                <div class="form-step" id="step3">
                    <div class="form-group">
                        <label for="niveau" class="required">Niveau d'études</label>
                        <select id="niveau" name="niveau" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="BAC">BAC</option>
                            <option value="BTS">BTS</option>
                            <option value="Licence">Licence</option>
                            <option value="Master">Master</option>
                            <option value="Doctorat">Doctorat</option>
                            <option value="Autre">Autre</option>
                        </select>
                        <div class="error">Veuillez sélectionner votre niveau d'études</div>
                    </div>

                    <div class="form-group">
                        <label for="diplome" class="required">Dernier diplôme obtenu</label>
                        <input type="text" id="diplome" name="diplome" required>
                        <div class="error">Veuillez entrer votre dernier diplôme</div>
                    </div>

                    <div class="form-group">
                        <label for="experience">Années d'expérience (si applicable)</label>
                        <input type="number" id="experience" name="experience" min="0">
                    </div>

                    <div class="form-group">
                        <label for="competences">Compétences particulières (logiciels maîtrisés, etc.)</label>
                        <textarea id="competences" name="competences" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="motivation" class="required">Lettre de motivation</label>
                        <textarea id="motivation" name="motivation" rows="5" required oninput="updateMotivationCount()"></textarea>
                        <div id="motivation-count" style="font-size:0.9rem; color:#888; margin-top:5px;">0 / 50 caractères minimum</div>
                        <div class="error">Veuillez rédiger votre lettre de motivation (minimum 50 caractères)</div>
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" class="btn-prev" onclick="prevStep(3, 2)">
                            <i class="fas fa-arrow-left"></i> Précédent
                        </button>
                        <button type="button" class="btn-next" onclick="nextStep(3, 4)">
                            <i class="fas fa-arrow-right"></i> Suivant
                        </button>
                    </div>
                </div>

                <!-- Étape 4 - Documents et soumission -->
                <div class="form-step" id="step4">
                    <div class="form-group">
                        <label class="required">Dossier PDF complet</label>
                        <div class="file-upload">
                            <input type="file" id="dossier" name="dossier" accept=".pdf" required>
                            <label for="dossier" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Glissez-déposez votre fichier ou cliquez pour parcourir</span>
                                <small>Format PDF uniquement (max 5MB)</small>
                            </label>
                        </div>
                        <div class="error">Veuillez téléverser votre dossier en PDF</div>
                        <div id="fileName" style="margin-top: 10px; font-size: 0.9rem;"></div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="consentement" name="consentement" required>
                        <label for="consentement" class="required">Je certifie que les informations fournies sont exactes et autorise StagesBENIN à traiter mes données pour ce recrutement.</label>
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" class="btn-prev" onclick="prevStep(4, 3)">
                            <i class="fas fa-arrow-left"></i> Précédent
                        </button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Envoyer ma candidature
                        </button>
                    </div>
                </div>
            </form>

            <div class="confirmation" id="confirmation">
                <i class="fas fa-check-circle"></i>
                <h2>Merci pour votre candidature !</h2>
                <p>Votre dossier a bien été envoyé à StagesBENIN.</p>
                <p>Seuls les candidats présélectionnés seront contactés.</p>
                <p><strong>Date limite de dépôt : 10 août 2025</strong></p>
                <p>Pour plus d'informations : <br>+229 01 41 73 31 69</p>
            </div>
        </div>
    </div>

   <script>
    // Mise à jour du compteur de caractères pour la motivation
    function updateMotivationCount() {
        const textarea = document.getElementById('motivation');
        const countDiv = document.getElementById('motivation-count');
        const length = textarea.value.length;
        countDiv.textContent = `${length} / 50 caractères minimum`;
        if (length < 50) {
            countDiv.style.color = '#e74c3c'; // accent color for warning
        } else {
            countDiv.style.color = '#27ae60'; // success color
        }
    }
    // Initialiser le compteur au chargement
    document.addEventListener('DOMContentLoaded', updateMotivationCount);
    // Variables globales
    let currentStep = 1;
    const totalSteps = 4;

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        updateProgressBar();
        document.getElementById('dossier').addEventListener('change', displayFileName);
        
        // Ajout des animations CSS si elles n'existent pas déjà
        if (!document.getElementById('formAnimations')) {
            const style = document.createElement('style');
            style.id = 'formAnimations';
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translate(-50%, -20px); }
                    to { opacity: 1; transform: translate(-50%, 0); }
                }
                @keyframes fadeOut {
                    from { opacity: 1; transform: translate(-50%, 0); }
                    to { opacity: 0; transform: translate(-50%, -20px); }
                }
                .global-error {
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    padding: 15px 25px;
                    border-radius: 5px;
                    background-color: #f8d7da;
                    color: #721c24;
                    border: 1px solid #f5c6cb;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    z-index: 1000;
                    animation: fadeIn 0.3s ease-in-out;
                    display: flex;
                    align-items: center;
                }
                .global-error i {
                    margin-right: 10px;
                }
            `;
            document.head.appendChild(style);
        }
    });

    // Afficher le nom du fichier sélectionné
    function displayFileName(e) {
        const fileName = e.target.files[0]?.name || 'Aucun fichier sélectionné';
        document.getElementById('fileName').textContent = `Fichier sélectionné : ${fileName}`;
    }

    // Mettre à jour la barre de progression
    function updateProgressBar() {
        const progressPercentage = (currentStep / totalSteps) * 100;
        document.getElementById('progressBar').style.width = `${progressPercentage}%`;
    }

    // Passer à l'étape suivante
    function nextStep(current, next) {
        if (validateStep(current)) {
            document.getElementById(`step${current}`).classList.remove('active');
            document.getElementById(`step${next}`).classList.add('active');
            currentStep = next;
            updateProgressBar();
            scrollToTop();
        }
    }

    // Revenir à l'étape précédente
    function prevStep(current, prev) {
        document.getElementById(`step${current}`).classList.remove('active');
        document.getElementById(`step${prev}`).classList.add('active');
        currentStep = prev;
        updateProgressBar();
        scrollToTop();
    }

    // Valider les champs de l'étape actuelle
    function validateStep(step) {
        const stepElement = document.getElementById(`step${step}`);
        const inputs = stepElement.querySelectorAll('[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.classList.add('invalid');
                const errorElement = input.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error')) {
                    errorElement.style.display = 'block';
                }
                isValid = false;
                
                // Animation d'erreur
                input.animate([
                    { transform: 'translateX(0)' },
                    { transform: 'translateX(-5px)' },
                    { transform: 'translateX(5px)' },
                    { transform: 'translateX(0)' }
                ], {
                    duration: 300,
                    iterations: 3
                });
            }
        });

        return isValid;
    }

    // Faire défiler vers le haut du formulaire
    function scrollToTop() {
        document.querySelector('.form-container').scrollIntoView({
            behavior: 'smooth'
        });
    }

    // Gestion de la soumission du formulaire
  document.getElementById('candidatureForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!validateStep(4)) {
        showError('Veuillez corriger les erreurs avant soumission');
        return;
    }

    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.btn-submit');
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
    submitBtn.disabled = true;

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        // Debug: Afficher la réponse brute
        const responseText = await response.text();
        console.log('Réponse brute:', responseText);
        
        let data;
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            throw new Error('Réponse serveur invalide');
        }

        if (!response.ok) {
            throw new Error(data.message || `Erreur serveur (${response.status})`);
        }

        form.style.display = 'none';
        document.getElementById('confirmation').style.display = 'block';
        
    } catch (error) {
        console.error('Erreur complète:', error);
        showError(error.message || 'Échec de la connexion au serveur');
    } finally {
        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Envoyer ma candidature';
        submitBtn.disabled = false;
    }
});


    // Afficher un message d'erreur
    function showError(message) {
        // Supprimer les anciens messages d'erreur
        const oldError = document.querySelector('.global-error');
        if (oldError) oldError.remove();
        
        // Créer et afficher le nouveau message
        const errorElement = document.createElement('div');
        errorElement.className = 'global-error';
        errorElement.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            ${message}
        `;
        
        document.body.appendChild(errorElement);
        
        // Disparaître après 5 secondes
        setTimeout(() => {
            errorElement.style.animation = 'fadeOut 0.3s ease-in-out';
            setTimeout(() => errorElement.remove(), 300);
        }, 5000);
    }
</script>
</body>
</html>