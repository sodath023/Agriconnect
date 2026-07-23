<?php

/**
 * ALTERNATIVE : Utiliser le Service MobileMoneySimulationService
 * 
 * Ce fichier montre comment utiliser le Service pour rendre le contrôleur
 * plus propre et réutilisable.
 * 
 * Si vous voulez utiliser cette approche, remplacez le contenu de
 * app/Http/Controllers/PaymentController.php par le code ci-dessous.
 */

namespace App\Http\Controllers;

use App\Models\commande as Commande;
use App\Models\paiement as Paiement;
use App\Services\MobileMoneySimulationService;
use Illuminate\Http\Request;

class PaymentControllerWithService extends Controller
{
    protected MobileMoneySimulationService $paymentService;

    /**
     * Injecter le service
     */
    public function __construct(MobileMoneySimulationService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Affiche la page de paiement pour une commande
     */
    public function show(Commande $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Cette commande a déjà été payée ou n\'est pas disponible.');
        }

        $order->load('lignecommandes.product');
        $existingPayment = Paiement::where('commande_id', $order->id)->first();
        $operators = MobileMoneySimulationService::getAvailableOperators();

        return view('payment.payment-page', compact('order', 'existingPayment', 'operators'));
    }

    /**
     * Initialise le processus de paiement simulé
     */
    public function initializePayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:commandes,id',
            'operator' => 'required|in:MTN,Moov',
            'phone_number' => 'required|regex:/^\+?[0-9]{8,15}$/',
        ], [
            'phone_number.regex' => 'Veuillez entrer un numéro de téléphone valide.',
        ]);

        $order = Commande::findOrFail($validated['order_id']);

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande ne peut pas être payée.'
            ], 400);
        }

        // Utiliser le service pour initialiser le paiement
        $payment = $this->paymentService->initializePayment(
            $order,
            $validated['operator'],
            $validated['phone_number']
        );

        return response()->json([
            'success' => true,
            'message' => 'Paiement en cours de traitement...',
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'operator' => $validated['operator'],
            'phone_number' => $validated['phone_number'],
        ]);
    }

    /**
     * Vérifie le statut du paiement
     */
    public function verifyPayment(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:paiements,id',
            'order_id' => 'required|exists:commandes,id',
        ]);

        $payment = Paiement::findOrFail($validated['payment_id']);
        $order = Commande::findOrFail($validated['order_id']);

        if ($payment->commande_id !== $order->id) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement invalide pour cette commande.'
            ], 400);
        }

        // Utiliser le service pour simuler le résultat
        $result = $this->paymentService->simulatePaymentResult($payment);

        if ($result['success']) {
            $result['redirect_url'] = route('payment.confirmation', ['order' => $order->id]);
        }

        return response()->json($result);
    }

    /**
     * Affiche la page de confirmation
     */
    public function confirmation(Commande $order)
    {
        if ($order->status !== 'confirmed') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Commande non trouvée ou non payée.');
        }

        $order->load('lignecommandes.product');
        $payment = $order->payment;

        return view('payment.confirmation', compact('order', 'payment'));
    }

    /**
     * Permettre une nouvelle tentative
     */
    public function retryPayment(Commande $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Cette commande n\'est pas disponible pour un nouveau paiement.');
        }

        // Supprimer les paiements échoués
        Paiement::where('commande_id', $order->id)
            ->where('statut', 'FAILED')
            ->delete();

        return redirect()->route('payment.show', ['order' => $order->id])
            ->with('info', 'Veuillez réessayer votre paiement.');
    }

    /**
     * Obtenir l'historique de paiement d'une commande (endpoint API)
     */
    public function paymentHistory(Commande $order)
    {
        $history = $this->paymentService->getPaymentHistory($order);
        
        return response()->json([
            'order_id' => $order->id,
            'history' => $history,
        ]);
    }

    /**
     * Changer le taux de succès (pour les tests)
     */
    public function setSuccessRate(Request $request)
    {
        $validated = $request->validate([
            'rate' => 'required|integer|min:0|max:100',
        ]);

        $this->paymentService->setSuccessRate($validated['rate']);

        return response()->json([
            'message' => 'Taux de succès défini à ' . $validated['rate'] . '%',
            'rate' => $validated['rate'],
        ]);
    }
}
