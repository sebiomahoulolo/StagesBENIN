<?php

namespace App\Http\Controllers;
use App\Models\Catalogue;
use App\Models\Actualite;
use App\Models\Avis;
use App\Models\Secteur;
use App\Models\Category;
use App\Models\Event;
use App\Models\Annonce;
use App\Models\Specialite;
use Illuminate\Http\Request;
class PageController extends Controller
{
    
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
        $actualites = Actualite::all();
        $nombre_actualites = $actualites->count();
    
        $evenements = Event::where('is_published', 1)->get();
        $nombre_events = $evenements->count();
    
        
        $annonces = Annonce::where('statut', 'approuve')->get();// Récupère toutes les offres
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
