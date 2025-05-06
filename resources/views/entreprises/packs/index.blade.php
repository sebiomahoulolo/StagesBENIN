@extends('layouts.entreprises.master')
@section('content')

<style>
    /* Packs Section */
    .container {
        margin-top: 10px;
        margin-bottom: 19px;
    }

    .section-subtitle {
        text-align: center;
        font-size: 2rem;
        font-weight: 700;
        color: black;
        margin-bottom: 40px;
    }

    /* Styles pour les Packs Entreprises */
    .content {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .pack {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        text-align: left;
        flex: 1 1 100%;
        min-width: 280px;
        max-width: 100%;
        margin: 0 0 20px 0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .pack:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    .pack h1 {
        background: rgb(26, 18, 117);
        color: white;
        padding: 12px 15px;
        text-align: center;
        border-radius: 5px 5px 0 0;
        font-size: 1.4rem;
        margin: -20px -20px 15px -20px;
    }

    .pack h2 {
        color: #0000ff;
        text-align: center;
        font-size: 1.1rem;
        border-bottom: 2px solid #0000ff;
        padding-bottom: 8px;
        margin-bottom: 15px;
        margin-top: 0;
    }

    .pack .price {
        font-weight: bold;
        color: black;
        text-align: center;
        margin: 15px 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: baseline;
        gap: 5px 10px;
        font-size: 0.9rem;
    }

    .pack .old-price {
        text-decoration: line-through;
        color: red;
        font-size: 1rem;
        margin-right: 5px;
    }

    .pack .price span:not(.old-price) {
        font-size: 1.2rem;
        color: #000;
    }

    .pack .price span[style*="color:red"] {
        font-size: 1.2rem;
        font-weight: bold;
        color: red !important;
    }

    .pack-features {
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 0.85rem;
        flex-grow: 1;
        margin-bottom: 15px;
    }

    .pack-features li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        line-height: 1.5;
    }

    .pack-features li:last-child {
        border-bottom: none;
    }

    .btn-subscribe {
        display: block;
        text-align: center;
        background: rgb(26, 18, 117);
        color: white !important;
        text-decoration: none !important;
        padding: 12px 15px;
        border-radius: 5px;
        margin-top: auto;
        font-weight: bold;
        transition: background 0.3s ease, transform 0.2s ease;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
    }

    .btn-subscribe:hover {
        background: rgb(31, 15, 71);
        transform: translateY(-2px);
        color: white !important;
        text-decoration: none !important;
    }

    .badge-custom {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 15px;
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
        font-weight: bold;
    }

    /* Media Queries */
    @media (min-width: 768px) {
        .pack {
            flex: 1 1 calc(33.333% - 14px);
            max-width: calc(33.333% - 14px);
            padding: 25px;
            margin: 0;
        }
        .pack h1 { font-size: 1.8rem; margin: -25px -25px 20px -25px; }
        .pack h2 { font-size: 1.4rem; }
        .pack .price { font-size: 1rem; }
        .pack .old-price { font-size: 1.1rem; }
        .pack .price span:not(.old-price) { font-size: 1.5rem; }
        .pack .price span[style*="color:red"] { font-size: 1.5rem; }
        .pack-features { font-size: 0.9rem; }
        .pack-features li { padding: 10px 0; }
        .btn-subscribe { padding: 14px 20px; font-size: 1rem; }
    }

    @media (min-width: 992px) {
        .pack {
            padding: 30px;
        }
        .pack h1 { font-size: 2rem; margin: -30px -30px 25px -30px; }
        .pack h2 { font-size: 1.6rem; }
        .pack .price { font-size: 1.1rem; }
        .pack .old-price { font-size: 1.3rem; }
        .pack .price span:not(.old-price) { font-size: 1.8rem; }
        .pack .price span[style*="color:red"] { font-size: 1.8rem; }
        .pack-features { font-size: 1rem; }
        .pack-features li { padding: 12px 0; }
        .btn-subscribe { padding: 15px 25px; font-size: 1.1rem; }
    }
</style>

<div class="container">
    <h6 class="section-subtitle">Découvrez nos packs conçus sur mesure pour répondre aux besoins de votre entreprise</h6>

    <!-- Pack 1 Row -->
    <div class="content">
        <div class="pack">
            <h1>Pack 1</h1>
            <p class="price"><span class="old-price">30 000F</span> <span>15 000F</span> / ANNÉE</p>
            <ul class="pack-features">
                <li>✓ La CVthèque</li>
                <li>✓ Page de services</li>
                <li>✓ Page d'événements</li>
                <li>✓ Visibilité dès l'inscription</li>
                <li>✓ Messagerie instantanée</li>
            </ul>
            <a href="#" class="btn-subscribe">Souscrire</a>
        </div>
        <div class="pack">
            <h2>AVANTAGES</h2>
            <ul class="pack-features">
                <li>✓ Accès aux profils disponibles dans la CV thèque</li>
                <li>✓ Possibilité de partager son activité, service ou produit</li>
            </ul>
        </div>
        <div class="pack">
            <h2>LIMITES</h2>
            <ul class="pack-features">
                <li>✓ Recrutement de personnel et stagiaire facturé</li>
                <li>✓ Page de service limitée Visibilité limitée</li>
            </ul>
        </div>
    </div>

    <!-- Pack 2 Row -->
    <div class="content">
        <div class="pack">
            <h1>Pack 2</h1>
            <p class="price"><span class="old-price">100 000F</span> <span>60 000F</span> / ANNÉE</p>
            <ul class="pack-features">
                <li>✓ La CVthèque</li>
                <li>✓ Page de services</li>
                <li>✓ Page d'événements</li>
                <li>✓ Visibilité dès l'inscription</li>
                <li>✓ Messagerie instantanée</li>
                <li>✓ Campagne SMS</li>
                <li>✓ Campagne Email</li>
                <li>✓ Campagne affiche</li>
                <li>✓ Assistance de 6 mois</li>
            </ul>
            <a href="#" class="btn-subscribe">Souscrire</a>
        </div>
        <div class="pack">
            <h2>AVANTAGES</h2>
            <ul class="pack-features">
                <li>✓ Accès aux profils disponibles dans la CV thèque</li>
                <li>✓ Possibilité de partager son activité, service ou produit</li>
                <li>✓ Accès aux campagnes SMS, email et affiche</li>
            </ul>
        </div>
        <div class="pack">
            <h2>LIMITES</h2>
            <ul class="pack-features">
                <li>✓ Recrutement de personnel et stagiaire facturé</li>
                <li>✓ Page de service limitée Visibilité limitée</li>
                <li>✓ Campagnes SMS, Email et affiche limitées</li>
            </ul>
        </div>
    </div>

    <!-- Pack 3 Row -->
    <div class="content">
        <div class="pack">
            <span class="badge badge-custom bg-info text-white">Populaire</span>
            <h1>Pack 3</h1>
            <p class="price"><span class="old-price">180 000F</span> <span>120 000F</span> / ANNÉE</p>
            <ul class="pack-features">
                <li>✓ La CVthèque</li>
                <li>✓ Page de services</li>
                <li>✓ Page d'événements</li>
                <li>✓ Visibilité dès l'inscription</li>
                <li>✓ Messagerie instantanée</li>
                <li>✓ Campagne SMS</li>
                <li>✓ Campagne Email</li>
                <li>✓ Campagne affiche</li>
                <li>✓ Assistance de 6 mois</li>
                <li>✓ Page marché public/privé</li>
            </ul>
            <a href="#" class="btn-subscribe">Souscrire</a>
        </div>
        <div class="pack">
            <h2>AVANTAGES</h2>
            <ul class="pack-features">
                <li>✓ Accès aux meilleurs profils de la CV thèque et recrutement non facturé</li>
                <li>✓ Accès à six pages de service où détailler ces activités et produits</li>
                <li>✓ Visibilité illimitée</li>
                <li>✓ Donne l'accès aux appels d'offre</li>
                <li>✓ Suivi et accompagnement de 6 mois</li>
                <li>✓ Campagnes SMS, email et affiche illimités</li>
            </ul>
        </div>
        <div class="pack">
            <h2>LIMITES</h2>
            <ul class="pack-features">
                <li>✓ Pas d'accès à un site personnalisé</li>
            </ul>
        </div>
    </div>

    <!-- Pack 4 Row -->
    <div class="content">
        <div class="pack">
            <span class="badge badge-custom bg-danger text-white">Recommandé</span>
            <h1>Pack 4</h1>
            <p class="price"> <span style="color:red">Prix sur mesure</span> / ANNÉE</p>
            <ul class="pack-features">
                <li>✓ La CVthèque</li>
                <li>✓ Page de services</li>
                <li>✓ Page d'événements</li>
                <li>✓ Visibilité dès l'inscription</li>
                <li>✓ Messagerie instantanée</li>
                <li>✓ Campagne SMS</li>
                <li>✓ Campagne Email</li>
                <li>✓ Campagne affiche</li>
                <li>✓ Assistance de 6 mois</li>
                <li>✓ Page marché public/privé</li>
                <li>✓ Conception des sites web</li>
                <li>✓ Application et Logiciel</li>
                <li>✓ Gestion des sites</li>
            </ul>
            <a href="#" class="btn-subscribe">Souscrire</a>
        </div>
        <div class="pack">
            <h2>AVANTAGES</h2>
            <ul class="pack-features">
                <li>✓ Accès aux meilleurs profils de la CV thèque et recrutement non facturé</li>
                <li>✓ Accès à six pages de service où détailler ces activités et produits</li>
                <li>✓ Visibilité illimitée</li>
                <li>✓ Donne l'accès aux appels d'offre</li>
                <li>✓ Suivi et accompagnement de 6 mois</li>
                <li>✓ Campagnes SMS, email et affiche illimités</li>
                <li>✓ Conception et gestion de site web</li>
            </ul>
        </div>
        <div class="pack">
            <h2>LIMITES</h2>
            <ul class="pack-features">
                <li>✓ Néant</li>
            </ul>
        </div>
    </div>
</div>

@endsection