@extends('layouts.layout')

@section('title', 'Ajouter un événement - StagesBENIN')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    h2, h4 {
        word-wrap: break-word;
    }

    @media (max-width: 768px) {
        h2 {
            font-size: 1.6rem;
        }
        h4 {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        h2 {
            font-size: 1.4rem;
        }
        h4 {
            font-size: 1.1rem;
        }
    }
</style>

<div class="container py-5">
    <div class="card shadow-lg rounded-4 p-4 animate__animated animate__fadeIn">
        <h2 class="text-center mb-4 text-primary">
            <i class="bi bi-calendar-event me-2 text-primary"></i>Ajouter un Événement
        </h2>

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('errors'))
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach(session('errors')->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


            <!-- Vos Informations -->
            <div class="border-start border-4 border-primary ps-3 mb-4">
                <h4 class="text-primary"><i class="bi bi-person-fill me-2"></i>Vos Informations</h4>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">Nom*</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" required>
                    <div class="invalid-feedback">Veuillez saisir votre nom.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">Prénom*</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" required>
                    <div class="invalid-feedback">Veuillez saisir votre prénom.</div>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Numéro de téléphone*</label>
                <input type="tel" class="form-control" name="phone_number" id="phone_number" required>
                <div class="invalid-feedback">Veuillez saisir un numéro valide.</div>
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">Email*</label>
                <input type="email" class="form-control" name="email" id="email" required>
                <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
            </div>

            <!-- Détails de l’événement -->
            <div class="border-start border-4 border-success ps-3 mb-4">
                <h4 class="text-success"><i class="bi bi-info-circle-fill me-2"></i>Détails de l’Événement</h4>
            </div>

            <div class="mb-3">
                <label for="event_title" class="form-label">Titre de l'événement*</label>
                <input type="text" class="form-control" id="event_title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="event_description" class="form-label">Description</label>
                <textarea class="form-control" id="event_description" name="description" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="event_start_date" class="form-label">Début*</label>
                    <input type="datetime-local" class="form-control" id="event_start_date" name="start_date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="event_end_date" class="form-label">Fin*</label>
                    <input type="datetime-local" class="form-control" id="event_end_date" name="end_date" required>
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
    <option value="Fête">Fête</option>
    <option value="Spectacle">Spectacle</option>
    <option value="Soirée de gala">Soirée de gala</option>
    <option value="Déjeuner d'affaires">Déjeuner d'affaires</option>
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

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="event_requires_ticket" class="form-label">Vente de ticket</label>
                    <select class="form-select" id="event_requires_ticket" name="requires_ticket" onchange="toggleTicketPrice()">
                        <option value="non">Non</option>
                        <option value="oui">Oui</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="ticket_price_container" style="display: none;">
                    <label for="event_ticket_price" class="form-label">Prix du ticket*</label>
                    <input type="number" class="form-control" id="event_ticket_price" name="ticket_price" min="0" step="0.01">
                </div>
            </div>

            <div class="mb-4">
                <label for="event_image" class="form-label">Image (affiche)</label>
                <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
            </div>

            <!-- Bouton d’enregistrement -->
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-success px-5">
                    <i class="bi bi-save2 me-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleTicketPrice() {
        const select = document.getElementById('event_requires_ticket');
        const container = document.getElementById('ticket_price_container');
        const input = document.getElementById('event_ticket_price');
        if (select.value === 'oui') {
            container.style.display = 'block';
            input.required = true;
        } else {
            container.style.display = 'none';
            input.required = false;
        }
    }
</script>
@endsection
