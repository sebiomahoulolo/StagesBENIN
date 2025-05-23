<?php

// app/Http/Controllers/Admin/CvController.php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Barryvdh\DomPDF\Facade\Pdf; // <== n'oublie pas ce "use"

class CvController extends Controller
{
    public function exportPdf($id)
    {
        $etudiant = Etudiant::with('cvProfile')->findOrFail($id);

        // On vérifie que le profil CV existe
        if (!$etudiant->cvProfile) {
            return back()->with('error', 'Ce candidat n\'a pas encore de CV.');
            //  dd("Aucun CV trouvé pour l'étudiant ID $id");
        }

        return Pdf::loadView('etudiants.cv.show-pdf', [
            'cvProfile' => $etudiant->cvProfile
        ])->download('CV_'.$etudiant->nom.'.pdf');
    }
}
