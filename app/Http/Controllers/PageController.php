<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Catalogue;
use App\Models\Actualite;
use App\Models\Avis;
use App\Models\Secteur;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Models\Event;
use App\Models\Annonce;
use App\Models\Specialite;
use Illuminate\Http\Request;
class PageController extends Controller
{
// L'import Log est déjà présent
    public function create()
    {
        return view('event-form'); // ou le nom de ta vue exacte
    }
    

    public function evenements() {
        $events = Event::whereNotNull('ticket_price')
                       ->where('ticket_price', '>', 0)
                       ->where('is_published', 1)
                       ->orderBy('start_date', 'asc')
                       ->get();
    
        return view('pages.evenements', compact('events'));
    }
    
    

    public function index()
    {
        $actualites = Actualite::orderBy('created_at', 'desc')->take(4)->get();

        $nombre_actualites = $actualites->count();
    
       $evenements = Event::where('is_published', 1)->orderBy('created_at', 'desc')->take(4)->get();

        $nombre_events = $evenements->count();
    
        
      $annonces = Annonce::where('statut', 'approuve')->orderBy('created_at', 'desc')->take(4)->get();
$nombre_offres = $annonces->count(); // Nombre total d'offres
    
        return view('index', compact('actualites', 'nombre_actualites', 'evenements', 'nombre_events', 'annonces', 'nombre_offres'));
    }
    
    public function offres() {
    $secteurs = Secteur::all();
      $annonces = Annonce::paginate(10);
      $specialites = Specialite::all();// Récupération des secteurs depuis la base de données
    return view('pages.offres', compact('secteurs','annonces','specialites'));
}

    
    public function actualite()
    {
        $actualites = Actualite::paginate(10); // Pagination des actualités
        $categories = Category::all(); // Récupérer toutes les catégories
    
        return view('pages.actualites', compact('actualites', 'categories'));
    }
      public function marche()
    {
        $actualites = Actualite::paginate(10); // Pagination des actualités
       
        return view('pages.marche', compact('actualites'));
    }
    
    public function showParSecteur($secteur_activite)
    {
        $secteur_activite = urldecode($secteur_activite);
    
        // Test pour vérifier ce que contient exactement activite_principale
        $catalogue = Catalogue::where('secteur_activite', 'LIKE', "%{$secteur_activite}%")->get();
        $secteur_activite = urldecode($secteur_activite);
        if ($catalogue->isEmpty()) {
            logger("Aucun catalogue trouvé pour le secteur : $secteur_activite");
            // Tu peux même logger les valeurs disponibles
            $toutesActivites = Catalogue::pluck('secteur_activite')->unique();
            logger($toutesActivites);
        }
    
        return view('pages.catalogueplus', compact('catalogue', 'secteur_activite'));
    }

   
    public function apropos()
    {
        return view('pages.apropos'); 
    }

    public function contact()
    {
        return view('pages.contact'); 
    }
   

    public function publication()
    {
        return view('pages.publication'); 
    }
    
    
    
       public function formulaire()
    {
        return view('pages.formulaire'); 
    }
    
    
public function submitApplication(Request $request)
{
    Log::info('Début de la soumission', ['ip' => $request->ip()]);

    try {
        $validated = $request->validate([
            'poste' => 'required|string|max:255',
            'civilite' => 'required|string|in:M.,Mme,Mlle',
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'naissance' => 'required|date',
            'niveau' => 'required|string|max:50',
            'diplome' => 'required|string|max:100',
            'experience' => 'nullable|integer|min:0',
            'competences' => 'nullable|string',
            'motivation' => 'required|string|min:50',
            'dossier' => 'required|file|mimes:pdf|max:5120',
            'consentement' => 'required|accepted'
        ]);

        Log::info('Validation réussie', $validated);

        // Envoi direct par email sans stockage
        Mail::send('emails.application', ['data' => $validated], function($message) use ($validated, $request) {
            $message->to('depot@stagesbenin.com')
                    ->subject('Nouvelle candidature - ' . $validated['poste'])
                    ->attach($request->file('dossier')->getRealPath(), [
                        'as' => 'Candidature_'.$validated['nom'].'_'.$validated['prenom'].'.pdf',
                        'mime' => 'application/pdf'
                    ]);
        });

        Log::info('Email envoyé avec succès');
        
        return response()->json([
            'success' => true,
            'message' => 'Votre candidature a bien été envoyée'
        ]);

    } catch (\Throwable $e) {
        Log::error('Erreur soumission', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $request->all()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Une erreur technique est survenue. Veuillez réessayer.'
        ], 500);
    }
}

    public function services()
    {
        return view('pages.services'); 
    } public function actualites()
    {
        $actualites = Actualite::latest()->paginate(10);
        $categories = \App\Models\Category::all();
        return view('pages.actualites', compact('actualites', 'categories')); 
    }

    public function programmes()
    {
        return view('pages.programmes'); 
    }
    
    



    public function sanospro()
    {
        return view('pages.sanospro'); 
    }
    public function sanospro1()
    {
        return view('pages.sanospro1'); 
    }
    public function pee()
    {
        return view('pages.pee'); 
    } public function paps()
    {
        return view('pages.paps');
    
    }

    public function paps1()
    {
        return view('pages.desc_paas1');
        
    }

    public function paps2()
    {
        return view('pages.desc_paas2');
        
    }

    public function showEventDetails($id)
    {
        $event = Event::findOrFail($id);
        
        // Prepare dates for JavaScript
        $eventData = [
            'startDate' => $event->start_date instanceof \Carbon\Carbon 
                ? $event->start_date->toIso8601String() 
                : \Carbon\Carbon::parse($event->start_date)->toIso8601String(),
            'endDate' => $event->end_date instanceof \Carbon\Carbon 
                ? $event->end_date->toIso8601String() 
                : \Carbon\Carbon::parse($event->end_date)->toIso8601String()
        ];
        
        return view('pages.details_events', [
            'event' => $event,
            'eventData' => $eventData
        ]);
    }

    public function paps3()
    {
        return view('pages.desc_paas3');
        
    }
    public function catalogueplus($id)
{
    $catalogue = Catalogue::findOrFail($id);
    return view('pages.catalogueplus', compact('catalogue'));
}

public function catalogueplus2($id)
{ $avis = Avis::where('catalogue_id', $id)->orderBy('created_at', 'desc')->get();
    $catalogue = Catalogue::findOrFail($id);
    return view('pages.catalogueplus2', compact('catalogue','avis'));
}


public function show($id)
{
    $avis = Avis::orderBy('created_at', 'desc')->get();

    // Récupérer le catalogue en fonction de son ID
    $catalogue = Catalogue::findOrFail($id);

    // Vérifier le statut et rediriger vers la vue correspondante
    if ($catalogue->status == 0) {
        return view('pages.catalogueplus2', compact('catalogue', 'avis'));
    } elseif ($catalogue->status == 1) {
        return view('pages.catalogueplus3', compact('catalogue', 'avis'));
    } else {
        // Optionnel : Gestion d'un statut inconnu
        abort(404, 'Statut inconnu pour cet événement');
    }
}





public function store(Request $request)
{
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'catalogue_id' => 'required|exists:catalogues,id',
        'note' => 'required|integer|min:1|max:5',
        'commentaire' => 'nullable|string',
    ]);

    Avis::create($validatedData);

    return redirect()->back()->with('success', 'Votre avis a été enregistré avec succès.');
}


public function catalogue()
{
    $catalogues = Catalogue::all();
    return view('pages.catalogue', compact('catalogues'));
}

}
