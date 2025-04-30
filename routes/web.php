<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Importez Auth
use App\Http\Controllers\BoostController;

// --- Contrôleurs Publics / Communs ---
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;

// --- Contrôleurs Spécifiques (seront utilisés dans les groupes protégés) ---
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\Entreprises\EntrepriseController;
use App\Http\Controllers\Entreprises\AnnonceController;
use App\Http\Controllers\Admin\AnnonceController as AdminAnnonceController;
// use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\RecrutementController;
use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\Etudiant\CvController; // Contrôleur CV Étudiant
use App\Http\Controllers\Etudiant\ComplaintSuggestionController as EtudiantComplaintController; // Contrôleur plaintes/suggestions étudiant
use App\Http\Controllers\Admin\ComplaintSuggestionController as AdminComplaintController; // Contrôleur plaintes/suggestions admin

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
Route::get('/generate-pdf/{id}', [EventController::class, 'generatePDF'])->name('generate.pdf');

// Routes Publiques des Pages statiques/info via PageController
Route::get('/a-propos-de-stageesbenin', [PageController::class, 'apropos'])->name('pages.apropos'); // URL conservée
Route::get('/contactez-stageesbenin', [PageController::class, 'contact'])->name('pages.contact'); // URL conservée
Route::get('/les-actualites', [PageController::class, 'actualites'])->name('pages.actualites'); // Liste publique des actualités
Route::get('/catalogues', [PageController::class, 'catalogue'])->name('pages.catalogue'); 
//Route::get('/secteur/{secteur}', [CatalogueController::class, 'showParSecteur'])->name('secteur.show');
Route::post('/avis', [App\Http\Controllers\PageController::class, 'store'])->name('avis.store');
//Route::get('/catalogues-des-entreprises/{id}', [PageController::class, 'catalogueplus2'])->name('pages.catalogueplus');
//Route::get('/catalogues-des-entreprises', [PageController::class, 'catalogueplus2'])->name('pages.catalogueplus');
//Route::get('/catalogue/{id}', [PageController::class, 'show'])->name('catalogueplus');
Route::get('/catalogue/{id}', [CatalogueController::class, 'show'])->name('catalogue.show');

Route::get('/catalogueplus2/{id}', [CatalogueController::class, 'showParSecteur'])->name('catalogueplus2');
Route::get('/catalogueplus3/{id}', [CatalogueController::class, 'showParSecteur'])->name('catalogueplus3');

Route::get('/catalogueplus', [CatalogueController::class, 'getLastAvis'])->name('catalogueplus');

Route::get('/catalogue/{id}/edit', [CatalogueController::class, 'edit'])->name('catalogue.edit');
Route::put('/catalogue/{id}', [CatalogueController::class, 'update'])->name('catalogue.update');
//Route::get('/catalogue/{id}', [AdminController::class, 'show'])->name('catalogue.show');
Route::get('/catalogueplus/{secteur_activite}', [PageController::class, 'showParSecteur'])->name('catalogueplus.secteur');
Route::get('/catalogueplus/{secteur_activite}', [CatalogueController::class, 'showParSecteur']);

Route::get('/nos-evenements', [PageController::class, 'evenements'])->name('pages.evenements'); // Liste publique des événements
Route::get('/nos-programmes', [PageController::class, 'programmes'])->name('pages.programmes');
Route::get('/les-dernieres-publications', [PageController::class, 'publication'])->name('pages.publication'); // Peut-être fusionner avec pages.actualites ?
Route::get('/nos-services', [PageController::class, 'services'])->name('pages.services');
// Route::get('/create_event', [PageController::class, 'create'])->name('pages.create_event'); // Sera dans section admin/recruteur
Route::get('/sanospro', [PageController::class, 'sanospro'])->name('pages.sanospro');
Route::get('/sanospro1', [PageController::class, 'sanospro1'])->name('pages.sanospro1');
Route::get('/pee', [PageController::class, 'pee'])->name('pages.pee');
Route::get('/paps', [PageController::class, 'paps'])->name('pages.paps');
Route::get('/paps1', [PageController::class, 'paps1'])->name('pages.desc_paas1');
Route::get('/paps2', [PageController::class, 'paps2'])->name('pages.desc_paas2');
Route::get('/paps3', [PageController::class, 'paps3'])->name('pages.desc_paas3');
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

    Route::resource('events', EventController::class)->except(['index', 'show']); // Noms: admin.events.create, admin.events.store, etc.

    // Route pour visualiser les détails d'un étudiant
    Route::get('/etudiants/{etudiant}/details', [App\Http\Controllers\Admin\EtudiantController::class, 'showDetails'])
        ->name('etudiants.show'); // Utilisation de .show comme convention

    // Routes pour les plaintes et suggestions côté admin
    // IMPORTANT: La route de filtre doit être définie AVANT la route resource pour éviter les conflits
    Route::get('complaints/filter', [AdminComplaintController::class, 'filter'])->name('complaints.filter');
    Route::resource('complaints', AdminComplaintController::class)->except(['create', 'store']);

    // Routes pour la gestion des annonces
    Route::get('/annonces', [AdminAnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/create', [AdminAnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/annonces', [AdminAnnonceController::class, 'store'])->name('annonces.store');
    Route::get('/annonces/{annonce}', [AdminAnnonceController::class, 'show'])->name('annonces.show');
    Route::post('/annonces/{annonce}/approuver', [AdminAnnonceController::class, 'approuver'])->name('annonces.approuver');
    Route::post('/annonces/{annonce}/rejeter', [AdminAnnonceController::class, 'rejeter'])->name('annonces.rejeter');

    // Routes pour les candidatures
    Route::put('/candidatures/{candidature}/statut', [App\Http\Controllers\Admin\CandidatureController::class, 'updateStatut'])->name('candidatures.updateStatut');
    Route::get('/candidatures/{candidature}', [App\Http\Controllers\Admin\CandidatureController::class, 'show'])->name('candidatures.show');
});


Route::middleware(['auth', 'role:etudiant'])->prefix('etudiants')->name('etudiants.')->group(function () {

    // ... Route pour le dashboard étudiant ...
    Route::get('/dashboard', [EtudiantController::class, 'index'])->name('dashboard');

    // Route pour le boostage
    Route::get('/boostage', function() {
        return view('etudiants.boostage');
    })->name('boostage');
    
    // Routes pour les événements
    Route::get('/evenements', [EventController::class, 'upcomingForStudent'])->name('evenements.upcoming');
    Route::get('/evenements/{id}', [EventController::class, 'showForStudent'])->name('evenements.show');
    Route::post('/evenements/{id}/register', [EventController::class, 'registerStudent'])->name('evenements.register');

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
        Route::get('/export/pdf', [CvController::class, 'exportPdf'])->name('export.pdf'); // Réactivé: Export PDF géré côté serveur via dompdf
        Route::get('/export/png', [CvController::class, 'exportPng'])->name('export.png');

        // ... (idem pour experiences, competences, langues, etc.) ...
        Route::get('/projets', [CvController::class, 'showProjects'])->name('projets'); // Exemple si vous ajoutez d'autres sections
    }); // Fin du groupe cv

    // Routes pour les plaintes et suggestions côté étudiant
    Route::resource('complaints', EtudiantComplaintController::class)->except(['edit', 'update']);

    // Routes pour les offres d'emploi
    Route::get('/offres', [App\Http\Controllers\Etudiants\OffreController::class, 'index'])->name('offres.index');
    Route::get('/offres/{annonce}', [App\Http\Controllers\Etudiants\OffreController::class, 'show'])->name('offres.show');
    Route::get('/offres/{annonce}/postuler', [App\Http\Controllers\Etudiants\OffreController::class, 'postuler'])->name('offres.postuler');
    Route::post('/offres/{annonce}/postuler', [App\Http\Controllers\Etudiants\OffreController::class, 'postulerSubmit'])->name('offres.postuler.submit');
    Route::get('/mes-candidatures', [App\Http\Controllers\Etudiants\OffreController::class, 'mesCandidatures'])->name('candidatures.index');
    Route::get('/candidatures/{id}', [App\Http\Controllers\Etudiants\OffreController::class, 'showCandidature'])->name('candidatures.show');
}); // Fin du groupe étudiant


// --- Groupe Recruteur (Entreprise) ---
Route::middleware(['auth', 'role:recruteur'])->prefix('entreprises')->name('entreprises.')->group(function () {
    Route::get('/dashboard', [EntrepriseController::class, 'dashboard'])->name('dashboard');
    
    // Routes pour les annonces
    Route::prefix('annonces')->name('annonces.')->group(function () {
        Route::get('/', [AnnonceController::class, 'index'])->name('index');
        Route::get('/create', [AnnonceController::class, 'create'])->name('create');
        Route::post('/', [AnnonceController::class, 'store'])->name('store');
        Route::get('/{annonce}', [AnnonceController::class, 'show'])->name('show');
        Route::get('/{annonce}/edit', [AnnonceController::class, 'edit'])->name('edit');
        Route::put('/{annonce}', [AnnonceController::class, 'update'])->name('update');
        Route::delete('/{annonce}', [AnnonceController::class, 'destroy'])->name('destroy');
    });
});

//actulites
Route::resource('actualites', ActualiteController::class);
Route::get('/les-actualites', [ActualiteController::class, 'actualites'])->name('pages.actualites');

Route::get('/entreprises', [EntrepriseController::class, 'index'])->name('entreprises.index');
Route::get('/entreprises/create', [EntrepriseController::class, 'create'])->name('entreprises.create');
Route::post('/entreprises', [EntrepriseController::class, 'store'])->name('entreprises.store');
Route::get('/entreprises/{id}', [EntrepriseController::class, 'show'])->name('entreprises.show');
Route::get('/entreprises/{id}/edit', [EntrepriseController::class, 'edit'])->name('entreprises.edit');
Route::put('/entreprises/{id}', [EntrepriseController::class, 'update'])->name('entreprises.update');
Route::delete('/entreprises/{id}', [EntrepriseController::class, 'destroy'])->name('entreprises.destroy');
Route::get('/entreprises/{id}/contact', [EntrepriseController::class, 'contact'])->name('entreprises.contact');
Route::get('/entreprises/{id}/follow', [EntrepriseController::class, 'follow'])->name('entreprises.follow');

Route::get('/admin/recrutements', [AdminController::class, 'recrutements'])->name('admin.recrutements');
Route::get('/admin/entretiens', [AdminController::class, 'entretiens'])->name('admin.entretiens');
Route::get('/admin/entreprises_partenaires', [AdminController::class, 'entreprises_partenaires'])->name('admin.entreprises_partenaires');
Route::get('/admin/evenements', [AdminController::class, 'evenements'])->name('admin.evenements');
Route::get('/admin/entreprises', [AdminController::class, 'entreprises'])->name('admin.entreprises');
Route::get('/admin/catalogues', [AdminController::class, 'catalogues'])->name('admin.catalogues');
Route::get('/admin/etudiants', [AdminController::class, 'etudiants'])->name('admin.etudiants.etudiants');
Route::get('/admin/actualites', [AdminController::class, 'actualites'])->name('admin.actualites');
Route::get('admin/actualites', [ActualiteController::class, 'index'])->name('admin.actualites');
Route::get('admin/evenements', [EventController::class, 'events'])->name('admin.evenements');
Route::get('/admin/cvtheque', [AdminController::class, 'cvtheque'])->name('admin.cvtheque.cvtheque');
Route::get('/admin/cv/{id}', [CvController::class, 'view'])->name('admin.cvtheque.view');
Route::get('/admin/cv/{id}/download', [CvController::class, 'download'])->name('admin.cvtheque.download');
// Route pour changer le statut de l'étudiant (bloquer/débloquer)
Route::patch('/admin/etudiants/{id}/toggle-status', [EtudiantController::class, 'toggleStatus'])->name('admin.etudiants.toggleStatus');
Route::delete('/admin/etudiants/{id}', [EtudiantController::class, 'destroy'])->name('admin.etudiants.destroy');


Route::get('/catalogue/{id}/edit', [CatalogueController::class, 'edit'])->name('catalogue.edit');
Route::delete('/catalogue/{id}', [CatalogueController::class, 'destroy'])->name('catalogue.destroy');


//evenements
Route::patch('/evenements/{id}/toggle-status', [EventController::class, 'toggleStatus'])->name('evenements.toggleStatus');
Route::get('/evenements/{id}', [EventController::class, 'show'])->name('evenements.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

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

// Routes pour la messagerie avec middleware auth
Route::middleware(['auth'])->group(function () {
    Route::prefix('messaging')->name('messaging.')->group(function () {
        Route::get('/', [App\Http\Controllers\MessagingController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\MessagingController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\MessagingController::class, 'store'])->name('store');
        Route::get('/{conversation}', [App\Http\Controllers\MessagingController::class, 'show'])->name('show');
        Route::post('/{conversation}/messages', [App\Http\Controllers\MessagingController::class, 'sendMessage'])->name('send-message');
        Route::post('/{conversation}/mark-as-read', [App\Http\Controllers\MessagingController::class, 'markAsRead'])->name('mark-as-read');
        
        // Routes pour le nouveau MessageController
        Route::prefix('api')->name('api.')->group(function () {
            Route::post('/conversations/{conversationId}/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
            Route::delete('/messages/{messageId}', [App\Http\Controllers\MessageController::class, 'destroy'])->name('messages.destroy');
            Route::get('/conversations/{conversationId}/messages', [App\Http\Controllers\MessageController::class, 'getMessages'])->name('messages.get');
        });
    });
});

// Routes pour la nouvelle messagerie
Route::prefix('nouvelle-messagerie')->name('nouvelle-messagerie.')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\NouvelleMessagerieController::class, 'index'])->name('index');
    Route::get('/{conversation}', [App\Http\Controllers\NouvelleMessagerieController::class, 'show'])->name('show');
    Route::get('/create', [App\Http\Controllers\NouvelleMessagerieController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\NouvelleMessagerieController::class, 'store'])->name('store');
    Route::post('/{conversation}/send-message', [App\Http\Controllers\NouvelleMessagerieController::class, 'sendMessage'])->name('send-message');
    Route::get('/contacts', [App\Http\Controllers\NouvelleMessagerieController::class, 'getContacts'])->name('contacts');
    Route::post('/messages/{message}/share', [App\Http\Controllers\NouvelleMessagerieController::class, 'shareMessage'])->name('share-message');
    Route::post('/messages/{message}/comment', [App\Http\Controllers\NouvelleMessagerieController::class, 'commentMessage'])->name('comment-message');
});

// Routes pour la messagerie sociale
Route::middleware(['auth'])->group(function () {
    Route::get('/canal-messagerie', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'index'])
        ->name('messagerie-sociale.index');
    
    Route::get('/canal-messagerie/posts/create', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'createPost'])
        ->name('messagerie-sociale.create-post');
    
    Route::post('/canal-messagerie/posts', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'storePost'])
        ->name('messagerie-sociale.store-post');
    
    Route::get('/canal-messagerie/posts/{post}', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'showPost'])
        ->name('messagerie-sociale.show-post');
    
    Route::get('/canal-messagerie/posts/{post}/edit', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'editPost'])
        ->name('messagerie-sociale.edit-post');
    
    Route::put('/canal-messagerie/posts/{post}', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'updatePost'])
        ->name('messagerie-sociale.update-post');
    
    Route::delete('/canal-messagerie/posts/{post}', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'destroyPost'])
        ->name('messagerie-sociale.destroy-post');
    
    Route::post('/canal-messagerie/posts/{post}/comments', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'storeComment'])
        ->name('messagerie-sociale.store-comment');
    
    Route::delete('/canal-messagerie/comments/{comment}', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'destroyComment'])
        ->name('messagerie-sociale.destroy-comment');
    
    Route::post('/canal-messagerie/posts/{post}/share', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'sharePost'])
        ->name('messagerie-sociale.share-post');
    
    Route::get('/canal-messagerie/shared/{token}', [App\Http\Controllers\NouvelleMessagerie\MessagerieSocialeController::class, 'showSharedPost'])
        ->name('messagerie-sociale.shared-post');
});

// Routes pour le boostage
Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/etudiants/boost/status', [BoostController::class, 'status'])->name('etudiants.boostage.status');
    Route::get('/etudiants/boost/renew', [BoostController::class, 'renew'])->name('etudiants.boostage.renew');
    Route::post('/etudiants/boost/renew', [BoostController::class, 'processRenewal'])->name('etudiants.boostage.process-renewal');
    Route::get('/etudiants/boost/upgrade', [BoostController::class, 'upgrade'])->name('etudiants.boostage.upgrade');
    Route::post('/etudiants/boost/upgrade', [BoostController::class, 'processUpgrade'])->name('etudiants.boostage.process-upgrade');
});
