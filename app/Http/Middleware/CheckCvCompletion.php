<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\CvProfile;

class CheckCvCompletion
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->isEtudiant()) {
            $cvProfile = $user->etudiant?->cvProfile;

            if (!$cvProfile) {
                // Rediriger vers la création du CV
                return redirect()->route('etudiants.cv.create')
                    ->with('warning', 'Vous devez créer un profil CV avant de continuer.');
            }
        }

        return $next($request);
    }
}
