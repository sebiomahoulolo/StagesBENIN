use App\Models\Secteur;

public function create()
{
    $secteurs = Secteur::all();
    return view('auth.register-etudiant', compact('secteurs'));
} 