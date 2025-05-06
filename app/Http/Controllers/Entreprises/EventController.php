<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        
        return view('entreprises.evenements.index', compact('events'));
    }

    public function create()
    {
        return view('entreprises.evenements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images/events'), $imageName);
            $imagePath = $imageName;
        }

        $event = Event::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'type' => $request->type,
            'max_participants' => $request->max_participants,
            'image' => $imagePath,
            'is_published' => false // Par défaut non publié, en attente de validation admin
        ]);

        return redirect()->route('entreprises.evenements.index')
            ->with('success', 'Événement créé avec succès. Il sera publié après validation par un administrateur.');
    }

    public function show(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }
        return view('entreprises.evenements.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('entreprises.evenements.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::delete('public/events/' . $event->image);
            }
            
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = basename($imagePath);
        }

        $event->update($validated);

        return redirect()->route('entreprises.evenements.index')
            ->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        if ($event->image && file_exists(public_path('images/events/' . $event->image))) {
            unlink(public_path('images/events/' . $event->image));
        }

        $event->delete();

        return redirect()->route('entreprises.evenements.index')
            ->with('success', 'Événement supprimé avec succès.');
    }
}