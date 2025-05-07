@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')

@php
    // Récupération des événements publiés uniquement
    $upcomingEvents = App\Models\Event::where('is_published', 1)
                                     ->where('start_date', '>', now())
                                     ->orderBy('start_date', 'asc')
                                     ->take(6)
                                     ->get();
    
    $ongoingEvents = App\Models\Event::where('is_published', 1)
                                    ->where('start_date', '<=', now())
                                    ->where('end_date', '>=', now())
                                    ->orderBy('end_date', 'asc')
                                    ->take(6)
                                    ->get();

    $pastEvents = App\Models\Event::where('is_published', 1)
                                 ->where('end_date', '<', now())
                                 ->orderBy('end_date', 'desc')
                                 ->take(6)
                                 ->get();
    
    $formatDate = function($date) {
        return \Carbon\Carbon::parse($date)->format('d/m/Y à H:i');
    };

    $currentDate = now()->format('d/m/Y à H:i');
@endphp
 
<div class="events-container">
    <div class="current-date">
        <i class="fas fa-calendar-day"></i> Aujourd'hui: {{ $currentDate }}
        <!-- Bouton pour ouvrir le formulaire d'informations utilisateur -->
<div class="action-buttons">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userInfoModal">
        <i class="fas fa-plus-circle me-1"></i> Ajouter Événement
    </button>
</div>

    </div>

<!-- Modal de Confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                Événement enregistré avec succès !<br>
                Attendez la validation par l'administrateur si toutes vos informations sont correctes.<br>
                Merci de passer par <strong>StagesBENIN</strong>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Informations Utilisateur -->
<div class="modal fade" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userInfoModalLabel">Vos Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="userInfoForm" class="needs-validation" novalidate>
                    @csrf <!-- CSRF Token for Laravel -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Nom*</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" required>
                        <div class="invalid-feedback">Veuillez saisir votre nom.</div>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Prénom*</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" required>
                        <div class="invalid-feedback">Veuillez saisir votre prénom.</div>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Numéro de téléphone*</label>
                        <input type="tel" class="form-control" name="phone_number" id="phone_number" required>
                        <div class="invalid-feedback">Veuillez saisir un numéro de téléphone valide.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                        <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="nextStep">Suivant</button>
            </div>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Ajouter un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="eventForm" action="{{ route('events.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf <!-- CSRF Token for Laravel -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="event_title" class="form-label">Titre de l'événement*</label>
                        <input type="text" class="form-control" id="event_title" name="title" required>
                        <div class="invalid-feedback">Veuillez saisir un titre.</div>
                    </div>
                    <div class="mb-3">
                        <label for="event_description" class="form-label">Description</label>
                        <textarea class="form-control" id="event_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_start_date" class="form-label">Date et heure de début*</label>
                            <input type="datetime-local" class="form-control" id="event_start_date" name="start_date" required>
                            <div class="invalid-feedback">Veuillez saisir une date de début valide.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="event_end_date" class="form-label">Date et heure de fin*</label>
                            <input type="datetime-local" class="form-control" id="event_end_date" name="end_date" required>
                            <div class="invalid-feedback">La date de fin doit être postérieure à la date de début.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="event_location" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="event_location" name="location">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_type" class="form-label">Type d'événement</label>
                            <select class="form-select" id="event_type" name="type">
                                <option value="">Sélectionner un type</option>
                                <option value="Conférence">Conférence</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Salon">Salon</option>
                                <option value="Formation">Formation</option>
                                <option value="Networking">Networking</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="event_max_participants" class="form-label">Nombre max. de participants</label>
                            <input type="number" class="form-control" id="event_max_participants" name="max_participants" min="1">
                        </div>
                    </div>
                    <!-- Début ajout option ticket -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_requires_ticket" class="form-label">Vente de ticket</label>
                            <select class="form-select" id="event_requires_ticket" name="requires_ticket" onchange="toggleTicketPrice()">
                                <option value="non">Non</option>
                                <option value="oui">Oui</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" id="ticket_price_container" style="display: none;">
                            <label for="event_ticket_price" class="form-label">Prix du ticket* </label>
                            <input type="number" class="form-control" id="event_ticket_price" name="ticket_price" min="0" step="0.01" required>
                        </div>
                    </div>
                    <!-- Fin ajout option ticket -->
                    <div class="mb-3">
                        <label for="event_image" class="form-label">Image (affiche)</label>
                        <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary submit-btn" id="submitEvent">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour gérer l'affichage du champ prix -->
<script>
    function toggleTicketPrice() {
        const requiresTicket = document.getElementById('event_requires_ticket').value;
        const priceContainer = document.getElementById('ticket_price_container');
        
        if (requiresTicket === 'oui') {
            priceContainer.style.display = 'block';
        } else {
            priceContainer.style.display = 'none';
            document.getElementById('event_ticket_price').value = '';
        }
    }
    
    // Exécuter au chargement de la page pour initialiser l'état
    document.addEventListener('DOMContentLoaded', function() {
        toggleTicketPrice();
    });
</script>

<script>
// 1. D'abord, modifions le script d'inscription
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer le formulaire d'inscription
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Créer un objet FormData avec les données du formulaire
            const formData = new FormData(this);
            
            // Envoyer la requête AJAX
            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Supprimer les anciens messages d'erreur
                const errorContainer = document.querySelector('#registerModal .error-messages');
                const successContainer = document.querySelector('#registerModal .success-messages');
                
                if (errorContainer) errorContainer.innerHTML = '';
                if (successContainer) successContainer.innerHTML = '';
                
                // Réinitialiser les styles de validation
                const invalidFields = registerForm.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));
                
                // Traiter la réponse
                if (data.errors) {
                    // Afficher les erreurs
                    if (!errorContainer) {
                        // Créer un conteneur pour les erreurs s'il n'existe pas
                        const newErrorContainer = document.createElement('div');
                        newErrorContainer.className = 'error-messages alert alert-danger mt-3';
                        registerForm.prepend(newErrorContainer);
                        
                        // Afficher chaque erreur
                        let errorHtml = '<ul class="mb-0">';
                        Object.keys(data.errors).forEach(field => {
                            // Marquer le champ comme invalide
                            const inputField = registerForm.querySelector(`[name="${field}"]`);
                            if (inputField) inputField.classList.add('is-invalid');
                            
                            // Ajouter le message d'erreur
                            data.errors[field].forEach(message => {
                                errorHtml += `<li>${message}</li>`;
                            });
                        });
                        errorHtml += '</ul>';
                        newErrorContainer.innerHTML = errorHtml;
                    }
                } else if (data.message) {
                    // Afficher le message de succès
                    if (!successContainer) {
                        const newSuccessContainer = document.createElement('div');
                        newSuccessContainer.className = 'success-messages alert alert-success mt-3';
                        registerForm.prepend(newSuccessContainer);
                        newSuccessContainer.textContent = data.message;
                    }
                    
                    // Réinitialiser le formulaire après un court délai
                    setTimeout(() => {
                        registerForm.reset();
                        // Fermer le modal après 2 secondes
                        setTimeout(() => {
                            const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                            if (registerModal) registerModal.hide();
                        }, 2000);
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                
                // Afficher un message d'erreur générique
                const errorContainer = document.querySelector('#registerModal .error-messages') || 
                                     document.createElement('div');
                errorContainer.className = 'error-messages alert alert-danger mt-3';
                errorContainer.textContent = 'Une erreur est survenue lors de l\'inscription.';
                
                if (!document.querySelector('#registerModal .error-messages')) {
                    registerForm.prepend(errorContainer);
                }
            });
        });
    }

    // Script pour le formulaire d'ajout d'événement (userInfoForm et eventForm)
    const userInfoForm = document.getElementById('userInfoForm');
    const eventForm = document.getElementById('eventForm');
    const nextStepBtn = document.getElementById('nextStep');
    
    if (nextStepBtn && userInfoForm) {
        nextStepBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!userInfoForm.checkValidity()) {
                e.stopPropagation();
                userInfoForm.classList.add('was-validated');
                return;
            }

            const userModal = bootstrap.Modal.getInstance(document.getElementById('userInfoModal'));
            const formData = new FormData(userInfoForm);
            window.userFormData = formData;
            
            if (userModal) {
                userModal.hide();
                
                setTimeout(() => {
                    const eventModalInstance = new bootstrap.Modal(document.getElementById('eventModal'));
                    eventModalInstance.show();
                }, 500);
            }
        });
    }
    
    if (eventForm) {
        eventForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            const eventFormData = new FormData(this);
            
            if (window.userFormData) {
                for (let [key, value] of window.userFormData.entries()) {
                    eventFormData.append(key, value);
                }
            }
            
            // Supprimer les anciens messages
            const errorContainer = document.querySelector('#eventModal .error-messages');
            if (errorContainer) errorContainer.remove();

            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: eventFormData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    // Afficher les erreurs dans le modal d'événement
                    const errorContainer = document.createElement('div');
                    errorContainer.className = 'error-messages alert alert-danger mt-3';
                    
                    let errorHtml = '<ul class="mb-0">';
                    Object.keys(data.errors).forEach(field => {
                        // Marquer le champ comme invalide
                        const inputField = eventForm.querySelector(`[name="${field}"]`);
                        if (inputField) inputField.classList.add('is-invalid');
                        
                        // Ajouter le message d'erreur
                        data.errors[field].forEach(message => {
                            errorHtml += `<li>${message}</li>`;
                        });
                    });
                    errorHtml += '</ul>';
                    errorContainer.innerHTML = errorHtml;
                    
                    // Ajouter le conteneur d'erreurs au début du formulaire
                    eventForm.prepend(errorContainer);
                } else if (data.success) {
                    // Fermer le modal d'événement
                    const eventModalInstance = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
                    if (eventModalInstance) {
                        eventModalInstance.hide();
                    }

                    // Réinitialiser les formulaires
                    userInfoForm.reset();
                    eventForm.reset();

                    // Afficher le modal de confirmation
                    setTimeout(() => {
                        const confirmModalInstance = new bootstrap.Modal(document.getElementById('confirmationModal'));
                        confirmModalInstance.show();
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                
                // Afficher un message d'erreur générique
                const errorContainer = document.createElement('div');
                errorContainer.className = 'error-messages alert alert-danger mt-3';
                errorContainer.textContent = 'Une erreur est survenue lors de l\'enregistrement de l\'événement.';
                eventForm.prepend(errorContainer);
            });
        });
    }
    
    // Modal de détails de l'événement
    const detailsModal = document.getElementById('detailsModal');
    if (detailsModal) {
        detailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // Récupérer les données de l'événement
            const eventId = button.getAttribute('data-event-id');
            const title = button.getAttribute('data-title');
            const date = button.getAttribute('data-date');
            const location = button.getAttribute('data-location');
            const description = button.getAttribute('data-description');
            const image = button.getAttribute('data-image');
            
            // Mettre à jour le contenu du modal
            detailsModal.querySelector('#eventTitle').textContent = title;
            detailsModal.querySelector('#eventDate').textContent = date;
            detailsModal.querySelector('#eventLocation').textContent = location || 'Non spécifié';
            
            // Description (courte et complète)
            if (description) {
                const descriptionShort = detailsModal.querySelector('#eventDescriptionShort');
                const descriptionFull = detailsModal.querySelector('#eventDescriptionFull');
                
                descriptionShort.textContent = description.length > 200 ? 
                    description.substring(0, 200) + '...' : description;
                descriptionFull.textContent = description;
                
                // Gérer les boutons voir plus/moins
                const showMoreBtn = detailsModal.querySelector('#showMoreBtn');
                const showLessBtn = detailsModal.querySelector('#showLessBtn');
                
                if (description.length > 200) {
                    showMoreBtn.style.display = 'inline-block';
                } else {
                    showMoreBtn.style.display = 'none';
                }
                
                showMoreBtn.addEventListener('click', function() {
                    descriptionShort.style.display = 'none';
                    descriptionFull.style.display = 'block';
                    showMoreBtn.style.display = 'none';
                    showLessBtn.style.display = 'inline-block';
                });
                
                showLessBtn.addEventListener('click', function() {
                    descriptionShort.style.display = 'block';
                    descriptionFull.style.display = 'none';
                    showMoreBtn.style.display = 'inline-block';
                    showLessBtn.style.display = 'none';
                });
            }
            
            // Image
            const imageUrl = image ? `/images/events/${image}` : '/images/events/NOS-EVENEMENTS-A-VENIR.png';
            detailsModal.querySelector('#eventImage').src = imageUrl;
            
            // Mettre à jour le bouton d'inscription avec l'ID de l'événement
            const registerBtn = detailsModal.querySelector('#modalRegisterBtn');
            if (registerBtn) {
                registerBtn.setAttribute('data-event-id', eventId);
                registerBtn.addEventListener('click', function() {
                    document.querySelector('#registerModal #event_id').value = eventId;
                });
            }
        });
    }
    
    // Validation des dates pour l'événement
    const startDateInput = document.getElementById('event_start_date');
    const endDateInput = document.getElementById('event_end_date');
    
    if (startDateInput && endDateInput) {
        function validateDates() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            if (endDate <= startDate) {
                endDateInput.setCustomValidity('La date de fin doit être postérieure à la date de début');
            } else {
                endDateInput.setCustomValidity('');
            }
        }
        
        startDateInput.addEventListener('change', validateDates);
        endDateInput.addEventListener('change', validateDates);
    }

    // Réinitialiser les validations lors de la fermeture des modals
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            const form = this.querySelector('form');
            if (form) {
                form.classList.remove('was-validated');
                
                // Supprimer les messages d'erreur
                const errorMessages = form.querySelector('.error-messages');
                if (errorMessages) errorMessages.remove();
                
                // Supprimer les messages de succès
                const successMessages = form.querySelector('.success-messages');
                if (successMessages) successMessages.remove();
                
                // Réinitialiser les champs invalides
                const invalidFields = form.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));
            }
        });
    });
});

</script>
    <div class="events-section events-upcoming">
        <h2><i class="fas fa-calendar-alt text-primary"></i> Événements à venir ({{ $upcomingEvents->count() }})</h2>
        
        @if($upcomingEvents->count() > 0)
            <div class="events-list">
                @foreach ($upcomingEvents as $event)
                    <div class="event-card">
                        <div class="event-image">
                            <img src="{{ asset('images/events/' . $event->image) }}" 
                                alt="{{ $event->title }}"
                                onerror="this.src='{{ asset('images/events/NOS-EVENEMENTS-A-VENIR.png') }}'"
                                class="img-fluid event-thumbnail">
                        </div>

                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-date">
                            <i class="fas fa-clock"></i> {{ $formatDate($event->start_date) }}
                            <div class="event-categorie">{{ $event->categorie }}</div>
                        </div>  
                        @if(isset($event->location) && $event->location)
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                            </div>
                        @endif
                        
                        @php
                            $icons = [
                                'conférence' => 'fas fa-microphone',
                                'workshop' => 'fas fa-tools',
                                'salon' => 'fas fa-building',
                                'formation' => 'fas fa-graduation-cap',
                                'networking' => 'fas fa-users',
                                'autre' => 'fas fa-calendar-alt',
                            ];

                            $eventIcon = array_key_exists($event->type, $icons) ? $icons[$event->type] : 'fas fa-calendar-alt';
                        @endphp

                        @if($event->type)
                            <div class="event-type">
                                <i class="{{ $eventIcon }}"></i> {{ ucfirst($event->type) }}
                            </div>
                        @endif
                        
                        <div class="event-countdown">
                            @php
                                $daysUntil = now()->diffInDays(\Carbon\Carbon::parse($event->start_date), false);
                            @endphp
                            @if($daysUntil == 0)
                                <span class="badge badge-warning">Aujourd'hui</span>
                            @elseif($daysUntil == 1)
                                <span class="badge badge-warning">Demain</span>
                            @else
                                <span class="badge badge-info">Dans {{ $daysUntil }} jours</span>
                            @endif

                            <button type="button" class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#detailsModal" 
                                data-event-id="{{ $event->id }}" 
                                data-title="{{ $event->title }}"
                                data-date="{{ $formatDate($event->start_date) }}" 
                                data-location="{{ $event->location }}"
                                data-description="{{ $event->description }}"
                                data-image="{{ $event->image }}">
                                Voir
                            </button>
                        </div>
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="{{ $event->id }}">
                            S'inscrire
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">Aucun événement à venir</div>
        @endif
    </div>

    <div class="events-section events-ongoing">
        <h2><i class="fas fa-play-circle text-primary"></i> Événements en cours ({{ $ongoingEvents->count() }})</h2>
        
        @if($ongoingEvents->count() > 0)
            <div class="events-list highlight">
                @foreach ($ongoingEvents as $event)
                    <div class="event-card active">
                        <div class="event-image">
                            <img src="{{ asset('images/events/' . $event->image) }}" 
                                alt="{{ $event->title }}"
                                onerror="this.src='{{ asset('images/events/1746431303.jpeg') }}'"
                                class="img-fluid event-thumbnail">
                        </div>
                        
                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-period">
                            <i class="fas fa-hourglass-half"></i> Du {{ $formatDate($event->start_date) }} au {{ $formatDate($event->end_date) }}
                        </div>
                        @if(isset($event->location) && $event->location)
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt "></i> {{ $event->location }}
                            </div>
                        @endif
                        <div class="event-status">
                            <span class="badge badge-success">En cours !</span>
                            @php
                                $hoursLeft = now()->diffInHours(\Carbon\Carbon::parse($event->end_date), false);
                            @endphp
                            @if($hoursLeft < 24)
                                <span class="badge badge-danger">Se termine dans {{ $hoursLeft }} heure(s)</span>
                            @endif
                        </div>
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#detailsModal" 
                            data-event-id="{{ $event->id }}" 
                            data-title="{{ $event->title }}"
                            data-date="Du {{ $formatDate($event->start_date) }} au {{ $formatDate($event->end_date) }}" 
                            data-location="{{ $event->location }}"
                            data-description="{{ $event->description }}"
                            data-image="{{ $event->image }}">
                            Consulter
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">Aucun événement en cours</div>
        @endif
    </div>

    <div class="events-section events-past">
        <h2><i class="fas fa-history text-primary"></i> Derniers événements ({{ $pastEvents->count() }})</h2>
        
        @if($pastEvents->count() > 0)
            <div class="events-list faded">
                @foreach ($pastEvents as $event)
                    <div class="event-card past">
                        <div class="event-image">
                            <img src="{{ asset('images/events/' . $event->image) }}" 
                                alt="{{ $event->title }}"
                                onerror="this.src='{{ asset('images/events/th (1).jpeg') }}'"
                                class="img-fluid event-thumbnail">
                        </div>
                        
                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-date">
                            <i class="fas fa-calendar-check"></i> Terminé le {{ $formatDate($event->end_date) }}
                        </div>
                        @if(isset($event->location) && $event->location)
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                            </div>
                        @endif
                        <div class="view-more">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal" 
                                data-event-id="{{ $event->id }}" 
                                data-title="{{ $event->title }}"
                                data-date="Terminé le {{ $formatDate($event->end_date) }}" 
                                data-location="{{ $event->location }}"
                                data-description="{{ $event->description }}"
                                data-image="{{ $event->image }}">
                                <i class="fas fa-archive"></i> Voir les archives
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">Aucun événement passé</div>
        @endif
    </div>

    <!-- Modal Détails de l'Événement -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Détails de l'Événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <img id="eventImage" src="" 
                                alt="Image de l'événement"
                                onerror="this.src='{{ asset('images/events/NOS-EVENEMENTS-A-VENIR.png') }}'"
                                class="img-fluid event-modal-image">
                        </div>
                        <div class="col-md-7">
                            <h4 id="eventTitle" class="mb-3"></h4>
                            <p><strong><i class="fas fa-calendar"></i> Date :</strong> <span id="eventDate"></span></p>
                            <p><strong><i class="fas fa-map-marker-alt"></i> Lieu :</strong> <span id="eventLocation"></span></p>
                            
                            <div class="action-buttons mt-4">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal" id="modalRegisterBtn">
                                    S'inscrire
                                </button>
<!-- Vérification et affichage des boutons pour chaque événement -->
@foreach($events as $event)
    @if(!is_null($event->ticket_price) && $event->ticket_price > 0)
        <button type="button" class="btn btn-outline-primary" id="buy-ticket-btn-{{ $event->id }}" 
                onclick="downloadTicket({{ $event->id }}, '{{ number_format($event->ticket_price, 0, ',', ' ') }}')">
            Acheter un ticket ({{ number_format($event->ticket_price, 0, ',', ' ') }} FCFA)
        </button>
    @endif
@endforeach
</div>

<!-- Script JavaScript pour gérer les téléchargements -->
<script>
    function downloadTicket(eventId, ticketPrice) {
        const button = document.getElementById(`buy-ticket-btn-${eventId}`);

        // Vérifier si le bouton existe avant de le manipuler
        if (!button) {
            console.error("Bouton non trouvé pour l'événement ID : " + eventId);
            return;
        }

        // Désactiver le bouton et afficher un message de chargement
        button.innerHTML = 'Préparation du ticket...';
        button.disabled = true;

        // Création d'un lien invisible pour télécharger le ticket
        const link = document.createElement('a');
        link.href = `{{ url("/events") }}/` + eventId + '/generate-ticket';
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();

        // Restaurer le bouton après un court délai
        setTimeout(() => {
            button.innerHTML = `Acheter un ticket (${ticketPrice} FCFA)`;
            button.disabled = false;
        }, 3000);
    }
</script>


<!-- Alternative avec un formulaire (plus fiable dans certains navigateurs) -->
{{--
@if($event->ticket_price !== null)
    <form action="{{ route('events.generate-ticket', $event->id) }}" method="GET" target="_blank">
        <button type="submit" class="btn btn-outline-primary" id="buy-ticket-btn">
            Acheter un ticket ({{ number_format($event->ticket_price, 0, ',', ' ') }} FCFA)
        </button>
    </form>
@endif
--}}

<!-- Alternative avec la colonne requires_ticket -->
<!-- Si vous stockez à la fois requires_ticket et ticket_price -->
{{-- 
@if($event->requires_ticket == 'oui' && $event->ticket_price !== null)
    <button type="button" class="btn btn-outline-primary" id="buy-ticket-btn">
        Acheter un ticket
    </button>
@endif
--}}

<!-- Si vous utilisez seulement la valeur du ticket pour déterminer si la vente est activée -->
 


                            </div>
                        </div>
                    </div>
                    
                    <!-- Description dans un cadre en bas -->
                    <div class="row">
                        <div class="col-12">
                            <div class="description-card">
                                <h5><i class="fas fa-info-circle"></i> Description</h5>
                                <div class="description-content">
                                    <div id="eventDescriptionShort" class="description-short"></div>
                                    <div id="eventDescriptionFull" class="description-full" style="display: none;"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <button id="showMoreBtn" class="btn btn-sm btn-outline-primary">Voir plus</button>
                                    <button id="showLessBtn" class="btn btn-sm btn-outline-primary" style="display: none;">Voir moins</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'Inscription -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Affichez les erreurs de validation -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<!-- Ajoutez cette balise meta CSRF dans la section head de votre layout -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modifiez la structure du modal d'inscription pour inclure une zone pour les messages d'erreur/succès -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Inscription à l'événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Les messages d'erreur/succès seront insérés ici par JavaScript -->
                <form id="registerForm" method="POST" action="{{ route('events.register.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="event_id" id="event_id" value="">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom *</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        <div class="invalid-feedback">Veuillez saisir votre nom.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function togglePriceField() {
        var sellTickets = document.getElementById('sell_tickets').value;
        var ticketPriceField = document.getElementById('ticket_price_field');

        if (sellTickets === 'oui') {
            ticketPriceField.style.display = 'block';
        } else {
            ticketPriceField.style.display = 'none';
        }
    }
</script>

<!-- Modifier le modal de confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> Événement enregistré avec succès !
                </div>
                <p>Attendez la validation par l'administrateur si toutes vos informations sont correctes.</p>
                <p>Merci de passer par <strong>StagesBENIN</strong>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Ajouter du CSS pour les messages d'erreur/succès -->
<style>
    .error-messages, .success-messages {
        margin-bottom: 15px;
        border-radius: 5px;
    }
    
    .error-messages ul {
        padding-left: 20px;
        margin-bottom: 0;
    }
    
    .modal .alert {
        margin-bottom: 15px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var registerModal = document.getElementById('registerModal');
    if (registerModal) {
        registerModal.addEventListener('show.bs.modal', function (event) {
            // Bouton qui a déclenché le modal
            var button = event.relatedTarget;
            // Extraire l'info depuis les attributs data-*
            var eventId = button.getAttribute('data-event-id'); // Assurez-vous que vos boutons ont bien cet attribut data-event-id="xx"
            // Mettre à jour le champ caché du formulaire
            var eventIdInput = registerModal.querySelector('.modal-body #event_id');
            eventIdInput.value = eventId;

       var invalidFields = registerModal.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => field.classList.remove('is-invalid'));
            var feedbackMessages = registerModal.querySelectorAll('.invalid-feedback');
            feedbackMessages.forEach(msg => msg.textContent = ''); // Vider anciens messages d'erreur spécifiques
        });
    }
});
</script>

<style>
.event-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    margin-bottom: 10px;
    border-radius: 8px;
}

.event-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.event-thumbnail:hover {
    transform: scale(1.05);
}

.event-modal-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.description-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    background-color: #f8f9fa;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    margin-top: 10px;
}

.description-card h5 {
    color: #495057;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #dee2e6;
}

.description-content {
    padding: 0 10px;
}

.description-short {
    max-height: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.description-full {
    max-height: none;
}

.event-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.events-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

@media (max-width: 768px) {
    .events-list {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Ajout des fichiers CSS et JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.0/main.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.0/main.min.js"></script>

<style>
    .events-container {
        font-family: 'Roboto', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .current-date {
        text-align: right;
        color: #666;
        margin-bottom: 20px;
        font-style: italic;
    }
    
    .events-section {
        margin-bottom: 40px;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .events-section:hover {
        transform: translateY(-5px);
    }
    
    .events-section h2 {
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }
    
    .events-upcoming {
        background-color: #f8f9fa;
        border-left: 4px solid #17a2b8;
    }
    
    .events-ongoing {
        background-color: #e8f4ff;
        border-left: 4px solid  #007bff;
    }
    
    .events-past {
        background-color: #f9f9f9;
        border-left: 4px solid #6c757d;
    }
    
    .events-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .event-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    
    .event-card.active {
        border-left: 4px solid #007bff;
    }
    
    .event-card.past {
        opacity: 0.7;
    }
    
    .event-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .event-date, .event-location, .event-period, .event-status, .event-countdown {
        margin-top: 8px;
        font-size: 14px;
        color: #666;
    }
    
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-left: 5px;
    }
    
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge-info {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-danger {
        background-color: #dc3545;
        color: white;
    }
    
    .no-events {
        text-align: center;
        padding: 20px;
        color: #999;
        font-style: italic;
    }
    
    .view-more {
        text-align: center;
        margin-top: 20px;
    }
    
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        transition: all .15s ease-in-out;
    }
    
    .btn-outline-secondary {
        color: #6c757d;
        background-color: transparent;
        background-image: none;
        border-color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .calendar-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .calendar-container h2 {
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }
    
    #calendar {
        margin-top: 20px;
    }
    
    .event-ongoing {
        background-color:  #007bff !important;
        border-color:  #007bff !important;
        color: white !important;
    }
    
    .event-upcoming {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
        color: white !important;
    }
    
    .event-past {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: white !important;
        opacity: 0.7;
    }
    
    @media (max-width: 768px) {
        .events-list {
            grid-template-columns: 1fr;
        }
        
        .events-container, .calendar-container {
            padding: 10px;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection