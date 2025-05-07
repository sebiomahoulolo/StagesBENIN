@extends('layouts.admin.app')

@section('title', 'StagesBENIN') {{-- Optional: Set a specific title --}}

@section('content')
    <h1 class="dashboard-title">StagesBENIN</h1>

    <!-- Stats Section -->
   <!-- Assurez-vous d'avoir inclus Font Awesome dans votre projet pour que les icônes s'affichent -->
<!-- Exemple : <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->



<div class="link-container">

    <a href="{{ route('admin.etudiants.etudiants') }}" class="styled-link-box">

        <i class="fas fa-user-graduate icon-primary" ></i>
       
       <span>Étudiants</span>
    </a>

    <!-- NOUVEAU : Recrutements -->
    <a href="{{ route('admin.annonces.index') }}" class="styled-link-box">
        <i class="fas fa-user-tie icon-purple"></i>
        <span> Recrutements</span>
    </a>

     <!-- NOUVEAU : Événements -->
    <a href="{{ route('admin.evenements') }}" class="styled-link-box">
        <i class="fas fa-calendar-alt icon-danger"></i>

        <span>   Événements</span>
    </a>

    <a href="{{ route('admin.entreprises_partenaires') }}" class="styled-link-box">
        <i class="fas fa-building icon-success"></i>
        <span>Entreprises partenaires</span>
    </a>


    <a href="{{ route('admin.actualites') }}" class="styled-link-box">
        <i class="fas fa-newspaper icon-info"></i>
          <span>Actualités</span>
    </a>

    <a href="{{ route('admin.demandes.index') }}" class="styled-link-box">
        <i class="fas fa-user-plus icon-primary"></i>
        <span>Demande d'employés</span>
    </a>

    <!-- <a href="{{ route('admin.annonces.index') }}" class="styled-link-box">
        <i class="fas fa-bullhorn icon-purple"></i>
        <span>Offres d'emploi</span>
    </a> -->
 
    <a href="{{ route('admin.entretiens') }}" class="styled-link-box">
        <i class="fas fa-calendar-check icon-danger"></i>
        <span>Entretiens programmés</span>
    </a>

    <a href="{{ route('admin.catalogues') }}" class="styled-link-box">
        <i class="fas fa-book-open icon-teal"></i>
        <span>Catalogues
        </span>
    </a>
    

    <a href="{{ route('admin.boost') }}" class="styled-link-box">
        <i class="fas fa-file-alt icon-info"></i>
        <span>Listes des boost</span>
    </a>

    <a href="{{ route('messagerie-sociale.index') }}" class="styled-link-box">
        <i class="fas fa-bullhorn icon-orange"></i>
       <span>Canal d'annonces</span>
    </a>
    <a href="{{ route('admin.entreprises') }}" class="styled-link-box">
        <i class="fas fa-building icon-success"></i>
       <span>Entreprises
        </span>
    </a>



     <!-- NOUVEAU : Plaintes et suggestions -->
     <a href="{{ route('admin.complaints.index') }}" class="styled-link-box">
        <i class="fas fa-comment-dots icon-info"></i>
        <span>Plaintes et suggestions</span>
    </a>


    <a href="" class="styled-link-box">
        <i class="fas fa-laptop icon-primary"></i>
        <span>Les logiciels</span>
    </a>

    <a href="" class="styled-link-box">
        <i class="fas fa-sort-numeric-up icon-success"></i>
        <span>Le nombre d'insertion</span>
    </a>

    <a href="" class="styled-link-box">
        <i class="fas fa-cogs icon-warning"></i>
        <span>Programmes</span>
    </a>

    <a href="" class="styled-link-box">
        <i class="fas fa-briefcase icon-warning"></i>
        <span >Offres actives</span>
    </a>



     <a href="#" class="styled-link-box">
        <i class="fas fa-cog icon-secondary"></i>
        <span>Paramètres</span>
    </a>

</div>
<style>
/* Styles de base pour assurer une meilleure compatibilité */
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: sans-serif; /* Choisissez une police appropriée */
    padding: 20px; /* Ajoute un peu d'espace autour du conteneur */
    background-color: #f4f7f6; /* Un fond léger pour contraster */
}

/* Conteneur des liens - Utilisation de CSS Grid pour la responsivité */
.link-container {
    display: grid;
    /* Crée des colonnes qui s'adaptent automatiquement.
       Chaque colonne aura une largeur minimale de 200px
       et s'étendra pour remplir l'espace disponible (1fr). */
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px; /* Espace entre les boîtes */
}

/* Style de base pour chaque boîte de lien */
.styled-link-box {
    display: flex; /* Pour aligner icône et texte */
    align-items: center; /* Centrage vertical */
    padding: 15px 20px; /* Padding intérieur (plus grand) */
    border: 1px solid blue; /* Bordure bleue */
    border-radius: 8px; /* Coins légèrement plus arrondis */
    box-shadow: 2px 3px 6px rgba(0, 0, 0, 0.15); /* Ombre portée */
    text-decoration: none; /* Enlève le soulignement du lien */
    color: #333; /* Couleur du texte */
    background-color: #ffffff; /* Fond blanc */
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Animation douce au survol */
    overflow: hidden; /* Empêche le contenu de déborder si le texte est trop long */
    word-break: break-word; /* Coupe les mots longs si nécessaire */
}

/* Style pour les icônes */
.styled-link-box i {
    margin-right: 12px; /* Espace entre l'icône et le texte */
    font-size: 1.2em; /* Taille de l'icône légèrement augmentée */
    width: 25px; /* Donne une largeur fixe pour un meilleur alignement */
    text-align: center;
}

/* Couleurs spécifiques pour les icônes (utilisant des classes) */
.icon-primary { color: #007bff; }   /* Bleu (Étudiants) */
.icon-success { color: #28a745; }   /* Vert (Entreprises) */
.icon-warning { color: #ffc107; }   /* Jaune (Offres) */
.icon-info { color: #17a2b8; }      /* Cyan (Actualités) */
.icon-danger { color: #dc3545; }    /* Rouge (Entretiens) */
.icon-teal { color: #20c997; }      /* Teal (Catalogue) */
.icon-orange { color: #fd7e14; }    /* Orange (Annonces) */
.icon-secondary { color: #6c757d; } /* Gris (Paramètres) */


/* Effet au survol */
.styled-link-box:hover {
    transform: translateY(-3px); /* Léger déplacement vers le haut */
    box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée */
    border-color: darkblue; /* Assombrir un peu la bordure bleue */
}

/* Optionnel: S'assurer que le texte ne prend pas trop de place */
.styled-link-box span {
   flex-grow: 1; /* Permet au texte de prendre l'espace restant */
}


/* Styles pour écrans très petits (si la grille ne suffit pas) */
@media (max-width: 500px) {
    .link-container {
        /* Sur très petit écran, on pourrait forcer une seule colonne
           si auto-fit ne donne pas le résultat voulu */
         /* grid-template-columns: 1fr; */
         gap: 15px; /* Réduire l'espacement */
    }
     .styled-link-box {
        padding: 12px 15px; /* Réduire légèrement le padding */
    }
    .styled-link-box i {
         margin-right: 10px;
         font-size: 1.1em;
    }
}
</style>

@endsection

@push('styles')
{{-- Add page-specific CSS here if needed --}}
{{-- Example: <link rel="stylesheet" href="{{ asset('css/dashboard-specific.css') }}"> --}}
{{-- Note: Student table styles were moved to the main layout CSS for now --}}
@endpush

@push('scripts')
{{-- Add page-specific JS here if needed --}}
{{-- Example: <script src="{{ asset('js/dashboard-charts.js') }}"></script> --}}
{{-- Note: Tab, Modal, and Sidebar JS were moved to the main layout script --}}
@endpush