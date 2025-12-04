<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class PaiementController extends Controller
{
    protected $fedapayEnv = 'live'; // 'live' ou 'sandbox'

    public function initierPaiement($etudiant_id, $formule)
    {
        $etudiant = Etudiant::findOrFail($etudiant_id);

        $montant = match ($formule) {
            'premium' => 5000,
            'simple' => 500,
            default => null,
        };

        if (!$montant) {
            return back()->with('error', 'Formule invalide.');
        }

        // ✅ URL base selon l’environnement
        $baseUrl = 'https://stagesbenin.com';
        $callback_url = $baseUrl . '/fedapay-callback?etudiant_id=' . $etudiant_id;
        $success_url = $baseUrl . '/fedapay-callback?etudiant_id=' . $etudiant_id;

        // ✅ Payload complet
        $transactionData = [
            'description' => 'Paiement',
            'amount' => (int) $montant,
            'currency' => ['iso' => 'XOF'],
            'callback_url' => $callback_url,
            'return_url' => $success_url,
            'customer' => [
                'firstname' => $etudiant->prenom,
                'email' => $etudiant->email,
            ],
            'metadata' => [
                'etudiant_id' => $etudiant_id,
                'formule' => $formule,
                'montant' => $montant, // Ajout du montant dans le metadata
            ],
        ];

        Log::debug('Payload envoyé à FedaPay', $transactionData);

        try {
            $baseUri = $this->fedapayEnv === 'live'
                ? 'https://api.fedapay.com/v1/'
                : 'https://sandbox-api.fedapay.com/v1/';

            $apiKey = env('FEDAPAY_SECRET'); // Mets ta clé sandbox si test
            $client = new Client([
                'base_uri' => $baseUri,
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'timeout' => 30,
            ]);

            $response = $client->post('transactions', [
                'json' => $transactionData
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            Log::info('Réponse FedaPay', [
                'status' => $response->getStatusCode(),
                'body' => $body
            ]);

            $paymentUrl = $body['v1/transaction']['payment_url'] ?? null;
            if ($response->getStatusCode() === 200 && $paymentUrl) {
                return redirect($paymentUrl);
            } else {
                Log::error('FedaPay: Pas de payment_url dans la réponse', $body);
                return back()->with('error', 'Impossible de générer le lien de paiement FedaPay.');
            }

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $message = $e->hasResponse()
                ? $e->getResponse()->getBody()->getContents()
                : $e->getMessage();

            Log::error('Erreur Guzzle FedaPay : ' . $message);
            if ($e->hasResponse()) {
                Log::error('Réponse brute FedaPay : ' . $e->getResponse()->getBody());
            }
            return back()->with('error', 'Erreur de communication avec FedaPay.');
        }
    }

    public function showForm($etudiant_id, $formule)
    {
        if (!session('just_registered')) {
            // Permettre l'accès même sans just_registered, mais afficher la nouvelle vue recapitulatif
            // return redirect()->route('home')->with('error', 'Accès non autorisé.');
        } else {
            session()->forget('just_registered');
        }
        $etudiant = \App\Models\Etudiant::findOrFail($etudiant_id);
        $montant = match ($formule) {
            'premium' => 5000,
            'simple' => 500,
            default => 0,
        };
        return view('paiement.recapitulatif', compact('etudiant', 'formule', 'montant'));
    }

    public function choix($etudiantId)
    {
        $etudiant = \App\Models\Etudiant::findOrFail($etudiantId);
        return view('paiement.choix', compact('etudiant'));
    }

    public function callbackFedaPay(Request $request)
    {
        $input = $request->all();
        Log::info('FedaPay CALLBACK', $input);

        $transaction_id = $input['id'] ?? null;
        $status = $input['status'] ?? null;
        $metadata = $input['metadata'] ?? [];
        if (is_string($metadata)) {
            $metadata = json_decode($metadata, true) ?: [];
        }
        $etudiant_id = $metadata['etudiant_id'] ?? $request->get('etudiant_id');
        $formule = $metadata['formule'] ?? null;
        $montant = $input['amount'] ?? $metadata['montant'] ?? null;

        // Si metadata vide, récupère la transaction via l'API FedaPay
        if ((!$formule || !$montant) && $transaction_id) {
            try {
                $client = new \GuzzleHttp\Client([
                    'base_uri' => 'https://api.fedapay.com/v1/',
                    'headers' => [
                        'Authorization' => env('FEDAPAY_SECRET');, // Mets ta clé live ici
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'timeout' => 30,
                ]);
                $response = $client->get('transactions/' . $transaction_id);
                $body = json_decode($response->getBody()->getContents(), true);
                $transaction = $body['v1/transaction'] ?? [];
                // Correction : lire custom_metadata en priorité
                $api_metadata = $transaction['custom_metadata'] ?? $transaction['metadata'] ?? [];
                if (is_string($api_metadata)) {
                    $api_metadata = json_decode($api_metadata, true) ?: [];
                }
                $formule = $formule ?? $api_metadata['formule'] ?? null;
                $montant = $montant ?? $api_metadata['montant'] ?? $transaction['amount'] ?? null;
                $etudiant_id = $etudiant_id ?? $api_metadata['etudiant_id'] ?? null;
                // Si toujours rien, va chercher dans pending_payments
                if ((!$formule || !$montant) && $transaction_id) {
                    $pending = \App\Models\PendingPayment::where('transaction_id', $transaction_id)->first();
                    if ($pending) {
                        $formule = $formule ?? $pending->formule;
                        $montant = $montant ?? $pending->montant;
                        $etudiant_id = $etudiant_id ?? $pending->etudiant_id;
                    }
                }
                Log::info('FedaPay API transaction récupérée', compact('transaction_id', 'formule', 'montant', 'etudiant_id'));
            } catch (\Exception $e) {
                Log::error('Erreur récupération transaction FedaPay API', ['exception' => $e->getMessage(), 'transaction_id' => $transaction_id]);
            }
        }

        if ($transaction_id && $etudiant_id && $montant !== null) {
            Paiement::updateOrCreate(
                [
                    'transaction_id' => $transaction_id,
                    'etudiant_id' => $etudiant_id,
                    'formule' => $formule ?? '',
                ],
                [
                    'montant' => $montant,
                    'status' => $status,
                    'metadata' => json_encode($input),
                ]
            );
            Log::info('Paiement enregistré', compact('transaction_id', 'etudiant_id', 'formule', 'status', 'montant'));
        } else {
            Log::warning('Callback FedaPay incomplet ou montant manquant', [
                'input' => $input,
                'metadata' => $metadata,
                'transaction_id' => $transaction_id,
                'etudiant_id' => $etudiant_id,
                'formule' => $formule,
                'montant' => $montant,
            ]);
        }

        return match ($status) {
            'approved' => redirect('/login')->with('success', 'Paiement validé.'),
            'pending' => redirect('/login')->with('warning', 'Paiement en attente.'),
            default => redirect('/login')->with('error', 'Paiement non validé.'),
        };
    }

    /**
     * Affiche la page récapitulative avant paiement (paiement.form)
     */
    public function recapitulatif(Request $request)
    {
        $etudiant = $request->input('etudiant');
        $formule = $request->input('formule');
        // Ici tu peux ajouter des validations ou traitements si besoin
        return redirect()->route('paiement.form', ['etudiant' => $etudiant, 'formule' => $formule]);
    }

    /**
     * Lance le paiement FedaPay après validation du récapitulatif
     */
    public function feadapay(Request $request)
    {
        $request->validate([
            'etudiant' => 'required|exists:etudiants,id',
            'formule' => 'required|in:simple,premium',
        ]);
        return $this->initierPaiement($request->etudiant, $request->formule);
    }
}
