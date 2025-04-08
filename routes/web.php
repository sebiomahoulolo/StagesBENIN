<?php
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecrutementController;
use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\CatalogueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () { return view('index');});
Route::post('/subscribe', [SubscriberController::class, 'subscribe']);
Route::get('/create-event', [EventController::class, 'create'])->name('events.create');
Route::resource('events', EventController::class);
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
Route::post('/events/register', [EventController::class, 'register'])->name('events.register');


//PageController
Route::get('/a propos de StageesBENIN', [PageController::class, 'apropos'])->name('pages.apropos');
Route::get('/contactez StageesBENIN', [PageController::class, 'contact'])->name('pages.contact');
Route::get('/les actulités', [PageController::class, 'actulites'])->name('pages.actulites');
Route::get('/catalogues des entreprises', [PageController::class, 'catalogue'])->name('pages.catalogue');
Route::get('/nos évenements', [PageController::class, 'evenements'])->name('pages.evenements');
Route::get('/nos programmes', [PageController::class, 'programmes'])->name('pages.programmes');
Route::get('/les dernieres publications', [PageController::class, 'publication'])->name('pages.publication');
Route::get('/nos services', [PageController::class, 'services'])->name('pages.services');
Route::get('/create_event', [PageController::class, 'create'])->name('pages.create_event');
Route::get('/sanospro', [PageController::class, 'sanospro'])->name('pages.sanospro');
Route::get('/sanospro1', [PageController::class, 'sanospro1'])->name('pages.sanospro1');
Route::get('/pee', [PageController::class, 'pee'])->name('pages.pee');


Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
Route::post('/entreprises', [EntrepriseController::class, 'store'])->name('entreprises.store');
Route::post('/recrutements', [RecrutementController::class, 'store'])->name('recrutements.store');
Route::post('/actualites', [ActualiteController::class, 'store'])->name('actualites.store');
Route::post('/catalogue', [CatalogueController::class, 'store'])->name('catalogue.store');
// Routes pour ContactController
Route::post('/contactez StageesBENIN', [ContactController::class, 'sendContactForm'])->name('contact.send');



// Routes pour l'AdminController
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage_users');
Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.dashboard');
Route::get('/etudiants/search-internships', [EtudiantController::class, 'searchInternships'])->name('etudiant.search_internships');
Route::get('/entreprises', [EntrepriseController::class, 'index'])->name('entreprises.dashboard');
Route::get('/entreprises/post-job', [EntrepriseController::class, 'postJobOffer'])->name('entreprises.post_job_offer');































Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
