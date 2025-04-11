<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



use Illuminate\Http\Request;
use Carbon\Carbon;



class Entretien extends Model
{
    use HasFactory;

    protected $fillable = ['etudiant_id', 'date', 'lieu', 'commentaires', 'user_id'];
  

    
    // Définir la relation avec l'utilisateur (celui qui programme l'entretien)
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function index()
    {
        // Récupère les entretiens de la semaine actuelle
        $debutSemaine = Carbon::now()->startOfWeek();
        $finSemaine = Carbon::now()->endOfWeek();

        $entretiens = Entretien::with('entreprise')
            ->whereBetween('date', [$debutSemaine, $finSemaine])
            ->orderBy('date', 'asc')
            ->get();

        return view('etudiant.dashboard', compact('entretiens'));
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }
    

    // Définir la relation avec l'entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }





}
