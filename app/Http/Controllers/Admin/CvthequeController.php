<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialite;
use App\Models\Tier;
use Illuminate\Http\Request;

class CvthequeController extends Controller
{
    public function index()
    {
        $specialites = Specialite::withCount(['etudiants' => function($query) {
            $query->whereHas('tier', function($q) {
                $q->where('payment_status', 'paid');
            });
        }])->get();

        return view('admin.cvtheque.cvtheque', compact('specialites'));
    }

    public function specialite($id)
    {
        $specialite = Specialite::findOrFail($id);
        $tiers = Tier::whereHas('etudiant', function($query) use ($id) {
            $query->where('specialite_id', $id);
        })->where('payment_status', 'paid')->get();

        return view('admin.cvtheque.specialite', compact('specialite', 'tiers'));
    }

    public function etudiant($id)
    {
        $tier = Tier::where('etudiant_id', $id)
            ->where('payment_status', 'paid')
            ->firstOrFail();

        return view('admin.cvtheque.etudiant', compact('tier'));
    }
} 