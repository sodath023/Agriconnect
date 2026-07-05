<?php

namespace App\Services;

use App\Models\commande;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use FedaPay\Webhook;

class FedaPayService
{
    public function __construct()
    {
        FedaPay::setApiKey(config('fedapay.secret_key'));
        FedaPay::setEnvironment(config('fedapay.environment'));
    }

    /**
     * Crée une transaction FedaPay à partir des données de la commande.
     *
     * @param  array{description:string, amount:int, callback_url:string, customer:array}  $data
     */
    public function createTransaction(array $data): Transaction
    {
        return Transaction::create([
            'description'  => $data['description'],
            'amount'       => (int) $data['amount'], // le XOF n'a pas de décimales
            'currency'     => ['iso' => 'XOF'],
            'callback_url' => $data['callback_url'],
            'customer'     => $data['customer'],
        ]);
    }

    /**
     * Génère le lien de paiement sécurisé vers lequel rediriger le client.
     */
    public function generatePaymentUrl(Transaction $transaction): string
    {
        $token = $transaction->generateToken();

        return $token->url;
    }

    /**
     * Récupère l'état réel et à jour d'une transaction depuis l'API FedaPay
     * (à utiliser systématiquement plutôt que de se fier à l'URL de retour).
     */
    public function retrieveTransaction(string $transactionId): ?Transaction
    {
        try {
            return Transaction::retrieve($transactionId);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Vérifie la signature d'un webhook entrant et retourne l'évènement décodé.
     *
     * @throws \UnexpectedValueException|\FedaPay\Error\SignatureVerification
     */
    public function verifyWebhookSignature(string $payload, ?string $sigHeader)
    {
        return Webhook::constructEvent($payload, $sigHeader, config('fedapay.webhook_secret'));
    }

    /**
     * Traduit un statut FedaPay en statut de commande interne et persiste le changement.
     */
    public function syncOrderStatus(commande $order, string $fedaPayStatus): void
    {
        $map = [
            'approved' => 'paid',
            'declined' => 'failed',
            'canceled' => 'canceled',
            'pending'  => 'pending',
        ];

        $order->update(['status' => $map[$fedaPayStatus] ?? $order->status]);
    }
}