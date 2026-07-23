<?php

namespace App\Http\Controllers;

use App\Models\commande as Commande;
use App\Models\paiement as Paiement;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
{
    public function show(Commande $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Cette commande a déjà été payée ou n\'est pas disponible.');
        }

        try {
            $order->load(['lignecommandes', 'lignecommandes.product']);
            return view('payment.two-step-payment', ['order' => $order]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors du chargement de la page de paiement', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    public function initializePayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:commandes,id',
            'operator' => 'required|in:MTN,Moov',
            'phone_number' => 'required|regex:/^\+?[0-9]{8,15}$/',
        ], [
            'phone_number.regex' => 'Veuillez entrer un numéro de téléphone valide.',
        ]);

        try {
            $order = Commande::findOrFail($validated['order_id']);

            if ($order->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette commande ne peut pas être payée.'
                ], 400);
            }

            Paiement::where('commande_id', $order->id)
                ->where('statut', 'FAILED')
                ->delete();

            $payment = Paiement::create([
                'commande_id' => $order->id,
                'montant' => $order->total,
                'methode' => $validated['operator'],
                'phone_number' => $validated['phone_number'],
                'operator' => $validated['operator'],
                'reference' => $this->generatePaymentReference(),
                'statut' => 'PENDING',
            ]);

            \Log::info('Paiement initié', [
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'operator' => $validated['operator'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Paiement en attente de confirmation...',
                'payment_id' => $payment->id,
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'initialisation du paiement', [
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement.'
            ], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:paiements,id',
            'order_id' => 'required|exists:commandes,id',
        ]);

        try {
            $payment = Paiement::findOrFail($validated['payment_id']);
            $order = Commande::findOrFail($validated['order_id']);

            if ($payment->commande_id !== $order->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paiement invalide pour cette commande.'
                ], 400);
            }

            $isSuccess = rand(1, 100) <= 90;

            if ($isSuccess) {
                $payment->update([
                    'statut' => 'SUCCESS',
                    'payment_date' => now(),
                ]);

                $order->update([
                    'status' => 'confirmed',
                    'fedapay_transaction_id' => $payment->reference,
                ]);

                \Log::info('Paiement réussi', [
                    'order_id' => $order->id,
                    'payment_id' => $payment->id,
                    'amount' => $payment->montant,
                ]);

                return response()->json([
                    'success' => true,
                    'status' => 'SUCCESS',
                    'message' => 'Paiement réussi ! 🎉',
                    'order_id' => $order->id,
                    'redirect_url' => route('payment.confirmation', ['order' => $order->id]),
                ]);
            } else {
                $failureReasons = [
                    'Solde insuffisant sur le compte mobile money.',
                    'Mauvais code PIN entré.',
                    'Délai d\'expiration du paiement dépassé.',
                    'Opérateur temporairement indisponible.',
                    'Compte utilisateur bloqué.',
                ];

                $failureReason = $failureReasons[array_rand($failureReasons)];

                $payment->update([
                    'statut' => 'FAILED',
                    'payment_date' => now(),
                    'failure_reason' => $failureReason,
                ]);

                \Log::warning('Paiement échoué', [
                    'order_id' => $order->id,
                    'payment_id' => $payment->id,
                    'reason' => $failureReason,
                ]);

                return response()->json([
                    'success' => false,
                    'status' => 'FAILED',
                    'message' => 'Échec du paiement.',
                    'failure_reason' => $failureReason,
                    'order_id' => $order->id,
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la vérification du paiement', [
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement.'
            ], 500);
        }
    }

    public function confirmation(Commande $order)
    {
        if ($order->status !== 'confirmed') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Commande non trouvée ou non payée.');
        }

        try {
            $order->load(['lignecommandes', 'lignecommandes.product']);
            $payment = $order->payment;

            if (!$payment) {
                return redirect()->route('acheteur.commandes')
                    ->with('error', 'Paiement non trouvé.');
            }

            return view('payment.confirmation', [
                'order' => $order,
                'payment' => $payment,
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors du chargement de la confirmation', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Une erreur est survenue.');
        }
    }

    public function retryPayment(Commande $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Cette commande n\'est pas disponible.');
        }

        Paiement::where('commande_id', $order->id)
            ->where('statut', 'FAILED')
            ->delete();

        return redirect()->route('payment.show', ['order' => $order->id])
            ->with('info', 'Veuillez réessayer votre paiement.');
    }

    private function generatePaymentReference(): string
    {
        return 'SIM-' . time() . '-' . strtoupper(substr(md5(rand()), 0, 8));
    }
}

        return redirect()->route('payment.show', ['order' => $order->id])
            ->with('info', 'Veuillez réessayer votre paiement.');
    }

    /**
     * Génère une référence de paiement unique
     * 
     * @return string
     */
    private function generatePaymentReference(): string
    {
        return 'SIM-' . time() . '-' . strtoupper(substr(md5(rand()), 0, 8)
        }
    }

    /**
     * Retenta le paiement après un échec
     * Redirige vers la page de paiement
     * 
     * @param Commande $order La commande
     * @return \Illuminate\View\View
     */
    public function retryPayment(Commande $order)
    {
        // Vérifier que la commande est en attente de paiement
        if ($order->status !== 'pending') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Cette commande n\'est pas disponible pour un nouveau paiement.');
        }

        // Supprimer les tentatives de paiement précédentes échouées
        Paiement::where('commande_id', $order->id)
            ->where('statut', 'FAILED')
            ->delete();

        return redirect()->route('payment.show', ['order' => $order->id])
            ->with('info', 'Veuillez réessayer votre paiement.');
    }
}
