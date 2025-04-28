<?php

namespace App\Http\Controllers;
use App\Models\Catalogue;

use App\Models\Avis;
use App\Models\Event;
use Illuminate\Http\Request;
class PageController extends Controller
{
    

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
  

    public function evenements()
    {
        return view('pages.evenements'); 
    } public function publication()
    {
        return view('pages.publication'); 
    }

    public function services()
    {
        return view('pages.services'); 
    } public function actualites()
    {
        return view('pages.actualites'); 
    }

    public function programmes()
    {
        return view('pages.programmes'); 
    }
    
    public function create()
    {
        return view('pages.create_event'); 
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
    $catalogue = Catalogue::findOrFail($id);
    $avis = Avis::orderBy('created_at', 'desc')->get();
    
    return view('pages.catalogueplus2', compact('catalogue','avis'));
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
