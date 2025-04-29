@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')

<style>
    .catalog-container {
        margin: 30px 0;
    }

    .catalog-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 30px;
        color: #0056b3;
    }

    .catalog-item {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .catalog-item:hover {
        transform: translateY(-5px);
    }
body {
        font-family: 'Times New Roman', Times, serif;
    }
    .catalog-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .catalog-content {
        padding: 15px;
    }

    .catalog-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .catalog-desc {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .catalog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-top: 1px solid #eee;
    }

    .catalog-date {
        color: #777;
        font-size: 13px;
    }

    .btn-consult {
        background-color: #0056b3;
        color: white;
        padding: 6px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .btn-consult:hover {
        background-color: #003d80;
        text-decoration: none;
        color: white;
    }
    
</style>

<div class="container catalog-container">
    <h2 class="catalog-title">Catalogues pour le secteur : {{ $secteur_activite }}</h2>

    <div class="row">
        @forelse($catalogue as $catalogue)
            <div class="col-md-4">
                <div class="catalog-item">
                    @if($catalogue->image)
                        <img src="{{ asset('assets/images/formations/' . $catalogue->image) }}" alt="{{ $catalogue->titre }}" class="catalog-image">
                    @endif

                    <div class="catalog-content">
                        <h4 class="catalog-title">{{ $catalogue->titre }}</h4>
                        <p class="catalog-desc">{{ $catalogue->description }}</p>
                    </div>

                    <div class="catalog-footer">
                        <span class="catalog-date">
                            {{ \Carbon\Carbon::parse($catalogue->created_at)->locale('fr')->translatedFormat('d F Y') }}
                        </span>
                        <a href="{{ route('catalogue.show', ['id' => $catalogue->id]) }}" class="btn btn-primary">
    CONSULTER »
</a>

                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Aucun catalogue disponible pour ce secteur.</p>
        @endforelse
    </div>
</div>


<hr>
<hr>

    <div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-primary text-center py-4">
            <h3 class="mb-0">Découvrez nos offres exclusives</h3>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">✔ Accès à la CVthèque</li>
                        <li class="list-group-item">✔ Page de services</li>
                        <li class="list-group-item">✔ Page d'événements</li>
                        <li class="list-group-item">✔ Visibilité dès l’inscription</li>
                        <li class="list-group-item">✔ Messagerie instantanée</li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">✔ Campagnes SMS</li>
                        <li class="list-group-item">✔ Campagnes Email</li>
                        <li class="list-group-item">✔ Campagnes d’affichage</li>
                        <li class="list-group-item">✔ Assistance de 6 mois</li>
                        <li class="list-group-item">✔ Marché public/privé</li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">✔ Conception de sites web</li>
                        <li class="list-group-item">✔ Développement d'applications</li>
                        <li class="list-group-item">✔ Développement de logiciels</li>
                        <li class="list-group-item">✔ Gestion de sites web</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer text-center py-4">
            <a href="{{ route('pages.services') }}" class="btn btn-lg btn-primary px-5">
                💼 Souscrire maintenant
            </a>
        </div>
    </div>
</div>
@endsection
