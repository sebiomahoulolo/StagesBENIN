<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration; // <-- Assurez-vous de l'import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;         // Moins utilisé maintenant
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;       // Pour le débogage
use Illuminate\Support\Str;             // Pour le traitement d'image
use Carbon\Carbon; // Pour les dates

class EventController extends Controller
{

    public function generatePDF($id)
    {
        try {
            $event = Event::findOrFail($id);
            // Assurez-vous que la vue 'evenements.event-details' existe et est adaptée pour dompdf
            $pdf = Pdf::loadView('evenements.event-details', compact('event'));
            return $pdf->download('ticket-' . Str::slug($event->title) . '.pdf'); // Utiliser Str::slug
        } catch (\Exception $e) {
            Log::error("Erreur génération PDF Event ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Impossible de générer le ticket PDF.');
        }
    }

    // --- Méthodes publiques ---
    public function index()
    {
        $events = Event::where('is_published', 1)
                       ->where('end_date', '>=', now()) // Afficher aussi ceux en cours
                       ->orderBy('start_date', 'asc') // Trier par date de début
                       ->paginate(9);
        return view('evenements.index', compact('events'));
    }

    public function show($id)
    {
        try {
            // Un visiteur peut voir un événement publié même s'il est passé
            $event = Event::where('is_published', 1)->findOrFail($id);
            return view('evenements.show', compact('event'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('events.index')->with('error', 'Événement non trouvé.');
        }
    }

    // --- Méthodes Admin ---
    public function events() // Pour la vue admin/evenements (Liste complète)
    {
        // Cette ligne fonctionnera maintenant grâce à la relation ajoutée au modèle Event
        $events = Event::with('user')
                       ->withCount('registrations') // Compte les inscriptions via la relation
                       ->latest('start_date')
                       ->paginate(10);
        return view('admin.evenements', compact('events')); // Assurez-vous que cette vue existe
    }

    // Méthode pour afficher le formulaire de création admin
    public function create() // Assurez-vous que la route existe: admin.events.create
    {
         return view('admin.events.create'); // Assurez-vous que cette vue existe
    }


    public function store(Request $request) // Pour la création admin
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:events,title', // Titre unique
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today', // Ne peut pas être dans le passé
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Ajout webp
            'is_published' => 'sometimes|boolean' // Permettre de définir la publication
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.unique' => 'Ce titre d\'événement existe déjà.',
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être de type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        if (!$user || !$user->isAdmin()) {
             return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                // Nom de fichier plus robuste
                $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/events'), $imageName); // Assurez-vous que le dossier existe et est accessible en écriture
                $imagePath = $imageName;
            } catch (\Exception $e) {
                 Log::error("Erreur upload image event admin: ".$e->getMessage());
                 // Informer l'admin que l'image n'a pas pu être chargée, mais continuer
                 return redirect()->back()->withErrors(['image' => 'Erreur lors du téléchargement de l\'image.'])->withInput();
            }
        }

        try {
            Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'location' => $request->location,
                'type' => $request->type,
                'max_participants' => $request->max_participants,
                'image' => $imagePath,
                'is_published' => $request->boolean('is_published', false),
                'user_id' => $user->id
            ]);

            return redirect()->route('admin.evenements') // Rediriger vers la liste admin des événements
                       ->with('success', 'Événement créé avec succès.');

        } catch (\Exception $e) {
             Log::error("Erreur création event admin: ".$e->getMessage(), ['trace' => $e->getTraceAsString()]);
             return redirect()->back()->with('error', 'Erreur serveur lors de la création de l\'événement.')->withInput();
        }
    }

     public function edit($id) // Pour admin
    {
        try {
            $event = Event::findOrFail($id);
            // Ajoutez une Policy check si nécessaire : $this->authorize('update', $event);
            return view('admin.events.edit', compact('event')); // Assurez-vous que la vue admin existe
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.evenements')->with('error', 'Événement non trouvé.');
        }
    }

    public function update(Request $request, $id) // Pour admin
    {
        try {
            $event = Event::findOrFail($id);
            // Ajoutez une Policy check : $this->authorize('update', $event);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return redirect()->route('admin.evenements')->with('error', 'Événement non trouvé.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:events,title,' . $event->id, // Ignorer l'ID actuel pour unique
            'description' => 'nullable|string',
            'start_date' => 'required|date', // On peut autoriser la modification dans le passé si besoin métier
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
             // Logique pour supprimer l'ancienne image et uploader la nouvelle
            try {
                 // Supprimer l'ancienne image
                if ($event->image && file_exists(public_path('images/events/' . $event->image))) {
                    @unlink(public_path('images/events/' . $event->image)); // @ pour ignorer les erreurs si fichier déjà supprimé
                }
                // Uploader la nouvelle
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/events'), $imageName);
                $data['image'] = $imageName; // Mettre à jour le chemin dans les données validées
            } catch (\Exception $e) {
                Log::error("Erreur upload màj image event ID {$id}: ".$e->getMessage());
                 return redirect()->back()->withErrors(['image' => 'Erreur lors du téléchargement de la nouvelle image.'])->withInput();
            }
        }

        // Gérer la publication explicitement si la case n'est pas cochée
        $data['is_published'] = $request->has('is_published');

        try {
            $event->update($data);
            return redirect()->route('admin.evenements') // Rediriger vers la liste
                           ->with('success', 'Événement mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error("Erreur màj event ID {$id}: ".$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Erreur serveur lors de la mise à jour.')->withInput();
        }
    }

    public function destroy($id) // Pour admin
    {
        try {
            $event = Event::findOrFail($id);
            // Policy check : $this->authorize('delete', $event);

            // Supprimer l'image associée
            if ($event->image && file_exists(public_path('images/events/' . $event->image))) {
                 @unlink(public_path('images/events/' . $event->image));
            }
            // La suppression des inscriptions se fera par cascade si défini dans la migration,
            // sinon il faudrait les supprimer manuellement avant : Registration::where('event_id', $id)->delete();
            $event->delete();
            return redirect()->route('admin.evenements')
                           ->with('success', 'Événement supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return redirect()->route('admin.evenements')->with('error', 'Événement non trouvé.');
        } catch (\Exception $e) {
             Log::error("Erreur suppression event ID {$id}: ".$e->getMessage(), ['trace' => $e->getTraceAsString()]);
             return redirect()->back()->with('error', 'Erreur serveur lors de la suppression.');
        }
    }

     public function toggleStatus($id) // Pour admin
    {
         try {
            $event = Event::findOrFail($id);
            // Policy check?

            $event->is_published = !$event->is_published;
            $event->save();

            $message = $event->is_published ? 'Événement publié.' : 'Événement masqué.';
            return redirect()->back()->with('success', $message);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
              return redirect()->back()->with('error', 'Événement non trouvé.');
         }
    }


    // --- Méthodes Étudiant ---

    public function upcomingForStudent()
    {
        $upcomingEvents = Event::where('is_published', 1)
                             ->where('start_date', '>', now()) // Uniquement futurs
                             ->orderBy('start_date', 'asc')
                             ->paginate(10);

        return view('etudiants.evenements.upcoming', compact('upcomingEvents'));
    }

    public function showForStudent($id)
    {
         try {
            $event = Event::where('is_published', 1)->findOrFail($id);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
              return redirect()->route('etudiants.evenements.upcoming')->with('error', 'Événement non trouvé ou non disponible.');
         }

        $user = Auth::user();
        $isRegistered = false;

        if ($user) {
            $isRegistered = Registration::where('event_id', $event->id)
                                        ->where('email', $user->email) // Vérifie par email
                                        ->exists();
        }

        $currentParticipants = Registration::where('event_id', $event->id)->count();
        $event->current_participants = $currentParticipants;

        return view('etudiants.evenements.show', compact('event', 'isRegistered'));
    }

    public function registerStudent(Request $request, $id)
    {
        // 1. Trouver l'événement ou rediriger si non trouvé/non publié
        try {
            $event = Event::where('is_published', 1)->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('etudiants.evenements.upcoming')
                       ->with('error', 'Cet événement n\'est pas disponible.');
        }

        $user = Auth::user(); // Utilisateur authentifié

        // 2. Valider les données reçues (même si readonly, sécurité)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Si la validation échoue (ne devrait pas arriver avec readonly, mais bon)
        if ($validator->fails()) {
            Log::warning("Validation échouée pour inscription event ID {$id}", ['errors' => $validator->errors()]);
            return redirect()->route('etudiants.evenements.show', $event->id)
                       ->withErrors($validator)
                       ->with('error', 'Les informations fournies sont invalides.'); // Message d'erreur
        }

        // 3. Vérifier que l'email soumis correspond à l'utilisateur connecté
        //    (Sécurité pour éviter qu'un utilisateur n'inscrive quelqu'un d'autre)
        if ($user && $request->email !== $user->email) {
            Log::warning("Tentative d'inscription avec email différent pour event ID {$id}", ['user_email' => $user->email, 'request_email' => $request->email]);
             return redirect()->route('etudiants.evenements.show', $event->id)
                        ->with('error', 'L\'adresse email ne correspond pas à votre compte.');
        }

        // 4. Vérifier si l'événement est déjà passé
        if ($event->start_date < now()) {
             return redirect()->route('etudiants.evenements.show', $event->id)
                        ->with('error', 'Cet événement est déjà passé. Inscription impossible.');
        }

        // 5. Vérifier si déjà inscrit
        $alreadyRegistered = Registration::where('event_id', $event->id)
                                         ->where('email', $request->email)
                                         ->exists();
        if ($alreadyRegistered) {
             return redirect()->route('etudiants.evenements.show', $event->id)
                        ->with('info', 'Vous êtes déjà inscrit(e) à cet événement.'); // Utiliser 'info' ou 'warning'
        }

        // 6. Vérifier la capacité maximale
        if ($event->max_participants) {
            $currentParticipants = Registration::where('event_id', $event->id)->count();
            if ($currentParticipants >= $event->max_participants) {
                 return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Désolé, cet événement est complet.');
            }
        }

        // 7. Enregistrer l'inscription (le point critique)
        try {
            // Préparer les données (pour être sûr des clés)
            $registrationData = [
                'event_id' => $event->id,
                'name' => $request->name,
                'email' => $request->email,
                // 'user_id' => $user->id, // Décommentez si la colonne existe et est dans $fillable
            ];

            Log::info("Tentative d'enregistrement avec données:", $registrationData); // Log des données

            // Utiliser create() - NÉCESSITE $fillable dans Registration.php
            Registration::create($registrationData);

            Log::info("Inscription réussie pour Event ID {$id} avec email {$request->email}"); // Log succès

            return redirect()->route('etudiants.evenements.show', $event->id)
                           ->with('success', 'Inscription réussie !'); // Message succès simple

        } catch (\Illuminate\Database\QueryException $qe) { // Erreur spécifique BDD
            Log::error("Erreur SQL inscription événement ID {$event->id}: " . $qe->getMessage(), [
                'sql' => $qe->getSql(),
                'bindings' => $qe->getBindings(),
                'trace' => $qe->getTraceAsString()
            ]);
             return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Erreur de base de données lors de l\'inscription.');
        } catch (\Illuminate\Database\Eloquent\MassAssignmentException $mae) { // Erreur MassAssignment
             Log::error("Erreur MassAssignment inscription événement ID {$event->id}: " . $mae->getMessage(), ['trace' => $mae->getTraceAsString()]);
             return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Erreur de configuration (Mass Assignment). Contactez l\'administrateur.');
        }
        catch (\Exception $e) { // Autres erreurs
            Log::error("Erreur Générale inscription événement ID {$event->id}: " . $e->getMessage(), [
                'exception_type' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
             return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Une erreur technique est survenue. Veuillez réessayer.'); // Votre message générique
        }
    }
}