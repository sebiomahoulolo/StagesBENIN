<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
    public function events() {
        $events = Event::paginate(10); // Utiliser la pagination pour de meilleures performances
        return view('admin.evenements', compact('events'));
    }
    
    /**
     * Affiche les événements à venir dans le tableau de bord étudiant.
     *
     * @return \Illuminate\Http\Response
     */
   

   
    public function upcomingForStudent()
    {
        // Récupérer uniquement les événements publiés et à venir
        $upcomingEvents = Event::where('is_published', 1)
                             ->where('start_date', '>', now())
                             ->orderBy('start_date', 'asc')
                             ->get();

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
        'max_participants' => 'nullable|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($validator->fails()) {
        Log::warning('Validation échouée : ', $validator->errors()->toArray());
        return response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation échouée, veuillez vérifier vos données.'
        ], 422);
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
            'user_id' => $user_id
        ]);

        Log::info('Événement créé avec succès : ', ['event_id' => $event->id]);

        return response()->json([
            'success' => true,
            'message' => 'Événement créé avec succès. Il sera publié après validation.',
            'event' => $event
        ], 201);

    } catch (\Exception $e) {
        Log::error('Erreur lors de la création de l\'événement : ' . $e->getMessage());

        return response()->json([
            'errors' => ['general' => ['Une erreur est survenue lors de la création de l\'événement.']],
            'message' => 'Échec de la création de l\'événement.'
        ], 500);
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
    public function showForStudent($id)
    {
        $event = Event::findOrFail($id);
        
        // Vérifier si l'étudiant est déjà inscrit à cet événement
        $isRegistered = false;
        
        if (auth()->user()->etudiant) {
            $isRegistered = DB::table('registrations')

                ->where('event_id', $event->id)
                ->where('etudiant_id', auth()->user()->etudiant->id)
                ->exists();
        }
        
        return view('etudiants.evenements.show', compact('event', 'isRegistered'));
    }

    /**
     * Permet à un étudiant de s'inscrire à un événement.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function registerStudent($id)
    {
        $event = Event::findOrFail($id);
        
        // Vérifier si l'événement est déjà passé
        if ($event->start_date < now()) {
            return redirect()->back()->with('error', 'Cet événement est déjà passé. Vous ne pouvez plus vous y inscrire.');
        }
        
        // Vérifier si l'étudiant est déjà inscrit
        if (auth()->user()->etudiant) {
            $etudiantId = auth()->user()->etudiant->id;
            
            $alreadyRegistered = DB::table('registrations')
                ->where('event_id', $event->id)
                ->where('etudiant_id', $etudiantId)
                ->exists();
            
            if ($alreadyRegistered) {
                return redirect()->back()->with('error', 'Vous êtes déjà inscrit à cet événement.');
            }
            
            // Vérifier si le nombre maximum de participants est atteint
            if ($event->max_participants) {
                $currentParticipants = DB::table('registrations')
                    ->where('event_id', $event->id)
                    ->count();
                
                if ($currentParticipants >= $event->max_participants) {
                    return redirect()->back()->with('error', 'Cet événement a atteint sa capacité maximale. Vous ne pouvez plus vous y inscrire.');
                }
            }
            
            // Inscrire l'étudiant à l'événement
            DB::table('registrations')->insert([
                'event_id' => $event->id,
                'etudiant_id' => $etudiantId,
                'registered_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Vous êtes maintenant inscrit à cet événement.');
        }
        
        return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'inscription.');
    }
}