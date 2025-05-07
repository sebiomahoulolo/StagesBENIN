@extends('layouts.entreprises.master')
@section('content')
<h1 class="dashboard-title">Tableau de bord</h1>

<div class="link-container">
    <!-- Principal -->
    <a href="#" class="styled-link-box">
        <i class="fas fa-newspaper icon-info"></i>
        <span>Actualités</span>
    </a>
    
    <!-- Recrutement - CV-thèque mise en évidence -->
    <a href="{{ route('entreprises.cvtheque.index') }}" class="styled-link-box">
        <i class="fas fa-database icon-primary"></i>
        <span>CV thèque</span>
    </a>
    
    <a href="{{ route('entreprises.annonces.create') }}" class="styled-link-box">
        <i class="fas fa-plus-circle icon-success"></i>
        <span>Publier une annonce</span>
    </a>
    
    <a href="{{ route('entreprises.annonces.index') }}" class="styled-link-box">
        <i class="fas fa-list-alt icon-warning"></i>
        <span>Mes annonces</span>
    </a>

    <a href="{{ route('entreprises.demandes.create') }}" class="styled-link-box">
        <i class="fas fa-user-plus icon-success"></i>
        <span>Demander un employé/stagiaire</span>
    </a>

    <a href="{{ route('entreprises.demandes.index') }}" class="styled-link-box">
        <i class="fas fa-clipboard-list icon-primary"></i>
        <span>Mes demandes d'employés</span>
    </a>
    
    <a href="{{ route('messagerie-sociale.index') }}" class="styled-link-box">
        <i class="fas fa-bullhorn icon-info"></i>
        <span>Canal d'annonces</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-briefcase icon-primary"></i>
        <span>Mes offres disponibles</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-comment-alt icon-danger"></i>
        <span>Entretiens en cours</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-user-check icon-success"></i>
        <span>Campagne SMS</span>
    </a>
    
    <!-- Entreprise -->
    <a href="#" class="styled-link-box">
        <i class="fas fa-tasks icon-warning"></i>
        <span>Campagne Video</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-gavel icon-primary"></i>
        <span>Marchés public/privé</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-graduation-cap icon-danger"></i>
        <span>Demande de stages</span>
    </a>
    
    <!-- Configuration -->
    <a href="{{ route('entreprises.profile.edit') }}" class="styled-link-box">
        <i class="fas fa-credit-card icon-teal"></i>
        <span>Mon abonnement</span>
    </a>
    
    <a href="{{ route('entreprises.packs.index') }}" class="styled-link-box">
        <i class="fas fa-box icon-success"></i>
        <span>Nos packs</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-lightbulb icon-warning"></i>
        <span>Suggestions/Plaintes</span>
    </a>
    
    <a href="{{ route('entreprises.evenements.index') }}" class="styled-link-box">
        <i class="fas fa-calendar-day icon-primary"></i>
        <span>Événements</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-blog icon-info"></i>
        <span>Blog</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-bullseye icon-danger"></i>
        <span>Objectifs</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-calendar-alt icon-teal"></i>
        <span>Agenda</span>
    </a>
    
    <a href="#" class="styled-link-box">
        <i class="fas fa-rocket icon-orange"></i>
        <span>Campagne Emailling</span>
    </a>
</div>

@endsection

@push('styles')
<style>
/* Styles de base pour le conteneur */
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.dashboard-title {
    margin-bottom: 25px;
    font-size: 1.6rem;
    color: var(--dark);
        font-weight: 600;
}

/* Conteneur des liens - CSS Grid pour la responsivité */
.link-container {
        display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

/* Style pour chaque boîte de lien */
.styled-link-box {
        display: flex;
        align-items: center;
    padding: 15px 20px;
    border: 2px solid #3498db; /* Bordure bleue permanente et plus épaisse */
    border-radius: var(--border-radius, 8px);
    box-shadow: var(--box-shadow-sm, 0 1px 3px rgba(0,0,0,0.05));
        text-decoration: none;
    color: var(--dark, #1f2937);
    background-color: white;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    overflow: hidden;
    word-break: break-word;
}

/* Style spécial pour la boîte mise en avant */
.featured-box {
    background-color: #f0f9ff; /* Fond bleu très léger */
    border: 2px solid #2563eb; /* Bordure plus visible */
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1); /* Ombre plus prononcée */
    transform: translateY(-3px); /* Légèrement surélevé */
    position: relative;
}

.featured-box::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 12px 12px 0;
    border-color: transparent #2563eb transparent transparent;
}

/* Style pour les icônes */
.styled-link-box i {
    margin-right: 15px;
    font-size: 1.3em;
    width: 30px;
    text-align: center;
}

/* Couleurs des icônes */
.icon-primary { color: #3498db; }
.icon-success { color: #2ecc71; }
.icon-warning { color: #f39c12; }
.icon-info { color: #17a2b8; }
.icon-danger { color: #e74c3c; }
.icon-teal { color: #20c997; }
.icon-orange { color: #fd7e14; }
.icon-secondary { color: #6c757d; }

/* Effet au survol */
.styled-link-box:hover {
    transform: translateY(-3px);
    box-shadow: var(--box-shadow, 0 4px 10px rgba(0,0,0,0.08));
    border-color: #2980b9; /* Bleu plus foncé au survol */
}

/* Effet spécial au survol pour la boîte mise en avant */
.featured-box:hover {
    transform: translateY(-5px); /* Surélevé encore plus au survol */
    box-shadow: 0 6px 15px rgba(37, 99, 235, 0.15);
}

/* Gestion du texte à l'intérieur */
.styled-link-box span {
    flex-grow: 1;
    font-weight: 500;
}

/* Badge pour indiquer nouveau */
.badge.bg-primary {
    background-color: #2563eb !important;
        font-weight: 500;
    font-size: 0.7rem;
}

/* Responsivité */
@media (max-width: 500px) {
    .link-container {
        gap: 15px;
    }
    
    .styled-link-box {
        padding: 12px 15px;
    }
    
    .styled-link-box i {
        margin-right: 10px;
        font-size: 1.1em;
    }
    }
</style>
@endpush
