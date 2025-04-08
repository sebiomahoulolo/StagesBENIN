<?php

namespace App\Http\Controllers;

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
    public function catalogue()
    {
        return view('pages.catalogue'); 
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
    } public function actulites()
    {
        return view('pages.actulites'); 
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
}
