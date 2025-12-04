<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CvProfil;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CvDownload;

class CVController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cvProfile = \App\Models\CvProfil::with([
            'etudiant',
            'formations',
            'experiences',
            'competences',
            'langues',
            'certifications',
            'loisirs',
            'projets',
            'references'
        ])->where('user_id', $user->id)->first();

        // Calcul du nombre de téléchargements restants (si pas abonné)
        $downloadsRestants = 3;
        if ($cvProfile) {
            $download = \App\Models\CvDownload::where('user_id', $user->id)
                ->where('cv_profil_id', $cvProfile->id)
                ->first();
            if ($download) {
                $downloadsRestants = max(0, 3 - $download->nombre_telechargements);
            }
        }

        return view('cv.index', compact('cvProfile', 'downloadsRestants'));
    }
    public function moncv()
    {
        $user = Auth::user();
        $cvProfile = \App\Models\CvProfil::where('user_id', $user->id)->first();
        $download = null;
        $downloadsRestants = 3;

        if ($cvProfile) {
            $download = CvDownload::where('user_id', $user->id)
                ->where('cv_profil_id', $cvProfile->id)
                ->first();
            if ($download) {
                $downloadsRestants = max(0, 3 - $download->nombre_telechargements);
            }
        }

        return view('cv.moncv', compact('downloadsRestants'));
    }
     public function template()
    {
        $user = Auth::user();
        $cvProfile = \App\Models\CvProfil::with([
            'etudiant', 'formations', 'experiences', 'competences', 'langues',
            'certifications', 'loisirs', 'projets', 'references'
        ])->where('user_id', $user->id)->first();

        $download = CvDownload::firstOrCreate(
            [
                'user_id' => $user->id,
                'cv_profil_id' => $cvProfile->id,
            ],
            [
                'fichier_pdf' => '',
                'nombre_telechargements' => 0,
            ]
        );

    if ($download->nombre_telechargements >= 3 && !$download->is_paid) {
             return back()->with('error', 'Vous avez atteint la limite de 3 téléchargements gratuits. Veuillez effectuer un paiement pour continuer.');
     }

        $pdf = PDF::loadView('templates.template', compact('cvProfile'));
        $pdf->setPaper('A4', 'portrait');
        $filename = $cvProfile->username ? $cvProfile->username . '_CV.pdf' : 'Mon_CV.pdf';

     $download->update([
           'fichier_pdf' => $filename,
            'nombre_telechargements' => $download->nombre_telechargements + 1,
            'dernier_telechargement' => now(),
         ]);

        return $pdf->download($filename);
    }
     public function tuto()
    {
        return view('tuto.index');
    }
    

     public function abonnement()
    {
        return view('abonnement.index');
    }



      public function success()
    {
        return view('cv.payment-success');
    }

    public function handlePaymentCallback(Request $request)
    {
        // Récupérer les paramètres de FredaPay
        $status = $request->get('status');
        $paymentId = $request->get('id');
        $locale = $request->get('locale');

        // Vérifier si le paiement est approuvé
        if ($status === 'approved' && $paymentId) {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'Vous devez être connecté pour confirmer le paiement.');
            }

            $cvProfile = \App\Models\CvProfil::where('user_id', $user->id)->first();
            
            if (!$cvProfile) {
                return redirect()->route('cv.moncv')->with('error', 'Profil CV non trouvé.');
            }

            $download = CvDownload::where('user_id', $user->id)
                ->where('cv_profil_id', $cvProfile->id)
                ->first();

            if (!$download) {
                return redirect()->route('cv.moncv')->with('error', 'Enregistrement de téléchargement non trouvé.');
            }

            // Marquer le paiement comme effectué avec les vraies données de FredaPay
            $download->update([
                'is_paid' => true,
                'payment_reference' => 'FPAY_' . $paymentId,
                'payment_status' => $status,
                'payment_method' => 'fredapay',
                'payment_amount' => 1000, // Montant en centimes (10€)
                'payment_date' => now(),
            ]);

            // Réinitialiser le compteur de téléchargements
            $download->update(['nombre_telechargements' => 0]);

            // Gestion de l'abonnement
            $abonnement = $user->abonnement;
            $now = now();
            if (!$abonnement || !$abonnement->estActif()) {
                // Créer ou renouveler pour 1 an
                $user->abonnement()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'date_debut' => $now,
                        'date_fin' => $now->copy()->addYear(),
                        'actif' => true,
                        'type' => 'annuel',
                    ]
                );
            } else {
                // Si déjà actif, prolonger d'un an à partir de la date_fin actuelle
                $abonnement->update([
                    'date_fin' => $abonnement->date_fin->copy()->addYear(),
                ]);
            }

            return redirect()->route('cv.moncv')->with('success', 'Paiement confirmé ! Vous pouvez maintenant télécharger votre CV.');
        }

        // Si le paiement n'est pas approuvé
        return redirect()->route('cv.moncv')->with('error', 'Le paiement n\'a pas été approuvé. Veuillez réessayer.');
    }



    public function confirmPayment(Request $request)
    {
        $user = Auth::user();
        $cvProfile = \App\Models\CvProfil::where('user_id', $user->id)->first();
        
        if (!$cvProfile) {
            return back()->with('error', 'Profil CV non trouvé.');
        }

        $download = CvDownload::where('user_id', $user->id)
            ->where('cv_profil_id', $cvProfile->id)
            ->first();

        if (!$download) {
            return back()->with('error', 'Enregistrement de téléchargement non trouvé.');
        }

        // Marquer le paiement comme effectué
        $download->update([
            'is_paid' => true,
            'payment_reference' => 'FPAY_' . time(),
            'payment_status' => 'succeeded',
            'payment_method' => 'fredapay',
            'payment_amount' => 1000, // Montant en centimes (10€)
            'payment_date' => now(),
        ]);

        // Réinitialiser le compteur de téléchargements
        $download->update(['nombre_telechargements' => 0]);

        // Gestion de l'abonnement
        $abonnement = $user->abonnement;
        $now = now();
        if (!$abonnement || !$abonnement->estActif()) {
            $user->abonnement()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'date_debut' => $now,
                    'date_fin' => $now->copy()->addYear(),
                    'actif' => true,
                    'type' => 'annuel',
                ]
            );
        } else {
            $abonnement->update([
                'date_fin' => $abonnement->date_fin->copy()->addYear(),
            ]);
        }

        return redirect()->route('cv.moncv')->with('success', 'Paiement confirmé ! Vous pouvez maintenant télécharger votre CV.');
    }

    public function telechargerCv(Request $request)
    {
        $user = Auth::user();
        $cvProfile = \App\Models\CvProfil::where('user_id', $user->id)->first();
        if (!$cvProfile) {
            return back()->with('error', 'Profil CV non trouvé.');
        }
        // Si abonnement actif : téléchargement illimité
        if ($user->estAbonneActif()) {
            $cvProfile = \App\Models\CvProfil::with([
                'etudiant', 'formations', 'experiences', 'competences', 'langues',
                'certifications', 'loisirs', 'projets', 'references'
            ])->where('user_id', $user->id)->first();
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('templates.template', compact('cvProfile'));
            $pdf->setPaper('A4', 'portrait');
            $filename = $cvProfile->username ? $cvProfile->username . '_CV.pdf' : 'Mon_CV.pdf';
            return $pdf->download($filename);
        }
        // Sinon, gestion du compteur de téléchargements (paiement à l'acte)
        $download = \App\Models\CvDownload::where('user_id', $user->id)
            ->where('cv_profil_id', $cvProfile->id)
            ->first();
        if (!$download || !$download->is_paid) {
            return back()->with('error', 'Vous devez payer pour télécharger votre CV.');
        }
        if ($download->nombre_telechargements >= 3) {
            $download->update(['is_paid' => false]);
            return back()->with('error', 'Vous avez atteint la limite de téléchargements. Veuillez payer à nouveau.');
        }
        $cvProfile = \App\Models\CvProfil::with([
            'etudiant', 'formations', 'experiences', 'competences', 'langues',
            'certifications', 'loisirs', 'projets', 'references'
        ])->where('user_id', $user->id)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('templates.template', compact('cvProfile'));
        $pdf->setPaper('A4', 'portrait');
        $filename = $cvProfile->username ? $cvProfile->username . '_CV.pdf' : 'Mon_CV.pdf';
        $download->increment('nombre_telechargements');
        $download->update(['dernier_telechargement' => now()]);
        return $pdf->download($filename);
    }

    public function abonnementHistory()
    {
        $user = Auth::user();
        $abonnements = $user->abonnement()->orderByDesc('date_debut')->get();
        return view('abonnement.historique', compact('abonnements'));
    }

    public function payerAbonnement(Request $request)
    {
        // Ici tu peux intégrer la logique d'appel API FedaPay ou autre prestataire
        // Pour l'exemple, on redirige simplement vers une page de paiement FedaPay
        return redirect('https://me.fedapay.com/Ol_Zva4W');
    }
}
