<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User; // Assurez-vous que ce modèle est utilisé si nécessaire
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\DB; // Moins utilisé si Eloquent suffit
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventController extends Controller
{

    public function generatePDF($id)
    {
        try {
            $event = Event::findOrFail($id);
            $pdf = Pdf::loadView('evenements.event-details', compact('event'));
            return $pdf->download('ticket-' . Str::slug($event->title) . '.pdf');
        } catch (\Exception $e) {
            Log::error("Erreur génération PDF Event ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Impossible de générer le ticket PDF.');
        }
    }

    // --- Méthodes publiques ---
    public function index()
    {
        $events = Event::where('is_published', 1)
                       ->where('end_date', '>=', now())
                       ->orderBy('start_date', 'asc')
                       ->paginate(9);
        return view('evenements.index', compact('events'));
    }

    // --- Méthodes Admin ---
    public function events()
    {
        $events = Event::with('user') // Eager load l'utilisateur créateur
                       ->withCount('registrations')
                       ->latest('start_date') // Ou created_at si plus pertinent
                       ->paginate(10);
        return view('admin.evenements', compact('events'));
    }

    public function create()
    {
         return view('admin.events.create');
    }

    public function store(Request $request)
    {
        Log::info('Début de la méthode store. Données reçues : ', $request->all());

        $user = auth()->user(); // Récupère l'utilisateur authentifié
        $user_id = $user ? $user->id : null; // ID de l'utilisateur, ou null si non connecté
        
        // L'email de l'utilisateur connecté sera utilisé s'il est disponible.
        // Si non connecté (par exemple, API sans authentification), on prend celui du request s'il existe.
        $email_to_use = $user ? $user->email : $request->input('email');

        // S'assurer que l'email est présent pour la validation et l'enregistrement
        if (!$email_to_use) {
            Log::warning('Validation échouée : Email manquant et utilisateur non connecté.');
            return response()->json([
                'errors' => ['email' => ['L\'adresse email est requise.']],
                'message' => 'L\'adresse email est requise.'
            ], 422);
        }
        
        // Ajouter l'email déterminé au request pour la validation
        $requestData = $request->all();
        $requestData['email'] = $email_to_use;


        $validator = Validator::make($requestData, [
            // Les champs first_name, last_name, phone_number sont optionnels comme dans votre code
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'required|email|max:255', // Email est requis
            'title' => 'required|string|max:255|unique:events,title', // Titre unique
            'description' => 'nullable|string', // 'string' n'enlève pas les sauts de ligne
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Ajout de webp
        ], [
            // Messages de validation personnalisés (optionnel mais bonne pratique)
            'title.required' => 'Le titre de l\'événement est obligatoire.',
            'title.unique' => 'Un événement avec ce titre existe déjà.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.after_or_equal' => 'La date de début ne peut pas être antérieure à aujourd\'hui.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'image.image' => 'Le fichier doit être une image (jpeg, png, jpg, gif, webp).',
            'image.mimes' => 'Format d\'image non supporté. Uniquement jpeg, png, jpg, gif, webp.',
            'image.max' => 'L\'image ne doit pas dépasser 2Mo.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation échouée pour la création d\'événement : ', $validator->errors()->toArray());
            // Retourner une réponse JSON si c'est une API, sinon redirect pour formulaires web
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'Validation échouée, veuillez vérifier vos données.'
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated(); // Récupère les données validées

        $imagePath = null;
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                // Nom de fichier plus robuste pour éviter les conflits et caractères spéciaux
                $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/events'), $imageName);
                $imagePath = $imageName;
                 Log::info('Image téléchargée avec succès : ' . $imagePath);
            } catch (\Exception $e) {
                Log::error('Erreur lors du téléchargement de l\'image : ' . $e->getMessage());
                 if ($request->expectsJson()) {
                    return response()->json([
                        'errors' => ['image' => ['Erreur lors du traitement de l\'image.']],
                        'message' => 'Impossible de traiter l\'image.'
                    ], 500);
                }
                return redirect()->back()->with('error', 'Erreur lors du téléchargement de l\'image.')->withInput();
            }
        }

        try {
            $eventData = [
                'first_name' => $validatedData['first_name'] ?? null,
                'last_name' => $validatedData['last_name'] ?? null,
                'phone_number' => $validatedData['phone_number'] ?? null,
                'email' => $validatedData['email'], // Email validé
                'title' => $validatedData['title'],
                // La description est prise directement des données validées
                'description' => $validatedData['description'] ?? null,
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'location' => $validatedData['location'] ?? null,
                'type' => $validatedData['type'] ?? null,
                'max_participants' => $validatedData['max_participants'] ?? null,
                'image' => $imagePath,
                'is_published' => false, // Par défaut non publié, admin devra valider/publier
                'user_id' => $user_id // Peut être null si l'événement peut être créé par des non-connectés
            ];
            
            $event = Event::create($eventData);

            Log::info('Événement créé avec succès : ', ['event_id' => $event->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Événement créé avec succès. Il sera publié après validation par un administrateur.',
                    'event' => $event
                ], 201);
            }
            // Redirection pour les formulaires web classiques (admin)
            return redirect()->route('admin.evenements')->with('success', 'Événement créé. Il sera publié après validation.');


        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'événement : ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            if ($request->expectsJson()) {
                 return response()->json([
                    'errors' => ['general' => ['Une erreur est survenue lors de la création de l\'événement.']],
                    'message' => 'Échec de la création de l\'événement.'
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur serveur lors de la création de l\'événement.')->withInput();
        }
    }


    public function show($id) // Devrait être pour la vue publique/étudiant
    {
        // Logique pour la vue 'etudiants.evenements.show'
        // Si c'est le même que showForStudent, on peut fusionner ou appeler l'autre
        return $this->showForStudent($id);
    }

    public function edit($id) // Pour l'admin
    {
        try {
            $event = Event::findOrFail($id);
             // Potentiellement, ajouter une vérification de politique (Policy)
             // if (Auth::user()->cannot('update', $event)) {
             //     abort(403);
             // }
            return view('admin.events.edit', compact('event')); // Vue pour l'édition admin
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.evenements')->with('error', 'Événement non trouvé.');
        }
    }

    public function update(Request $request, $id) // Pour l'admin
    {
        try {
            $event = Event::findOrFail($id);
             // Policy check
             // if (Auth::user()->cannot('update', $event)) {
             //     abort(403);
             // }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.evenements')->with('error', 'Événement non trouvé.');
        }

        // Validation similaire à store, mais en ignorant l'ID actuel pour 'unique'
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:events,title,' . $event->id,
            'description' => 'nullable|string', // N'altère pas les sauts de ligne
            'start_date' => 'required|date', // Pas de after_or_equal:today pour permettre correction
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'sometimes|boolean' // Pour la case à cocher de publication
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($event->image && file_exists(public_path('images/events/' . $event->image))) {
                @unlink(public_path('images/events/' . $event->image));
            }
            // Uploader la nouvelle
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/events'), $imageName);
            $validatedData['image'] = $imageName;
        } elseif ($request->has('remove_image')) { // Option pour supprimer l'image sans en uploader une nouvelle
            if ($event->image && file_exists(public_path('images/events/' . $event->image))) {
                @unlink(public_path('images/events/' . $event->image));
            }
            $validatedData['image'] = null;
        }


        // Gérer la publication explicitement
        $validatedData['is_published'] = $request->has('is_published');


        try {
            $event->update($validatedData);
            return redirect()->route('admin.evenements')->with('success', 'Événement mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error("Erreur MàJ event ID {$id}: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Erreur serveur lors de la mise à jour.')->withInput();
        }
    }


    public function destroy($id) // Pour l'admin
    {
        try {
            $event = Event::findOrFail($id);
             // Policy check
             // if (Auth::user()->cannot('delete', $event)) {
             //     abort(403);
             // }

            // Supprimer l'image associée
            if ($event->image && file_exists(public_path('images/events/' . $event->image))) {
                 @unlink(public_path('images/events/' . $event->image));
            }
            // Les inscriptions pourraient être supprimées par cascade si défini dans la migration
            // ou manuellement: Registration::where('event_id', $id)->delete();
            $event->delete();
            return redirect()->route('admin.evenements')
                           ->with('success', 'Événement supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return redirect()->route('admin.evenements')->with('error', 'Événement non trouvé.');
        } catch (\Exception $e) {
             Log::error("Erreur suppression event ID {$id}: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
             return redirect()->route('admin.evenements')->with('error', 'Erreur serveur lors de la suppression.');
        }
    }

    // Méthode pour changer le statut de publication (admin)
    public function toggleStatus($id)
    {
         try {
            $event = Event::findOrFail($id);
            // Policy check?

            $event->is_published = !$event->is_published;
            $event->save();

            $message = $event->is_published ? 'Événement publié avec succès.' : 'La publication de l\'événement a été annulée.';
            return redirect()->back()->with('success', $message);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
              return redirect()->back()->with('error', 'Événement non trouvé.');
         }
    }


    // --- Méthodes Étudiant ---
    public function upcomingForStudent()
    {
        $upcomingEvents = Event::where('is_published', 1)
                             ->where('start_date', '>', now())
                             ->orderBy('start_date', 'asc')
                             ->paginate(10); // Ajustez la pagination si nécessaire

        return view('etudiants.evenements.upcoming', compact('upcomingEvents'));
    }


    public function showForStudent($id)
    {
         try {
            // Seuls les événements publiés sont visibles par les étudiants
            $event = Event::where('is_published', 1)->findOrFail($id);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
              return redirect()->route('etudiants.evenements.upcoming')->with('error', 'Événement non trouvé ou non disponible.');
         }

        $user = Auth::user();
        $isRegistered = false;

        if ($user) {
            // Utilise la relation 'registrations' définie dans le modèle Event
            $isRegistered = $event->registrations()->where('email', $user->email)->exists();
        }

        // Compte les participants pour cet événement spécifique
        // On peut aussi utiliser la relation: $event->registrations()->count()
        // ou charger avec un withCount dans la requête initiale si c'est souvent utilisé.
        $currentParticipants = Registration::where('event_id', $event->id)->count();
        $event->current_participants = $currentParticipants; // Ajoute dynamiquement à l'objet event

        return view('etudiants.evenements.show', compact('event', 'isRegistered'));
    }

    public function registerStudent(Request $request, $id)
    {
        try {
            $event = Event::where('is_published', 1)->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('etudiants.evenements.upcoming')
                       ->with('error', 'Cet événement n\'est plus disponible pour inscription.');
        }

        $user = Auth::user();
        if (!$user) {
            // Devrait être géré par le middleware 'auth', mais double sécurité
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour vous inscrire.');
        }

        // Valider les données soumises (name et email sont dans des champs cachés)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            Log::warning("Validation échouée pour inscription directe event ID {$id}", ['errors' => $validator->errors(), 'user_id' => $user->id]);
            return redirect()->route('etudiants.evenements.show', $event->id)
                       ->withErrors($validator) // Renvoie les erreurs pour affichage potentiel
                       ->with('error', 'Une erreur est survenue avec vos informations.');
        }
        
        // Sécurité supplémentaire: vérifier que l'email soumis correspond à l'utilisateur connecté
        if ($request->email !== $user->email) {
            Log::warning("Tentative d'inscription avec email différent pour event ID {$id} par user ID {$user->id}", ['request_email' => $request->email]);
            return redirect()->route('etudiants.evenements.show', $event->id)
                       ->with('error', 'Une erreur de sécurité est survenue.');
        }

        // Vérifier si l'événement est déjà passé (redondant avec la logique de la vue, mais bonne sécurité backend)
        if ($event->start_date < now() && !$event->is_ongoing) { // Permettre inscription si en cours? À discuter.
             return redirect()->route('etudiants.evenements.show', $event->id)
                        ->with('error', 'Cet événement est déjà terminé. Inscription impossible.');
        }

        // Vérifier si déjà inscrit
        // Utilisation de la relation pour la clarté
        if ($event->registrations()->where('email', $user->email)->exists()) {
             return redirect()->route('etudiants.evenements.show', $event->id)
                        ->with('info', 'Vous êtes déjà inscrit(e) à cet événement.');
        }

        // Vérifier la capacité maximale
        if ($event->max_participants) {
            // Compter directement via la relation pour être à jour
            if ($event->registrations()->count() >= $event->max_participants) {
                 return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Désolé, cet événement est complet.');
            }
        }

        try {
            $registrationData = [
                'event_id' => $event->id,
                'name' => $user->name, // Utiliser le nom de l'utilisateur connecté
                'email' => $user->email, // Utiliser l'email de l'utilisateur connecté
                // 'user_id' => $user->id, // Si vous avez une colonne user_id dans registrations et qu'elle est fillable
            ];

            Registration::create($registrationData);

            Log::info("Inscription directe réussie pour Event ID {$id} avec email {$user->email}");
            return redirect()->route('etudiants.evenements.show', $event->id)
                           ->with('success', 'Votre inscription à l\'événement a été enregistrée avec succès !');

        } catch (\Illuminate\Database\QueryException $qe) {
            Log::error("Erreur SQL inscription directe event ID {$event->id}: " . $qe->getMessage(), ['sql' => $qe->getSql(), 'bindings' => $qe->getBindings()]);
             return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Une erreur de base de données est survenue lors de l\'inscription.');
        } catch (\Illuminate\Database\Eloquent\MassAssignmentException $mae) {
             Log::error("Erreur MassAssignment inscription directe event ID {$event->id}: " . $mae->getMessage());
             return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Erreur de configuration du serveur. Veuillez contacter l\'administrateur.');
        } catch (\Exception $e) {
            Log::error("Erreur Générale inscription directe event ID {$event->id}: " . $e->getMessage(), ['exception_type' => get_class($e)]);
             return redirect()->route('etudiants.evenements.show', $event->id)
                            ->with('error', 'Une erreur technique est survenue. Veuillez réessayer plus tard.');
        }
    }

    // La méthode register que vous aviez pour une API (ou AJAX)
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|exists:events,id',
                // Pour une inscription "invité", ces champs sont nécessaires
                'name' => 'required_without:user_id|string|max:255', // Requis si pas d'user_id
                'email' => 'required_without:user_id|email',      // Requis si pas d'user_id
                'user_id' => 'sometimes|nullable|exists:users,id' // Optionnel
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $event = Event::find($request->event_id);
            if (!$event || !$event->is_published || $event->start_date < now()) {
                return response()->json(['errors' => ['event_id' => ['Cet événement n\'est pas disponible pour inscription.']]], 422);
            }

            $email_to_check = $request->email;
            $name_to_register = $request->name;

            if ($request->filled('user_id')) {
                $user = User::find($request->user_id);
                if ($user) {
                    $email_to_check = $user->email;
                    $name_to_register = $user->name;
                }
            }
            
            if (!$email_to_check) {
                 return response()->json(['errors' => ['email' => ['Adresse email manquante.']]], 422);
            }


            // Vérifier si l'email existe déjà pour cet événement
            $existing = Registration::where('email', $email_to_check)
                                ->where('event_id', $request->event_id)
                                ->first();
            
            if ($existing) {
                return response()->json([
                    'message' => 'Vous êtes déjà inscrit à cet événement avec cette adresse email.',
                    'status' => 'already_registered'
                ], 409); // 409 Conflict est plus approprié
            }

            // Vérifier capacité
            if ($event->max_participants && $event->registrations()->count() >= $event->max_participants) {
                return response()->json(['errors' => ['event_id' => ['Cet événement est complet.']]], 422);
            }

            Registration::create([
                'event_id' => $request->event_id,
                'name' => $name_to_register,
                'email' => $email_to_check,
                'user_id' => $request->user_id ?? null,
            ]);

            return response()->json(['message' => 'Inscription réussie !'], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'inscription via API : '.$e->getMessage());
            return response()->json(['errors' => ['general' => ['Une erreur est survenue lors de l\'inscription.']]], 500);
        }
    }
}