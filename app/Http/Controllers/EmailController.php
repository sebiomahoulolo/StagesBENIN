<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function envoyerOffres(Request $request)
    {
        $offres = DB::table('annonces')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'nom_du_poste', 'type_de_poste', 'niveau_detude', 'lieu']);

        if ($offres->isEmpty()) {
            return back()->with('error', 'Aucune offre disponible à envoyer.');
        }

        $body = '<h2 style="text-align:center;color:#2c3e50;">Dernières offres </h2>';

        foreach ($offres as $offre) {
            $body .= '
                <div style="border:1px solid #ccc; border-radius:8px; padding:15px; margin-bottom:20px;">
                    <h3 style="color:#2980b9;">' . e($offre->nom_du_poste) . '</h3>
                    <p><strong>Type :</strong> ' . e($offre->type_de_poste) . '</p>
                    <p><strong>Niveau d\'étude :</strong> ' . e($offre->niveau_detude) . '</p>
                    <p><strong>Lieu :</strong> ' . e($offre->lieu) . '</p>
                    <a href="https://stagesbenin.com/etudiants/offres" 
                       style="display:inline-block; padding:10px 20px; background-color:#27ae60; color:#fff; text-decoration:none; border-radius:5px;">
                        Postuler
                    </a>
                </div>';
        }

        $emailsUsers = User::where('role', 'etudiant')->select('email', 'name')->get();
        $emailsSubscribers = DB::table('subscribers')->select('email')->get();

        if ($emailsUsers->isEmpty() && $emailsSubscribers->isEmpty()) {
            return back()->with('error', 'Aucun destinataire trouvé pour l\'envoi des offres.');
        }

        foreach ($emailsUsers as $user) {
            $prenom = explode(' ', $user->name)[0] ?? '';
            $this->envoyerEmail(
                $user->email,
                "Nouvelles offres d'emplois",
                $this->construireEmailHtml($prenom, $body)
            );
        }

        foreach ($emailsSubscribers as $subscriber) {
            $this->envoyerEmail(
                $subscriber->email,
                "Nouvelles offres d'emplois",
                $this->construireEmailHtml('', $body)
            );
        }

        return back()->with('success', 'Les 5 dernières offres ont été envoyées avec succès.');
    }

    public function envoyerMessage(Request $request)
    {
        $request->validate([
            'sujet' => 'required|string',
            'message' => 'required|string',
            'lien' => 'nullable|url',
            'fichier' => 'nullable|file|max:100240',
        ]);

        $contenu = nl2br(e($request->message));

        if ($request->filled('lien')) {
            $contenu .= '<br><br>Lien utile : <a href="' . e($request->lien) . '">' . e($request->lien) . '</a>';
        }

        $emailsUsers = User::where('role', 'etudiant')->select('email', 'name')->get();
        $emailsSubscribers = DB::table('subscribers')->select('email')->get();

        foreach ($emailsUsers as $user) {
            $prenom = explode(' ', $user->name)[0] ?? '';
            $this->envoyerEmail($user->email, $request->sujet, $this->construireEmailHtml($prenom, $contenu), $request);
        }

        foreach ($emailsSubscribers as $subscriber) {
            $this->envoyerEmail($subscriber->email, $request->sujet, $this->construireEmailHtml('', $contenu), $request);
        }

        return back()->with('success', 'Message envoyé à tous les étudiants.');
    }

    private function construireEmailHtml($prenom = '', $contenu)
    {
        $salutation = $prenom ? "<p>Bonjour <strong>" . e($prenom) . "</strong>,</p>" : "<p>Bonjour,</p>";

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>StagesBENIN</title>
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 30px; color: #333;">
            <div style="text-align:center; margin-bottom:30px;">
                <img src="https://stagesbenin.com/assets/images/stagebenin.png" alt="StagesBENIN" style="max-width:200px;">
                <p style="color:#2c3e50; font-size:16px;">
                    Votre passerelle d\'insertion professionnelle et de visibilité digitale par excellence !
                </p>
            </div>

            <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                ' . $salutation . '
                ' . $contenu . '
            </div>

            <div style="text-align:center; margin-top:30px; font-size:14px; color:#555;">
                <p>Contact : contact@stagesbenin.com</p>
                <p>
                    <a href="https://www.facebook.com/stagesbenin" style="margin: 0 10px;">Facebook</a>
                    <a href="https://www.linkedin.com/company/stagesbenin/" style="margin: 0 10px;">LinkedIn</a>
                    <a href="https://www.tiktok.com/@stagesbenin6" style="margin: 0 10px;">TikTok</a>
                    <a href="https://wa.me/22966693956" style="margin: 0 10px;">WhatsApp</a>
                </p>
                <hr>
                <p style="font-size:12px; color:#888;">
                    Vous recevez cet email parce que vous êtes inscrit(e) sur StagesBENIN.
                </p>
            </div>
        </body>
        </html>';
    }

    private function envoyerEmail($email, $sujet, $html, $request = null)
    {
        Mail::send([], [], function ($message) use ($email, $sujet, $html, $request) {
            $message->to($email)
                    ->subject($sujet)
                    ->html($html);

            if ($request && $request->hasFile('fichier')) {
                $message->attach($request->file('fichier')->getRealPath(), [
                    'as' => $request->file('fichier')->getClientOriginalName(),
                    'mime' => $request->file('fichier')->getMimeType(),
                ]);
            }
        });
    }
}
