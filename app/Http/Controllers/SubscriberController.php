<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        // Valider l'email reçu
        $request->validate([
            'email' => 'required|email',
        ]);

        // Vérifier si l'email existe déjà
        if (Subscriber::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'Vous êtes déjà abonné(e). Merci pour votre fidélité.'
            ], 200);
        }

        // Enregistrer l'email
        Subscriber::create([
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Merci pour votre abonnement !'
        ], 200);
    }
}
