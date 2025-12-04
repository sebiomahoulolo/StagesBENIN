<?php
// Script de test FedaPay clé LIVE

$api_key = 'clesk_live_Fu4JxXQPh7FEySUYTZ3dLvc3';
$url = 'https://api.fedapay.com/v1/transactions';

$data = [
    'transaction' => [
        'amount' => 500,
        'description' => 'Test API FedaPay',
        'callback_url' => 'https://google.com',
        'success_url' => 'https://google.com',
    ]
];

$options = [
    'http' => [
        'header'  => [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json',
        ],
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true,
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo "Erreur lors de la connexion à FedaPay.\n";
} else {
    echo "Réponse FedaPay :\n";
    echo $result;
} 