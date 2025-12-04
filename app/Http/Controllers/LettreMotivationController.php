<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CvProfil;
use Barryvdh\DomPDF\Facade\Pdf;

class LettreMotivationController extends Controller
{
    // Affiche le formulaire d'édition
    public function edit()
    {
        $cvProfile = CvProfil::where('user_id', auth()->id())->first();
        // Générer le texte par défaut (même logique que la vue)
        $nom = $cvProfile->username ?? '';
        $poste = $cvProfile->title ?? '';
        $ville = $cvProfile->city ?? '';
        $email = $cvProfile->email ?? '';
        $telephone = $cvProfile->phone ?? '';
        $nationalite = $cvProfile->nationality ?? '';
        $resume = $cvProfile->resume ?? '';
        $diplome = '';
        if (!empty($cvProfile->formations) && count($cvProfile->formations)) {
            $lastFormation = $cvProfile->formations->sortByDesc('annee_fin')->first();
            $diplome = $lastFormation ? $lastFormation->diplome . ' à ' . $lastFormation->etablissement : '';
        }
        $experience = '';
        if (!empty($cvProfile->experiences) && count($cvProfile->experiences)) {
            $lastExp = $cvProfile->experiences->sortByDesc('date_fin')->first();
            $experience = $lastExp ? $lastExp->poste . ' chez ' . $lastExp->entreprise : '';
        }
        $lettreGeneree =
            ($ville ? $ville . ',' : '') . ' le ' . date('d/m/Y') . "\n"
            . "De : $nom\n"
            . "Email : $email\n"
            . "Téléphone : $telephone\n"
            . "Nationalité : $nationalite\n\n"
            . "Objet : Candidature au poste de " . ($poste ?: '...') . "\n\n"
            . "Madame, Monsieur,\n\n"
            . ($resume ? $resume . "\n\n" : '')
            . "Titulaire d'un diplôme en " . ($diplome ?: '...') . ", j'ai récemment exercé en tant que " . ($experience ?: '...') . ", ce qui m'a permis de consolider mes compétences professionnelles et d'approfondir mes connaissances en lien direct avec le poste de " . ($poste ?: '...') . ".\n\n"
            . "Tout au long de mon parcours, j'ai su faire preuve d'adaptabilité, d'autonomie et d'un fort esprit d'équipe. Mes expériences m'ont permis de développer une rigueur professionnelle, un sens aigu de l'organisation ainsi qu'une excellente aisance relationnelle.\n\n"
            . "Fort(e) de ces atouts, je suis convaincu(e) de pouvoir contribuer activement au développement de votre entreprise. Intégrer votre structure serait pour moi une opportunité enrichissante, tant sur le plan professionnel que personnel.\n\n"
            . "Je me tiens à votre disposition pour un entretien, au cours duquel je pourrai vous présenter plus en détail mon profil et mes motivations.\n\n"
            . "Dans l'attente de votre retour, je vous prie d'agréer, Madame, Monsieur, l'expression de mes salutations distinguées.\n\n"
            . "$nom";
        return view('cv.lettre_motivation', compact('cvProfile', 'lettreGeneree'));
    }

    // Génère et télécharge le PDF
    public function download(Request $request)
    {
        
        $request->validate([
            'lettre' => 'required|string',
        ]);
        $lettre = $request->input('lettre');
        $pdf = Pdf::loadView('cv.lettre_motivation_pdf', ['lettre' => $lettre]);
        $fileName = 'Lettre_de_motivation_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
    }
} 