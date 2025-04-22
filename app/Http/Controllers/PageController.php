<?php

namespace App\Http\Controllers;
use App\Models\Catalogue;
use Illuminate\Http\Request;

class PageController extends Controller
{
   
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


public function show($id)
{
    $catalogue = Catalogue::findOrFail($id);
    return view('pages.catalogueplus', compact('catalogue'));
}

    

public function catalogue()
{
    $catalogues = Catalogue::all();
    return view('pages.catalogue', compact('catalogues'));
}

}
