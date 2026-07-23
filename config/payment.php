<?php

/**
 * Configuration des Paiements - AgriConnect
 * 
 * Ce fichier configure le comportement des simulations de paiement
 * et les paramètres de paiement en général.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Mode de Paiement
    |--------------------------------------------------------------------------
    |
    | Sélectionnez le mode de paiement :
    | - 'simulation' : Simulation du paiement mobile money
    | - 'fedapay'    : Intégration avec FedaPay (API réelle)
    | - 'stripe'     : Intégration avec Stripe (API réelle)
    |
    */
    'mode' => env('PAYMENT_MODE', 'simulation'),

    /*
    |--------------------------------------------------------------------------
    | Configuration de la Simulation
    |--------------------------------------------------------------------------
    */
    'simulation' => [
        // Taux de succès (en pourcentage)
        'success_rate' => env('PAYMENT_SIMULATION_SUCCESS_RATE', 90),

        // Délai de traitement en secondes (côté front-end)
        'processing_delay' => 3,

        // Opérateurs disponibles
        'operators' => ['MTN', 'Moov'],

        // Motifs d'échec personnalisés
        'failure_reasons' => [
            'Solde insuffisant sur le compte mobile money.',
            'Mauvais code PIN entré.',
            'Délai d\'expiration du paiement dépassé.',
            'Opérateur temporairement indisponible.',
            'Compte utilisateur bloqué.',
            'Tentatives de paiement trop nombreuses.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration FedaPay (si utilisé)
    |--------------------------------------------------------------------------
    */
    'fedapay' => [
        'api_key' => env('FEDAPAY_API_KEY'),
        'mode' => env('FEDAPAY_MODE', 'test'), // 'test' ou 'live'
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration Stripe (si utilisé)
    |--------------------------------------------------------------------------
    */
    'stripe' => [
        'public_key' => env('STRIPE_PUBLIC_KEY'),
        'secret_key' => env('STRIPE_SECRET_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Paramètres de Paiement Généraux
    |--------------------------------------------------------------------------
    */
    'general' => [
        // Currency
        'currency' => 'XOF', // Franc CFA

        // Montant minimum acceptable
        'min_amount' => 1000,

        // Montant maximum acceptable
        'max_amount' => 10000000,

        // Activer les logs de paiement
        'log_payments' => true,

        // Délai de validation du paiement (en secondes)
        'verification_delay' => 3,
    ],

];
