<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;         // Moins utilisé maintenant
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;       // Pour le débogage
use Illuminate\Support\Str;             // Pour le traitement d'image
use Carbon\Carbon; // Pour les dates
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    // Vérification dans EventController.php


 
    public function downloadTicket($eventId)
    {
        $event = Event::findOrFail($eventId);
        $pdf = Pdf::loadView('evenements.event-details', compact('event'));
        return $pdf->download('ticket-'.$event->id.'.pdf');
        
    }
 

  
    public function generateTicket($id)
    {
        try {
            $event = Event::findOrFail($id);
    
            if ($event->ticket_price === null) {
                return redirect()->back()->with('error', 'Cet événement ne propose pas de tickets à vendre.');
            }
    
            // Génère l’URL unique de vérification
            $verificationUrl = route('events.verify', [
                'id' => $event->id,
                'reference' => strtoupper(substr(md5($event->id . time()), 0, 10))
            ]);
    
            // Génère le QR code en SVG (format texte compatible avec les PDF)
            $qrCodeSvg = QrCode::format('svg')->size(120)->generate($verificationUrl);
    
            // Charge la vue PDF avec le QR code inclus
            $pdf = PDF::loadView('evenements.event-details', compact('event', 'qrCodeSvg'));
    
            return $pdf->download('ticket-' . Str::slug($event->title) . '.pdf');
    
        } catch (\Throwable $e) {
            Log::error("Erreur inattendue lors de la génération du ticket pour l'événement ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue pendant la génération du ticket.');
        }
    }
    
    
    

   /**
     * Vérifie un ticket d'événement
     * 
     * @param int $id ID de l'événement
     * @param string $reference Référence unique du ticket
     * @return \Illuminate\Http\Response
     */
    public function verifyTicket($id, $reference)
    {
  return view('evenements.verify-ticket', [
            'event' => Event::findOrFail($id),
            'reference' => $reference,
            'valid' => true // À remplacer par une vérification réelle
        ]);
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
    // --- Méthodes Étudiant ---

    public function upcomingForStudent()
    {
        $upcomingEvents = Event::where('is_published', 1)
                             ->where('start_date', '>', now()) // Uniquement futurs
                             ->orderBy('start_date', 'asc')
                             ->paginate(10);

        return view('etudiants.evenements.upcoming', compact('upcomingEvents'));
    }

    public function toggleStatus($id)
    {
        $event = Event::findOrFail($id);

        // Si l'événement est privé (0), on le rend publié (1)
        $event->is_published = !$event->is_published;

        $event->save();

        return redirect()->back()->with('success', 'Statut de l\'événement mis à jour.');
    }

   // Dans EventController.php, modifions la méthode register pour retourner une réponse JSON
public function register(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // Vérifier si l'email existe déjà pour cet événement
        $existing = Registration::where('email', $request->email)
                             ->where('event_id', $request->event_id)
                             ->first();
        
        if ($existing) {
            return response()->json([
                'errors' => [
                    'email' => ['Vous êtes déjà inscrit à cet événement avec cette adresse email.']
                ]
            ], 422);
        }

        Registration::create($request->all());

        return response()->json(['message' => 'Inscription réussie !'], 200);
    } catch (\Exception $e) {
        Log::error('Erreur lors de l\'inscription : '.$e->getMessage());
        return response()->json(['errors' => ['general' => ['Une erreur est survenue lors de l\'inscription.']]], 500);
    }
}







public function store(Request $request)
{
    Log::info('Données reçues : ', $request->all());

    // Vérification de l'utilisateur connecté
    $user = auth()->user();
    $user_id = $user ? $user->id : null;
    $email = $user ? $user->email : ($request->email ?? null); // Utiliser l'email de l'utilisateur si connecté

    Log::info('Utilisateur connecté : ', ['user_id' => $user_id ?? 'Non connecté', 'email' => $email]);

    // Ajouter l'email au request AVANT la validation
    $request->merge(['email' => $email]);

    // Validation des données
    $validator = Validator::make($request->all(), [
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:20',
        'email' => 'required|email|max:255', // Maintenant, l'email sera toujours présent
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'location' => 'nullable|string|max:255',
        'type' => 'nullable|string|max:100',
        'ticket_price' => 'nullable|string|max:20',
        'max_participants' => 'nullable|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($validator->fails()) {
        Log::warning('Validation échouée : ', $validator->errors()->toArray());
        
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('message', 'Validation échouée, veuillez vérifier vos données.');
    }
    
    

    // Traitement de l'image si elle existe
    $imagePath = null;
    if ($request->hasFile('image')) {
        try {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images/events'), $imageName);
            $imagePath = $imageName;
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement de l\'image : ' . $e->getMessage());
            return response()->json([
                'errors' => ['image' => ['Erreur lors du traitement de l\'image.']],
                'message' => 'Impossible de traiter l\'image.'
            ], 500);
        }
    }

    try {
        // Création de l'événement
        $event = Event::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $email, // Utiliser l'email récupéré
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'type' => $request->type,
            'max_participants' => $request->max_participants,
            'image' => $imagePath,
            'is_published' => 0,
            'ticket_price' => $request->ticket_price,
            'user_id' => $user_id
        ]);

        Log::info('Événement créé avec succès : ', ['event_id' => $event->id]);

        return redirect()->back()->with('success', 'Événement créé avec succès. Il sera publié après validation.');


    } catch (\Exception $e) {
        Log::error('Erreur lors de la création de l\'événement : ' . $e->getMessage());

        if ($validator->fails()) {
            Log::warning('Validation échouée : ', $validator->errors()->toArray());
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Validation échouée, veuillez vérifier vos données.');
        }
        
    }
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

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.evenements')->with('success', 'Événement supprimé avec succès.');
    }

    /**
     * Affiche les détails d'un événement pour les étudiants.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



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
    public function create()
{
    return view('pages.event-form'); // Assure-toi que la vue existe dans resources/views/events/create.blade.php
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
        
        // if (auth()->user()->etudiant) {
        //     $isRegistered = DB::table('registrations')

        //         ->where('event_id', $event->id)
        //         ->where('etudiant_id', auth()->user()->etudiant->id)
        //         ->exists();
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