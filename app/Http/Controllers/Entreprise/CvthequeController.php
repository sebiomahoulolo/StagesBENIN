<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CvProfile;
use App\Models\Etudiant;
use App\Models\Tier;

class CvthequeController extends Controller
{
    /**
     * Constructeur qui applique le middleware auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche la liste de tous les CV disponibles
     */
    public function index()
    {
        // $cvProfiles = CvProfile::with(['etudiant', 'formations', 'experiences', 'competences'])
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $tiers = Tier::join('etudiants', 'tier.user_id', '=', 'etudiants.user_id')
            ->join('users', 'etudiants.user_id', '=', 'users.id')
            ->select('tier.*', 'etudiants.nom', 'etudiants.prenom', 'etudiants.email', 'etudiants.telephone', 'etudiants.formation', 'etudiants.niveau', 'etudiants.id as etudiant_id')
            ->where('tier.payment_status', 'paid')->get();

            // dd($tiers);

        // Débogage
        \Log::info('CV-thèque chargée', ['count' => count($tiers)]);

        return view('entreprises.cvtheque', compact('tiers'));
    }

    /**
     * Affiche un CV spécifique
     */
    public function view($id)
    {
        $cvProfile = CvProfile::with([
            'etudiant',
            'formations',
            'experiences',
            'competences',
            'langues',
            'centresInteret',
            'certifications',
            'projets',
            'references'
        ])->findOrFail($id);

        // Débogage
        \Log::info('CV détail chargé', ['id' => $id, 'étudiant' => optional($cvProfile->etudiant)->nom]);

        // Vérifier si l'étudiant est actif
        if (!$cvProfile->etudiant || $cvProfile->etudiant->status !== 'active') {
            return redirect()->route('entreprises.cvtheque.index')
                ->with('error', 'Ce CV n\'est plus disponible.');
        }

        return view('entreprises.cv_detail', compact('cvProfile'));
    }

    public function specialite()
    {
        $entreprises = \App\Models\Entreprise::all();
        $specialites = \App\Models\Specialite::with('secteur')->get();

        return view('admin.cvtheque.specialite', compact('entreprises', 'specialites'));
    }
}
