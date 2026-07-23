<?php

namespace App\Services;

use App\Models\commande as Commande;
use App\Models\paiement as Paiement;

/**
 * Service de Simulation de Paiement Mobile Money
 * 
 * Ce service gère la simulation des paiements par mobile money
 * pour MTN Mobile Money et Moov Money.
 * 
 * Utilisation:
 * $paymentService = new MobileMoneySimulationService();
 * $payment = $paymentService->simulatePayment($order, 'MTN', '+237612345678');
 */
class MobileMoneySimulationService
{
    /**
     * Taux de succès de la simulation (en pourcentage)
     * Par défaut: 90% de chance de succès
     */
    protected $successRate = 90;

    /**
     * Liste des motifs d'échec possibles
     */
    protected $failureReasons = [
        'Solde insuffisant sur le compte mobile money.',
        'Mauvais code PIN entré.',
        'Délai d\'expiration du paiement dépassé.',
        'Opérateur temporairement indisponible.',
        'Compte utilisateur bloqué.',
        'Tentatives de paiement trop nombreuses.',
    ];

    /**
     * Initialiser le service
     */
    public function __construct()
    {
        // Vous pouvez charger le taux de succès depuis la configuration
        // $this->successRate = config('payment.simulation.success_rate', 90);
    }

    /**
     * Créer une nouvelle tentative de paiement
     * 
     * @param Commande $order La commande à payer
     * @param string $operator L'opérateur choisi (MTN, Moov)
     * @param string $phoneNumber Le numéro de téléphone
     * @return Paiement Le paiement créé
     */
    public function initializePayment(Commande $order, string $operator, string $phoneNumber): Paiement
    {
        // Supprimer les tentatives précédentes
        Paiement::where('commande_id', $order->id)
            ->where('statut', '!=', 'SUCCESS')
            ->delete();

        // Créer le nouveau paiement
        return Paiement::create([
            'commande_id' => $order->id,
            'montant' => $order->total,
            'methode' => $operator,
            'phone_number' => $phoneNumber,
            'operator' => $operator,
            'reference' => $this->generateReference(),
            'statut' => 'PENDING',
        ]);
    }

    /**
     * Simuler le résultat du paiement
     * 
     * @param Paiement $payment Le paiement à traiter
     * @return array ['success' => bool, 'message' => string, 'failure_reason' => string|null]
     */
    public function simulatePaymentResult(Paiement $payment): array
    {
        // Générer un résultat aléatoire
        $isSuccess = $this->shouldSucceed();

        if ($isSuccess) {
            // ✅ SUCCÈS
            $payment->update([
                'statut' => 'SUCCESS',
                'payment_date' => now(),
            ]);

            // Mettre à jour la commande
            $payment->commande->update([
                'status' => 'confirmed',
                'fedapay_transaction_id' => $payment->reference,
            ]);

            return [
                'success' => true,
                'status' => 'SUCCESS',
                'message' => 'Paiement réussi ! 🎉',
                'payment_id' => $payment->id,
                'order_id' => $payment->commande_id,
            ];
        } else {
            // ❌ ÉCHEC
            $failureReason = $this->getRandomFailureReason();

            $payment->update([
                'statut' => 'FAILED',
                'payment_date' => now(),
                'failure_reason' => $failureReason,
            ]);

            return [
                'success' => false,
                'status' => 'FAILED',
                'message' => 'Échec du paiement.',
                'failure_reason' => $failureReason,
                'payment_id' => $payment->id,
                'order_id' => $payment->commande_id,
            ];
        }
    }

    /**
     * Générer une référence de paiement unique
     * 
     * @return string
     */
    public function generateReference(): string
    {
        return 'SIM-' . time() . '-' . uniqid();
    }

    /**
     * Déterminer si le paiement devrait réussir
     * 
     * @return bool
     */
    protected function shouldSucceed(): bool
    {
        return rand(1, 100) <= $this->successRate;
    }

    /**
     * Obtenir un motif d'échec aléatoire
     * 
     * @return string
     */
    protected function getRandomFailureReason(): string
    {
        return $this->failureReasons[array_rand($this->failureReasons)];
    }

    /**
     * Définir le taux de succès
     * 
     * @param int $rate Le pourcentage de succès (0-100)
     * @return self
     */
    public function setSuccessRate(int $rate): self
    {
        if ($rate < 0 || $rate > 100) {
            throw new \InvalidArgumentException('Le taux de succès doit être entre 0 et 100.');
        }

        $this->successRate = $rate;
        return $this;
    }

    /**
     * Ajouter un motif d'échec personnalisé
     * 
     * @param string $reason
     * @return self
     */
    public function addFailureReason(string $reason): self
    {
        $this->failureReasons[] = $reason;
        return $this;
    }

    /**
     * Obtenir tous les motifs d'échec
     * 
     * @return array
     */
    public function getFailureReasons(): array
    {
        return $this->failureReasons;
    }

    /**
     * Valider un numéro de téléphone
     * 
     * @param string $phoneNumber
     * @return bool
     */
    public static function validatePhoneNumber(string $phoneNumber): bool
    {
        // Enlever les espaces et caractères spéciaux
        $phone = preg_replace('/\D/', '', $phoneNumber);

        // Vérifier que la longueur est entre 8 et 15 chiffres
        return strlen($phone) >= 8 && strlen($phone) <= 15;
    }

    /**
     * Valider un opérateur
     * 
     * @param string $operator
     * @return bool
     */
    public static function validateOperator(string $operator): bool
    {
        return in_array($operator, ['MTN', 'Moov', 'Airtel']);
    }

    /**
     * Obtenir les opérateurs disponibles
     * 
     * @return array
     */
    public static function getAvailableOperators(): array
    {
        return [
            'MTN' => [
                'name' => 'MTN Mobile Money',
                'icon' => '📱',
                'color' => 'warning',
            ],
            'Moov' => [
                'name' => 'Moov Money',
                'icon' => '💳',
                'color' => 'info',
            ],
        ];
    }

    /**
     * Retirer un paiement échoué et permettre une nouvelle tentative
     * 
     * @param Paiement $payment
     * @return void
     */
    public function allowRetry(Paiement $payment): void
    {
        if ($payment->statut === 'FAILED') {
            $payment->delete();
        }
    }

    /**
     * Obtenir l'historique de paiement d'une commande
     * 
     * @param Commande $order
     * @return array
     */
    public function getPaymentHistory(Commande $order): array
    {
        return Paiement::where('commande_id', $order->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }
}
