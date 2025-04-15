<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Importez Auth

// --- Contrôleurs Publics / Communs ---
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;

// --- Contrôleurs Spécifiques (seront utilisés dans les groupes protégés) ---
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\RecrutementController;
use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\Etudiant\CvController; // Contrôleur CV Étudiant

// --- Contrôleurs d'Authentification (Breeze & Modifiés) ---
use App\Http\Controllers\Auth\RegisteredUserController; // Votre contrôleur d'inscription modifié
use App\Http\Controllers\Etudiant\ProfileController as EtudiantProfileController;
use App\Http\Controllers\ProfileController; // Breeze Profile Controller
use App\Http\Controllers\Auth\PasswordController; // Import PasswordController

// --- Middleware ---
use App\Http\Middleware\EnsureUserHasRole; // Middleware de rôle

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========================================
// ROUTES PUBLIQUES (Accessibles à tous)
// ========================================

Route::get('/', function () { return view('index'); })->name('home'); // Accueil
Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');

// Routes Publiques des Pages statiques/info via PageController
Route::get('/a-propos-de-stageesbenin', [PageController::class, 'apropos'])->name('pages.apropos'); // URL conservée
Route::get('/contactez-stageesbenin', [PageController::class, 'contact'])->name('pages.contact'); // URL conservée
Route::get('/les-actulites', [PageController::class, 'actulites'])->name('pages.actulites'); // Liste publique des actualités
Route::get('/catalogues-des-entreprises', [PageController::class, 'catalogue'])->name('pages.catalogue'); // Liste publique des entreprises ?
Route::get('/nos-evenements', [PageController::class, 'evenements'])->name('pages.evenements'); // Liste publique des événements
Route::get('/nos-programmes', [PageController::class, 'programmes'])->name('pages.programmes');
Route::get('/les-dernieres-publications', [PageController::class, 'publication'])->name('pages.publication'); // Peut-être fusionner avec pages.actualites ?
Route::get('/nos-services', [PageController::class, 'services'])->name('pages.services');
// Route::get('/create_event', [PageController::class, 'create'])->name('pages.create_event'); // Sera dans section admin/recruteur
Route::get('/sanospro', [PageController::class, 'sanospro'])->name('pages.sanospro');
Route::get('/sanospro1', [PageController::class, 'sanospro1'])->name('pages.sanospro1');
Route::get('/pee', [PageController::class, 'pee'])->name('pages.pee');

// Routes Publiques pour les Événements
Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
Route::get('/events', [EventController::class, 'index'])->name('events.index'); // Conserve events.index public
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show'); // Conserve events.show public
Route::post('/events/register', [EventController::class, 'register'])->name('events.register'); // Inscription publique à un event

// Route pour envoyer le formulaire de contact
Route::post('/contactez-stageesbenin', [ContactController::class, 'sendContactForm'])->name('contact.send');


// =============================================
// ROUTES D'AUTHENTIFICATION (Breeze + Custom)
// =============================================

// Inclut Login, Logout, Forgot Password, etc. de Breeze
require __DIR__.'/auth.php';

// Routes d'inscription spécifiques (remplacent la route /register de Breeze)
Route::middleware('guest')->group(function () {
    // Affichage des formulaires
    Route::get('/register', function() {
        return view('auth.register-choice'); // Assurez-vous que ceci existe
    })->name('register');
    
    Route::get('register/etudiant', [RegisteredUserController::class, 'createEtudiant'])->name('register.etudiant.create');
    Route::get('register/recruteur', [RegisteredUserController::class, 'createRecruteur'])->name('register.recruteur.create');

    // Traitement des formulaires
    Route::post('register/etudiant', [RegisteredUserController::class, 'storeEtudiant'])->name('register.etudiant.store');
    Route::post('register/recruteur', [RegisteredUserController::class, 'storeRecruteur'])->name('register.recruteur.store');

     // Page de choix pour l'inscription (pointe vers /register)
    Route::get('/register', function() {
        return view('auth.register-choice'); // Créez cette vue
    })->name('register');
});


// ===============================================
// ROUTES PROTÉGÉES (Nécessitent Connexion)
// ===============================================

// Dashboard générique (Redirige immédiatement selon le rôle)
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard'); // Garde le nom admin.dashboard
    if ($user->isEtudiant()) return redirect()->route('etudiants.dashboard'); // Garde le nom etudiants.dashboard
    if ($user->isRecruteur()) return redirect()->route('entreprises.dashboard'); // Garde le nom entreprises.dashboard
    // Fallback
    Auth::logout();
    return redirect('/login')->with('error', 'Rôle utilisateur inconnu.');
})->middleware(['auth'/*, 'verified'*/])->name('dashboard'); // Nom générique 'dashboard'

// Routes du Profil Utilisateur (Commun à tous les rôles connectés)
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// --- Groupe Admin ---
// Utilisation du préfixe et nommage existant 'admin'
Route::middleware(['auth', EnsureUserHasRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard'); // Correspond à l'ancien GET /admin -> admin.dashboard
    Route::get('/manage-users', [AdminController::class, 'manageUsers'])->name('manage_users'); // Conserve admin.manage_users

    // Gestion CRUD des Actualités par l'Admin
    Route::resource('actualites', ActualiteController::class); // Noms: admin.actualites.index, admin.actualites.create, etc.

    // Gestion CRUD du Catalogue par l'Admin
    Route::resource('catalogue', CatalogueController::class); // Noms: admin.catalogue.index, admin.catalogue.create, etc.

    // Gestion CRUD des Événements par l'Admin (sauf index/show publics)
    Route::resource('events', EventController::class)->except(['index', 'show']); // Noms: admin.events.create, admin.events.store, etc.
    // La route /create-event pointe maintenant vers admin.events.create si elle doit être protégée
    // Route::get('/create-event', [EventController::class, 'create'])->name('events.create'); // Déplacée

    // Ajoutez ici d'autres routes spécifiques à l'admin
    // Ex: Validation des entreprises, etc.
});


Route::middleware(['auth', 'role:etudiant'])->prefix('etudiant')->name('etudiants.')->group(function () {

    // ... Route pour le dashboard étudiant ...
    Route::get('/dashboard', [EtudiantController::class, 'index'])->name('dashboard');

    Route::get('/profil', [EtudiantProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [EtudiantProfileController::class, 'updateEtudiantInfo'])->name('profile.updateEtudiantInfo'); // Pour infos spécifiques étudiant
    Route::post('/profil/photo', [EtudiantProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');      // Pour la photo

    // == Routes Breeze pour les infos générales et mot de passe ==
    // Note: Elles pointent vers le contrôleur Breeze par défaut, mais la vue utilisée sera celle de l'étudiant
    Route::patch('/profile-general', [ProfileController::class, 'update'])->name('profile.updateGeneral'); // Route séparée pour infos générales
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update'); // Route Breeze pour mot de passe


    // --- Routes pour le CV ---
    Route::prefix('cv')->name('cv.')->group(function () {
        // La route pour l'éditeur (utilise maintenant Livewire)
        Route::get('/edit', [CvController::class, 'edit'])->name('edit'); // Pointe vers la méthode edit mise à jour

        // Route pour visualiser le CV
        Route::get('/show', [CvController::class, 'show'])->name('show');

        // Routes pour l'export
        Route::get('/export/pdf', [CvController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/png', [CvController::class, 'exportPng'])->name('export.png');

        // --- LES ANCIENNES ROUTES AJAX NE SONT PLUS NÉCESSAIRES POUR CETTE VUE ---
        // Route::put('/profile', [CvController::class, 'updateProfile'])->name('profile.update');
        // Route::post('/formations', [CvController::class, 'storeFormation'])->name('formations.store');
        // Route::put('/formations/{id}', [CvController::class, 'updateFormation'])->name('formations.update');
        // Route::delete('/formations/{id}', [CvController::class, 'destroyFormation'])->name('formations.destroy');
        // ... (idem pour experiences, competences, langues, etc.) ...

    }); // Fin du groupe cv
}); // Fin du groupe étudiant


// --- Groupe Recruteur (Entreprise) ---
// Utilisation du préfixe et nommage existant 'entreprises'
Route::middleware(['auth', EnsureUserHasRole::class.':recruteur'])->prefix('entreprises')->name('entreprises.')->group(function () {
    // Route pour le dashboard recruteur/entreprise
    Route::get('/', [EntrepriseController::class, 'index'])->name('dashboard'); // Correspond à l'ancien GET /entreprises -> entreprises.dashboard

    // Route pour le formulaire de création d'offre
    Route::get('/post-job', [EntrepriseController::class, 'postJobOffer'])->name('post_job_offer'); // Conserve entreprises.post_job_offer (pointe vers le form)

    // CRUD pour les Recrutements (Offres) gérées par le recruteur connecté
    // Le contrôleur RecrutementController doit gérer la liaison avec l'entreprise de l'utilisateur Auth::user()->entreprise->id
    Route::get('/recrutements', [RecrutementController::class, 'index'])->name('recrutements.index'); // Liste des offres de l'entreprise
    Route::post('/recrutements', [RecrutementController::class, 'store'])->name('recrutements.store'); // Enregistrement de l'offre postée via /post-job
    Route::get('/recrutements/{recrutement}/edit', [RecrutementController::class, 'edit'])->name('recrutements.edit'); // Editer une offre
    Route::put('/recrutements/{recrutement}', [RecrutementController::class, 'update'])->name('recrutements.update'); // MAJ offre
    Route::delete('/recrutements/{recrutement}', [RecrutementController::class, 'destroy'])->name('recrutements.destroy'); // Supprimer offre

    // Routes pour gérer le profil de l'entreprise elle-même (si différent du profil user)
     Route::get('/profil/edit', [EntrepriseController::class, 'edit'])->name('profil.edit'); // Formulaire édition profil entreprise
     Route::put('/profil', [EntrepriseController::class, 'update'])->name('profil.update'); // Sauvegarde profil entreprise

    // Ajoutez ici d'autres routes recruteur
    // Ex: Voir les candidats pour une offre, etc.
});

Route::patch('/evenements/{id}/toggle-status', [EventController::class, 'toggleStatus'])->name('evenements.toggleStatus');
Route::get('/evenements/{id}', [EventController::class, 'show'])->name('evenements.show');
Route::get('/evenements/{id}/edit', [EventController::class, 'edit'])->name('evenements.edit');
Route::put('/evenements/{id}', [EventController::class, 'update'])->name('evenements.update');
Route::delete('/evenements/{id}', [EventController::class, 'destroy'])->name('evenements.destroy');
Route::post('/events', [EventController::class, 'store'])->name('events.store');


// Géré par register.etudiant.store
Route::get('/etudiants/{id}/envoyer-examen', [EtudiantController::class, 'envoyerExamen'])->name('etudiants.envoyer.examen');
Route::get('/candidat/dashboard', [EtudiantController::class, 'dashboardCandidat'])->name('candidat.dashboard');
Route::get('/etudiants/{etudiant_id}/entretiens', [EtudiantController::class, 'createEntretien'])->name('etudiants.entretiens');
Route::post('/etudiants/{etudiant_id}/entretiens', [EtudiantController::class, 'storeEntretien'])->name('etudiants.entretiens');
Route::post('/etudiants/{etudiant_id}/examen', [EtudiantController::class, 'submitExamen'])->name('etudiants.examen.submit');
Route::get('/etudiants/{etudiant_id}/examen', [EtudiantController::class, 'showExamen'])->name('etudiants.examen');
Route::post('/etudiants/{id}/accepter', [EtudiantController::class, 'accepterCandidature'])->name('candidatures.accepter');
Route::post('/etudiants/{id}/rejeter', [EtudiantController::class, 'rejeterCandidature'])->name('candidatures.rejeter');
Route::patch('/etudiants/{id}/toggle-status', [EtudiantController::class, 'toggleStatus'])->name('etudiants.toggleStatus');
Route::get('/etudiants/{id}', [EtudiantController::class, 'show'])->name('etudiants.show');
Route::get('/etudiants/{id}/edit', [EtudiantController::class, 'edit'])->name('etudiants.edit');
Route::put('/etudiants/{id}', [EtudiantController::class, 'update'])->name('etudiants.update');
Route::delete('/etudiants/{id}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');
Route::get('/etudiants/{id}/cv', [EtudiantController::class, 'downloadCV'])->name('etudiants.cv.download');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store'); 
// ==================================================================
// ROUTES POST PUBLIQUES ORIGINALES (MAINTENANT OBSOLÈTES/DÉPLACÉES)
// ==================================================================

  // Déplacé dans admin group
 Route::post('/entreprises', [EntrepriseController::class, 'store'])->name('entreprises.store'); // Géré par register.recruteur.store
 Route::post('/recrutements', [RecrutementController::class, 'store'])->name('recrutements.store'); // Déplacé dans entreprises (recruteur) group
 Route::post('/actualites', [ActualiteController::class, 'store'])->name('actualites.store'); // Déplacé dans admin group (via resource)
 Route::post('/catalogue', [CatalogueController::class, 'store'])->name('catalogue.store'); // Déplacé dans admin group (via resource)