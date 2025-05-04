<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use FedaPay\Webhook;
use FedaPay\Error\SignatureVerification;
use App\Models\Tier;

class FedaPayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $endpoint_secret = 'wh_live_L6g3J3Tm3DfFtc6sNp-9gp24';
        $payload = $request->getContent();
        $sig_header = $request->header('X-FEDAPAY-SIGNATURE');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            return response('Payload invalide', 400);
        } catch (SignatureVerification $e) {
            return response('Signature invalide', 400);
        }

        $transaction = $event->data;

        if (!isset($transaction->id)) {
            return response('ID de transaction manquant', 400);
        }

        $transactionId = $transaction->id;
        $status = '';

        switch ($event->name) {
            case 'transaction.created':
                $status = 'créée';
                break;
            case 'transaction.approved':
                $status = 'approuvée';
                break;
            case 'transaction.canceled':
                $status = 'annulée';
                break;
            default:
                return response('Événement non pris en charge', 400);
        }

        // Mise à jour dans la table tiers selon fedapay_transaction_id
        $tier = Tier::where('fedapay_transaction_id', $transactionId)->first();

        if ($tier) {
            $tier->payment_status = $status;
            if ($status === 'approuvée') {
                $tier->payment_date = now();
            }
            $tier->save();
        }
        Log::info('Webhook reçu', ['payload' => $request->all()]);  
        return response('Mise à jour effectuée', 200);
    }
}
