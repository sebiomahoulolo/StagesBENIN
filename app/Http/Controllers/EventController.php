<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{

   
public function generatePDF($id)
{
    $event = Event::findOrFail($id); // Récupère l'événement par ID

    $pdf = Pdf::loadView('evenements.event-details', compact('event')); // Vue pour le design PDF
    return $pdf->download('ticket-' . $event->title . '.pdf'); // Téléchargement du PDF
}

    /**
     * Stocker un nouvel événement dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    // Méthode pour afficher uniquement les événements publiés
    public function index()
    {
        // Récupérer uniquement les événements publiés
        $events = Event::where('is_published', 1)->get();

        return view('evenements.index', compact('events'));
    }

    public function toggleStatus($id)
{
    $event = Event::findOrFail($id);

    // Si l'événement est privé (0), on le rend publié (1)
    $event->is_published = !$event->is_published;

    $event->save();

    return redirect()->back()->with('success', 'Statut de l’événement mis à jour.');
}

    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Traitement de l'image si elle existe
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/events'), $imageName);
            $imagePath =  $imageName;
        }

        // Création de l'événement
        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'type' => $request->type,
            'max_participants' => $request->max_participants,
            'image' => $imagePath,
            'is_published' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Événement créé avec succès',
            'event' => $event
        ], 201);
    }



public function show($id)
{
    $event = Event::findOrFail($id);
    return view('evenements.show', compact('event'));
}



public function edit($id)
{
    $event = Event::findOrFail($id);
    return view('evenements.edit', compact('event'));
}
public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);
    $event->update($request->all());

    return redirect()->route('evenements.show', $event->id)->with('success', 'Événement mis à jour avec succès.');
}
// app/Http/Controllers/EventController.php

public function destroy($id)
{
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect()->route('evenements.index')->with('success', 'Événement supprimé avec succès.');
}

}