<?php

namespace App\Http\Controllers;

use App\Models\CvProfil;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
  


public function store(Request $request)
{
    $validated = $request->validate([
        'username'        => 'required|string|max:255',
        'title'           => 'required|string|max:255',
        'email'           => 'required|email|max:255',
        'phone'           => 'required|string|max:20',
        'city'            => 'required|string|max:255',
        'url_linkedin'    => 'nullable|url',
        'url_portfolio'   => 'nullable|url',
        'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'situation_mat'   => 'required|string',
        'nationality'     => 'required|string',
        'birthday'        => 'required|date',
        'lieu_naissance'  => 'required|string',
        'resume'          => 'required|string',
    ]);

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('cv'), $filename);
        $validated['photo'] = $filename;
    }

    $validated['user_id'] = auth()->id(); 

    CvProfil::create($validated);
    
    return redirect()->route('cv.index')->with('success', 'Profil enregistré avec succès.');
}


    /**
     * Display the specified resource.
     */
    public function show(CvProfil $cvProfil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvProfil $cvProfil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CvProfil $cvProfil)
    {
        $validated = $request->validate([
            'username'        => 'required|string|max:255',
            'title'           => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:20',
            'city'            => 'required|string|max:255',
            'url_linkedin'    => 'nullable|url',
            'url_portfolio'   => 'nullable|url',
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'situation_mat'   => 'required|string',
            'nationality'     => 'required|string',
            'birthday'        => 'required|date',
            'lieu_naissance'  => 'required|string',
            'resume'          => 'required|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('cv'), $filename);
            $validated['photo'] = $filename;
        }

        $cvProfil->update($validated);
        return redirect()->route('cv.index')->with('success', 'Profil modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            $cvProfil = CvProfil::findOrFail($id);
        $cvProfil->delete();
        return redirect()->route('cv.index')->with('success', 'Profil supprimé avec succès.');
    }


}
