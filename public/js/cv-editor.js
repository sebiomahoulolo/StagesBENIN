// ==================================
// public/js/cv-editor.js
// ==================================

// Fonction utilitaire pour debounce (gardée si besoin ailleurs, non utilisée ici)
// function debounce(func, wait) { ... }

document.addEventListener('alpine:init', () => {
    console.log("[cv-editor.js] Alpine initializing...");

    Alpine.data('cvEditorData', () => ({
        // -------- Propriétés --------
        etudiant: { nom: '', prenom: '', email: '', telephone: '', photo_path: '' },
        cv: {
            profile: {
                id: null, titre_profil: '', resume_profil: '', adresse: '', telephone_cv: '', email_cv: '',
                linkedin_url: '', portfolio_url: '', photo_cv_path: null,
                // Initialiser comme tableaux vides par défaut
                formations: [], experiences: [], competences: [], langues: [], centres_interet: [], certifications: [], projets: []
            }
        },
        errors: {}, // { itemKey: { field: ['message1', 'message2'] } } OU { profile: { field: [...] } }
        loading: {}, // { profile: bool, 'f_key': bool, 'e_key': bool, ... }
        generalMessage: { type: '', text: '' }, // { type: 'success'|'error', text: '...' }
        urls: { profile: '', formations: '', experiences: '', competences: '', langues: '', centres_interet: '', certifications: '', projets: '' },
        selectedPhotoFile: null,
        photoPreviewUrl: null,
        // debouncedUpdatePreview: null, // Retiré

        // -------- Méthode d'Initialisation --------
        init() {
            console.log("[cv-editor.js] init() called.");
            try {
                // Récupérer les URLs depuis les data-attributes
                this.urls.profile = this.$el.dataset.profileUrl;
                this.urls.formations = this.$el.dataset.formationsUrl;
                this.urls.experiences = this.$el.dataset.experiencesUrl;
                this.urls.competences = this.$el.dataset.competencesUrl;
                this.urls.langues = this.$el.dataset.languesUrl;
                this.urls.centres_interet = this.$el.dataset.centresInteretUrl;
                this.urls.certifications = this.$el.dataset.certificationsUrl;
                this.urls.projets = this.$el.dataset.projetsUrl;
                console.log("[cv-editor.js] AJAX URLs loaded:", JSON.parse(JSON.stringify(this.urls)));

                let initialCvData = null;
                const cvDataAttr = this.$el.dataset.cvData;
                if (!cvDataAttr) {
                    console.error("[cv-editor.js] data-cv-data attribute is missing or empty!");
                    this.setGeneralMessage('error', 'Erreur critique : Données initiales du CV manquantes.');
                    return; // Stop initialization
                }

                initialCvData = JSON.parse(cvDataAttr);
                console.log("[cv-editor.js] Raw initial data:", JSON.parse(JSON.stringify(initialCvData)));

                // Initialisation robuste des données
                this.etudiant = initialCvData?.etudiant || { nom: 'N/A', prenom: 'N/A', email: '', telephone: '', photo_path: '' }; // Provide defaults
                const initialProfile = initialCvData?.profile || {}; // Handle null profile gracefully

                // Utiliser les valeurs initiales ou les valeurs par défaut du profil
                this.cv.profile = {
                    ...this.cv.profile, // Garde les valeurs par défaut (tableaux vides)
                    ...initialProfile, // Écrase avec les données reçues
                    id: initialProfile.id || null, // Assure que l'ID est bien récupéré
                    titre_profil: initialProfile.titre_profil || '',
                    resume_profil: initialProfile.resume_profil || '',
                    adresse: initialProfile.adresse || '',
                    telephone_cv: initialProfile.telephone_cv || '',
                    email_cv: initialProfile.email_cv || '',
                    linkedin_url: initialProfile.linkedin_url || '',
                    portfolio_url: initialProfile.portfolio_url || '',
                    photo_cv_path: initialProfile.photo_cv_path || null,
                    // Mapper les tableaux, en s'assurant qu'ils existent et en générant des clés
                    // S'assurer que même si initialProfile.formations est null/undefined, on obtient []
                    formations: (initialProfile.formations || []).map((item, i) => ({ ...item, key: this._generateKey('f', item.id || i), isNew: !item.id })),
                    experiences: (initialProfile.experiences || []).map((item, i) => ({ ...item, key: this._generateKey('e', item.id || i), isNew: !item.id })),
                    competences: (initialProfile.competences || []).map((item, i) => ({ ...item, key: this._generateKey('c', item.id || i), isNew: !item.id })),
                    langues: (initialProfile.langues || []).map((item, i) => ({ ...item, key: this._generateKey('l', item.id || i), isNew: !item.id })),
                    centres_interet: (initialProfile.centres_interet || []).map((item, i) => ({ ...item, key: this._generateKey('i', item.id || i), isNew: !item.id })),
                    certifications: (initialProfile.certifications || []).map((item, i) => ({ ...item, key: this._generateKey('cert', item.id || i), isNew: !item.id })),
                    projets: (initialProfile.projets || []).map((item, i) => ({ ...item, key: this._generateKey('p', item.id || i), isNew: !item.id })),
                };

                console.log('[cv-editor.js] Final Alpine cv.profile object after init:', JSON.parse(JSON.stringify(this.cv.profile)));

                // Initialisation Trix après que le DOM est prêt et les données chargées
                this.$nextTick(() => {
                    this.initializeTrixEditor('profile_resume_editor', this.cv.profile.resume_profil);
                    this.cv.profile.formations.forEach((item, index) => {
                        this.initializeTrixEditor(`form_desc_editor_${index}`, item.description);
                    });
                    this.cv.profile.experiences.forEach((item, index) => {
                        this.initializeTrixEditor(`exp_desc_editor_${index}`, item.description);
                        this.initializeTrixEditor(`exp_taches_editor_${index}`, item.taches_realisations);
                    });
                    this.cv.profile.projets.forEach((item, index) => {
                        this.initializeTrixEditor(`proj_desc_editor_${index}`, item.description);
                    });
                    console.log('[cv-editor.js] Trix editors initialization attempted.');
                });

            } catch (e) {
                console.error("[cv-editor.js] Critical Error during initialization:", e);
                this.setGeneralMessage('error', `Erreur critique lors de l'initialisation de l'éditeur: ${e.message}`);
                // On pourrait vouloir bloquer l'UI ici ou afficher un message plus proéminent
            }
        },

        // Helper pour initialiser Trix (plus robuste)
        initializeTrixEditor(editorId, content) {
            const editorElement = document.getElementById(editorId);
            if (editorElement && editorElement.editor) {
                // Vérifier si le contenu actuel est différent pour éviter boucle infinie
                if (editorElement.value !== content) {
                     editorElement.editor.loadHTML(content || ''); // Utiliser loadHTML pour Trix
                     console.log(`[cv-editor.js] Initialized Trix content for #${editorId}`);
                }
            } else {
                 // Peut arriver si $nextTick n'est pas suffisant ou ID incorrect
                 // console.warn(`[cv-editor.js] Trix editor #${editorId} not found or not ready during init.`);
                 // Tentative de réessayer après un court délai
                 setTimeout(() => {
                     const editorElementRetry = document.getElementById(editorId);
                      if (editorElementRetry && editorElementRetry.editor) {
                           if (editorElementRetry.value !== content) {
                                editorElementRetry.editor.loadHTML(content || '');
                                console.log(`[cv-editor.js] Initialized Trix content for #${editorId} (on retry)`);
                           }
                       } else {
                           console.error(`[cv-editor.js] Failed to initialize Trix editor #${editorId} even after retry.`);
                       }
                 }, 500);
            }
        },

        // -------- Gestion des Messages & Erreurs --------
        setGeneralMessage(type, text, duration = 5000) {
             console.log(`[Msg] ${type}: ${text}`);
             this.generalMessage.type = type;
             this.generalMessage.text = text;
             if (duration > 0) {
                 setTimeout(() => this.clearGeneralMessage(), duration);
             }
        },
        clearGeneralMessage() { this.generalMessage.text = ''; this.generalMessage.type = ''; },
        clearErrors(itemKey = null) {
            if (itemKey) {
                delete this.errors[itemKey];
                 // Force Alpine reactivity if needed, though direct delete should work
                 this.errors = { ...this.errors };
            } else {
                this.errors = {}; // Clear all errors
            }
            console.log(`[Errors] Cleared for ${itemKey || 'all'}. Current errors:`, JSON.parse(JSON.stringify(this.errors)));
        },
        getErrorMessage(itemKey, fieldName) {
            return this.errors[itemKey]?.[fieldName]?.[0] || ''; // Prend seulement le premier message
        },
        hasError(itemKey, fieldName) {
            return !!this.errors[itemKey]?.[fieldName];
        },
        // Helper pour générer URL assets (utile pour photo)
         assetUrl(path) {
             if (!path) return '';
             // Assume '/storage/' prefix needs to be added if not present, adjust base URL if needed
             const baseUrl = window.location.origin; // Or use a specific base path if deployed in subfolder
             // Check if path already starts with http or /storage
             if (path.startsWith('http') || path.startsWith('/storage')) {
                 return path;
             }
             // Assuming path is like 'cv_photos/xyz.jpg' and needs '/storage/' prefix
             return `${baseUrl}/storage/${path.replace(/^\//, '')}`; // Ensure no double slash
        },

        // -------- Générateur de Clé Unique --------
        _generateKey(prefix = 'item', suffix = '') {
             // suffix can be an ID or an index
             return `${prefix}_${suffix}_${Date.now()}_${Math.random().toString(36).substring(2, 7)}`;
        },

        // -------- Moteur AJAX Générique --------
        async _sendAjaxRequest(url, method, data, itemKeyOrSection = 'general', isFormData = false) {
            const loadingKey = itemKeyOrSection === 'profile' || itemKeyOrSection === 'photo' ? 'profile' : itemKeyOrSection;
            console.log(`[AJAX] Sending ${method} to ${url} for key '${loadingKey}'`, data);

            this.loading[loadingKey] = true; // Indicate loading START
            this.clearGeneralMessage(); // Clear previous general messages
            // Clear errors specifically for the item/section being saved
            if(itemKeyOrSection !== 'general') {
                this.clearErrors(itemKeyOrSection);
            }

            const headers = {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            
            // Only set Content-Type if not sending FormData (browser sets it automatically with boundary)
            if (!isFormData) {
                headers['Content-Type'] = 'application/json';
                headers['Accept'] = 'application/json';
            }

            let responseData = null;

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: headers,
                    credentials: 'same-origin', // Ajouter pour s'assurer que les cookies sont envoyés
                    body: isFormData ? data : JSON.stringify(data) // Send FormData directly, stringify JSON
                });

                // Try to parse JSON regardless of status code first to get error details
                try {
                    responseData = await response.json();
                    console.log(`[AJAX] Response received for ${loadingKey}:`, response.status, responseData);
                } catch (e) {
                    // Handle cases where response is not JSON (e.g., HTML error page)
                     console.error(`[AJAX] Failed to parse JSON response for ${loadingKey}. Status: ${response.status}. Response text might follow.`);
                     // Try reading response text for debugging if possible
                     try {
                        const textResponse = await response.text();
                        console.error("[AJAX] Response Text:", textResponse.substring(0, 500)); // Log first 500 chars
                     } catch (textErr) {
                        console.error("[AJAX] Could not read response text.");
                     }
                     // Throw a more specific error
                     throw new Error(`Le serveur a répondu de manière inattendue (Statut ${response.status}). Vérifiez la console du navigateur et l'onglet Réseau.`);
                }

                if (!response.ok) {
                     // Handle HTTP errors (4xx, 5xx)
                     if (response.status === 422 && responseData?.errors) {
                         // Validation errors
                         console.warn(`[AJAX] Validation failed for ${loadingKey}:`, responseData.errors);
                         // Store errors under the specific item key or 'profile'
                         this.errors[itemKeyOrSection] = responseData.errors;
                         this.setGeneralMessage('error', 'Veuillez corriger les erreurs dans le formulaire.', 0); // Persistent message
                     } else {
                         // Other errors (403, 404, 500, etc.)
                         const errorMsg = responseData?.message || `Erreur ${response.status} lors de la communication avec le serveur.`;
                         console.error(`[AJAX] Server error for ${loadingKey}:`, errorMsg);
                         this.setGeneralMessage('error', errorMsg);
                     }
                     // Toujours mettre fin au chargement
                     this.loading[loadingKey] = false;
                     return null; // Indicate failure
                }

                // --- Success (response.ok) ---
                const successMsg = responseData?.message || 'Opération réussie !';
                this.setGeneralMessage('success', successMsg);
                
                // Mettre fin au chargement
                this.loading[loadingKey] = false;
                
                // Retourner les données
                return responseData;
            } catch (error) {
                console.error(`[AJAX] Exception for ${loadingKey}:`, error);
                this.setGeneralMessage('error', `Erreur: ${error.message}`);
                
                // Toujours mettre fin au chargement
                this.loading[loadingKey] = false;
                return null;
            }
        },

        // -------- Gestion Profil Général (Section Info) --------
        async saveProfile() {
            console.log("[cv-editor.js] saveProfile called");

            // Gather form data for profile
            try {
                // Create basic profile data object (non-file fields)
                const profileData = {
                    id: this.cv.profile.id, // Even if null, this is OK - it means "create new"
                    titre_profil: this.cv.profile.titre_profil,
                    resume_profil: this.cv.profile.resume_profil,
                    adresse: this.cv.profile.adresse,
                    telephone_cv: this.cv.profile.telephone_cv,
                    email_cv: this.cv.profile.email_cv,
                    linkedin_url: this.cv.profile.linkedin_url,
                    portfolio_url: this.cv.profile.portfolio_url,
                    // photo_cv_path is handled separately
                };

                // Determine proper HTTP method (PUT for update)
                const method = 'PUT'; // Always PUT for profile
                
                // Send as regular JSON (non-FormData) - photo is handled separately
                const response = await this._sendAjaxRequest(
                    this.urls.profile,
                    method,
                    profileData,
                    'profile',
                    false // Not FormData
                );
                
                // If successful and there's a returned profile, update our local state
                if (response && response.profile) {
                    // Update profile with returned data (including any server-side changes)
                    Object.assign(this.cv.profile, response.profile);
                    console.log('[cv-editor.js] Profile updated with server response:', response.profile);
                }
                
                return !!response; // true if response exists (success), false otherwise
            } catch (err) {
                console.error("[cv-editor.js] Error in saveProfile:", err);
                this.setGeneralMessage('error', `Erreur lors de la sauvegarde: ${err.message}`);
                return false;
            }
        },

        // -------- Gestion Photo de Profil --------
        handlePhotoUpload(event) {
            const fileInput = event.target;
            if (!fileInput.files || !fileInput.files[0]) {
                console.log("[cv-editor.js] No file selected in photo input");
                this.selectedPhotoFile = null;
                this.photoPreviewUrl = null;
                return;
            }
            
            const file = fileInput.files[0];
            
            // Basic client-side validation
            const maxSizeMB = 2;
            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            
            if (file.size > maxSizeBytes) {
                this.setGeneralMessage('error', `Image trop volumineuse (max ${maxSizeMB}MB)`);
                fileInput.value = ''; // Reset the input
                this.selectedPhotoFile = null;
                this.photoPreviewUrl = null;
                return;
            }
            
            // Accept only certain mime types
            const acceptedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!acceptedTypes.includes(file.type)) {
                this.setGeneralMessage('error', 'Format d\'image non supporté (JPG/PNG uniquement)');
                fileInput.value = ''; // Reset the input
                this.selectedPhotoFile = null;
                this.photoPreviewUrl = null;
                return;
            }
            
            // File is valid, store it and create preview URL
            this.selectedPhotoFile = file;
            
            // Create a preview URL for the image
            this.photoPreviewUrl = URL.createObjectURL(file);
            console.log("[cv-editor.js] Photo selected, preview URL created:", this.photoPreviewUrl);
        },
        
        async uploadPhoto() {
            if (!this.selectedPhotoFile) {
                console.log("[cv-editor.js] No photo file to upload");
                return;
            }
            
            // Create FormData for file upload
            const formData = new FormData();
            formData.append('photo_cv', this.selectedPhotoFile);
            // Add other profile fields to ensure we don't lose data
            formData.append('id', this.cv.profile.id || '');
            formData.append('titre_profil', this.cv.profile.titre_profil || '');
            formData.append('resume_profil', this.cv.profile.resume_profil || '');
            formData.append('adresse', this.cv.profile.adresse || '');
            formData.append('telephone_cv', this.cv.profile.telephone_cv || '');
            formData.append('email_cv', this.cv.profile.email_cv || '');
            formData.append('linkedin_url', this.cv.profile.linkedin_url || '');
            formData.append('portfolio_url', this.cv.profile.portfolio_url || '');
            
            // Send as FormData
            const response = await this._sendAjaxRequest(
                this.urls.profile,
                'PUT',
                formData,
                'photo', // Use 'photo' as section ID
                true // Is FormData
            );
            
            if (response) {
                // Update profile with returned data (including new photo path)
                if (response.profile) {
                    Object.assign(this.cv.profile, response.profile);
                } else if (response.photo_cv_path) {
                    // Fallback if only the path is returned
                    this.cv.profile.photo_cv_path = response.photo_cv_path;
                }
                
                // Reset file input and selected file
                document.getElementById('profile_photo_cv').value = '';
                this.selectedPhotoFile = null;
                
                // Clean up object URL
                if (this.photoPreviewUrl) {
                    URL.revokeObjectURL(this.photoPreviewUrl);
                    this.photoPreviewUrl = null;
                }
                
                console.log('[cv-editor.js] Photo uploaded successfully, path:', this.cv.profile.photo_cv_path);
                return true;
            }
            
            return false;
        },

        // -------- Helpers pour les items (sections répétables) --------
        _addItem(sectionArrayName, defaultItem = {}, prefix = 'item') {
            try {
                // Ensure the array exists
                if (!this.cv.profile[sectionArrayName]) {
                    console.warn(`[cv-editor.js] Array ${sectionArrayName} does not exist, creating it`);
                    this.cv.profile[sectionArrayName] = [];
                }
                
                // Generate a unique key for this item (will be used for optimistic UI)
                const itemKey = this._generateKey(prefix);
                
                // Create new item with defaults, key and isNew flag
                const newItem = { 
                    ...defaultItem, 
                    key: itemKey,
                    isNew: true // Flag to know this is a new, unsaved item
                };
                
                // Add to the array
                this.cv.profile[sectionArrayName].push(newItem);
                
                console.log(`[cv-editor.js] Added new ${sectionArrayName} item:`, newItem);
                
                // Initialize Trix editors if needed
                if (defaultItem.description !== undefined) {
                    // Wait for DOM to be updated
                    this.$nextTick(() => {
                        const index = this.cv.profile[sectionArrayName].length - 1;
                        const editorId = `${prefix === 'f' ? 'form' : prefix === 'e' ? 'exp' : prefix === 'p' ? 'proj' : prefix}_desc_editor_${index}`;
                        this.initializeTrixEditor(editorId, '');
                        
                        // For experiences, also initialize taches_realisations
                        if (prefix === 'e' && defaultItem.taches_realisations !== undefined) {
                            this.initializeTrixEditor(`exp_taches_editor_${index}`, '');
                        }
                    });
                }
                
                return newItem;
            } catch (e) {
                console.error(`[cv-editor.js] Error in _addItem(${sectionArrayName}):`, e);
                this.setGeneralMessage('error', `Erreur lors de l'ajout d'un élément: ${e.message}`);
                return null;
            }
        },
        
        // Helper commun pour la suppression d'item par index (générique)
        _removeItemByIndex(sectionArrayName, index, sectionDisplayName) {
            if (index < 0 || index >= this.cv.profile[sectionArrayName].length) {
                console.error(`[cv-editor.js] Invalid index ${index} for ${sectionArrayName}`);
                return;
            }
            
            const item = this.cv.profile[sectionArrayName][index];
            
            // If the item doesn't have an ID, it's not yet in the database, so just remove it
            if (!item.id) {
                this.cv.profile[sectionArrayName].splice(index, 1);
                console.log(`[cv-editor.js] Removed unsaved ${sectionDisplayName} item at index ${index}`);
                this.setGeneralMessage('success', `${sectionDisplayName} supprimé(e)`);
                return;
            }
            
            // Otherwise, confirm then delete from server
            if (confirm(`Voulez-vous vraiment supprimer cette ${sectionDisplayName} ?`)) {
                this._deleteItem(item, index, sectionArrayName, sectionDisplayName, null, null);
            }
        },
        
        // Méthode générique pour sauvegarder un item (new/edit)
        async _saveItem(item, index, sectionArrayName, validationRules, urlBase, loadingPrefix, trixFields = []) {
            // Create a unique loading key for this save operation
            const loadingKey = `${loadingPrefix}_${item.key}`;
            console.log(`[cv-editor.js] _saveItem for ${sectionArrayName}[${index}] with key ${loadingKey}`, item);
            
            // Validation client-side basic (optional)
            const errors = {};
            let hasErrors = false;
            
            // Only apply validation if validationRules provided
            if (validationRules && Object.keys(validationRules).length > 0) {
                // Simple validation for required fields
                for (const [fieldName, rule] of Object.entries(validationRules)) {
                    if (rule.required && (!item[fieldName] || item[fieldName].trim() === '')) {
                        errors[fieldName] = [`Le champ "${fieldName}" est requis.`];
                        hasErrors = true;
                    }
                }
                
                // Date validation for experiences
                if (sectionArrayName === 'experiences') {
                    if (item.date_debut && item.date_fin && new Date(item.date_debut) > new Date(item.date_fin)) {
                        errors.date_fin = ["La date de fin doit être postérieure à la date de début."];
                        hasErrors = true;
                    }
                }
                
                // Year validation for formations
                if (sectionArrayName === 'formations') {
                    if (item.annee_debut && item.annee_fin && parseInt(item.annee_debut) > parseInt(item.annee_fin)) {
                        errors.annee_fin = ["L'année de fin doit être postérieure à l'année de début."];
                        hasErrors = true;
                    }
                }
            }
            
            // If there are client-side validation errors, stop and display them
            if (hasErrors) {
                this.errors[item.key] = errors;
                this.setGeneralMessage('error', 'Veuillez corriger les erreurs dans le formulaire.');
                return null;
            }
            
            // Prepare data to send (clone to avoid modifying our state directly)
            const itemData = { ...item };
            
            // Remove client-side only properties
            delete itemData.key;
            delete itemData.isNew;
            
            // Determine HTTP method and URL
            const isNew = !itemData.id;
            const method = isNew ? 'POST' : 'PUT';
            let url = urlBase;
            
            // For updates, append ID to the URL
            if (!isNew) {
                url = `${urlBase}/${itemData.id}`;
            }
            
            // Send the request
            const response = await this._sendAjaxRequest(url, method, itemData, item.key, false);
            
            // If successful
            if (response && response.item) {
                // Get the returned item with its new ID etc.
                const updatedItem = response.item;
                
                // Add the key back to the updated item
                updatedItem.key = item.key;
                updatedItem.isNew = false;
                
                // Update our local state - replace the item at the index
                this.cv.profile[sectionArrayName][index] = updatedItem;
                
                // For Trix fields, refresh editors
                if (trixFields.length > 0) {
                    this.$nextTick(() => {
                        trixFields.forEach(fieldName => {
                            const prefix = loadingPrefix === 'f' ? 'form' : loadingPrefix === 'e' ? 'exp' : loadingPrefix === 'p' ? 'proj' : loadingPrefix;
                            const editorId = `${prefix}_${fieldName}_editor_${index}`;
                            this.initializeTrixEditor(editorId, updatedItem[fieldName] || '');
                        });
                    });
                }
                
                console.log(`[cv-editor.js] Updated ${sectionArrayName} item in state:`, updatedItem);
                return updatedItem;
            }
            
            return null;
        },
        
        // Méthode générique pour supprimer un item
        async _deleteItem(item, index, sectionArrayName, sectionDisplayName, urlBase, loadingPrefix) {
            if (!item.id) {
                // Item pas encore enregistré, juste le supprimer localement
                this.cv.profile[sectionArrayName].splice(index, 1);
                this.setGeneralMessage('success', `${sectionDisplayName} supprimé(e).`);
                return true;
            }
            
            // Item avec ID, utiliser API pour supprimer
            const loadingKey = `${loadingPrefix}_${item.key}`;
            
            // URL pour la suppression
            const url = `${urlBase}/${item.id}`;
            
            // Envoyer la requête DELETE
            const response = await this._sendAjaxRequest(url, 'DELETE', {}, loadingKey, false);
            
            if (response) {
                // Supprimer de l'état local
                this.cv.profile[sectionArrayName].splice(index, 1);
                console.log(`[cv-editor.js] Deleted ${sectionArrayName} item with ID ${item.id}`);
                return true;
            }
            
            return false;
        },

        // -------- Formations --------
        addFormation()    { this._addItem('formations', { diplome: '', etablissement: '', ville:'', annee_debut: '', annee_fin: null, description: '' }, 'f'); },
        saveFormation(index) {
            const formation = this.cv.profile.formations[index];
            return this._saveItem(
                formation, index, 'formations',
                { diplome: { required: true }, etablissement: { required: true }, annee_debut: { required: true } },
                this.urls.formations, 'f', ['description']
            );
        },
        deleteFormation(index) { this._deleteItem(this.cv.profile.formations[index], index, 'formations', 'Formation', this.urls.formations, 'f'); },
        
        // -------- Expériences --------
        addExperience()   { this._addItem('experiences', { poste: '', entreprise: '', ville:'', date_debut: '', date_fin: null, description: '', taches_realisations:'' }, 'e'); },
        saveExperience(index){
            const exp = this.cv.profile.experiences[index];
            return this._saveItem(
                exp, index, 'experiences',
                { poste: { required: true }, entreprise: { required: true }, date_debut: { required: true } },
                this.urls.experiences, 'e', ['description', 'taches_realisations']
            );
        },
        deleteExperience(index){ this._deleteItem(this.cv.profile.experiences[index], index, 'experiences', 'Expérience', this.urls.experiences, 'e'); },
        
        // -------- Compétences --------
        addCompetence()   { this._addItem('competences', { categorie: '', nom: '', niveau: 75 }, 'c'); },
        saveCompetence(index){
            const comp = this.cv.profile.competences[index];
            return this._saveItem(
                comp, index, 'competences',
                { categorie: { required: true }, nom: { required: true }, niveau: { required: true } },
                this.urls.competences, 'c'
            );
        },
        deleteCompetence(index){ this._deleteItem(this.cv.profile.competences[index], index, 'competences', 'Compétence', this.urls.competences, 'c'); },
        
        // -------- Langues --------
        addLangue()       { this._addItem('langues', { langue: '', niveau: '' }, 'l'); },
        saveLangue(index)   {
            const lang = this.cv.profile.langues[index];
            return this._saveItem(
                lang, index, 'langues',
                { langue: { required: true }, niveau: { required: true } },
                this.urls.langues, 'l'
            );
        },
        deleteLangue(index)  { this._deleteItem(this.cv.profile.langues[index], index, 'langues', 'Langue', this.urls.langues, 'l'); },
        
        // -------- Centres d'intérêt --------
        addInteret()      { this._addItem('centres_interet',{ nom: '' }, 'i'); },
        saveInteret(index)  {
            const interet = this.cv.profile.centres_interet[index];
            return this._saveItem(
                interet, index, 'centres_interet',
                { nom: { required: true } },
                this.urls.centres_interet, 'i'
            );
        },
        deleteInteret(index){ this._deleteItem(this.cv.profile.centres_interet[index], index, 'centres_interet', 'Centre d\'intérêt', this.urls.centres_interet, 'i'); },
        
        // -------- Certifications --------
        addCertification(){ this._addItem('certifications', { nom: '', organisme: '', annee: null, url_validation:'' }, 'cert'); },
        saveCertification(index){
            const cert = this.cv.profile.certifications[index];
            return this._saveItem(
                cert, index, 'certifications',
                { nom: { required: true }, organisme: { required: true } },
                this.urls.certifications, 'cert'
            );
        },
        deleteCertification(index){ this._deleteItem(this.cv.profile.certifications[index], index, 'certifications', 'Certification', this.urls.certifications, 'cert'); },
        
        // -------- Projets --------
        addProjet()       { this._addItem('projets', { nom: '', url_projet: '', description: '', technologies: '' }, 'p'); },
        saveProjet(index)   {
            const proj = this.cv.profile.projets[index];
            return this._saveItem(
                proj, index, 'projets',
                { nom: { required: true } },
                this.urls.projets, 'p', ['description']
            );
        },
        deleteProjet(index)  { this._deleteItem(this.cv.profile.projets[index], index, 'projets', 'Projet', this.urls.projets, 'p'); },
        
        // -------- Validation Utilitaire --------
         _validateDates(start, end, itemKey, startFieldName, endFieldName, isYear = false, errorsObj) {
            // Skip validation if end date is not provided (can be empty/optional)
            if (!end) return true;
            
            let startVal, endVal;
            
            if (isYear) {
                startVal = parseInt(start);
                endVal = parseInt(end);
            } else {
                startVal = new Date(start);
                endVal = new Date(end);
            }
            
            if (startVal && endVal && startVal > endVal) {
                errorsObj[itemKey] = errorsObj[itemKey] || {};
                errorsObj[itemKey][endFieldName] = [`La ${isYear ? 'année' : 'date'} de fin doit être postérieure à celle de début.`];
                return false;
            }
            
            return true;
        }
    }));
});