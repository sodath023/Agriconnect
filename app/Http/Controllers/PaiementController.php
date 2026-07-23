<?php

namespace App\Http\Controllers;

use App\Models\commande as Commande;
use App\Models\paiement as Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    //fonction pour effectuer un paiement pour une commande
    public function pay(Request $request)
    {
        $order = Commande::findOrFail(
            $request->order_id
        );

        $payment = Paiement::create([

            'order_id'=>$order->id,

            'montant'=>$order->montant_total,

            'methode'=>$request->methode,

            'reference'=>uniqid('PAY-'),

            'statut'=>'SUCCESS'
        ]);

        return response()->json([
            'message'=>'Paiement effectué',
            'payment'=>$payment
        ]);
    }
/**
 * Contrôleur de gestion des paiements
 * Gère la simulation des paiements par mobile money (MTN MoMo, Moov Money)
 */

{
    /**
     * Affiche la page de paiement pour une commande
     *
     * @param Commande $order La commande pour laquelle on effectue le paiement
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Commande $order)
    {
        // Vérifier que la commande existe et appartient à l'utilisateur connecté
        if ($order->status !== 'pending') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Cette commande a déjà été payée ou n\'est pas disponible.');
        }

        try {
            // Charger les articles de la commande
            $order->load([
                'lignecommandes',
                'lignecommandes.product'
            ]);

            // Vérifier s'il existe déjà un paiement pour cette commande
            $existingPayment = Paiement::where('commande_id', $order->id)->first();

            return view('payment.payment-page', [
                'order' => $order,
                'payment' => $existingPayment,
                'operators' => [
                    'MTN' => ['name' => 'MTN Mobile Money', 'color' => 'warning', 'icon' => '📱'],
                    'Moov' => ['name' => 'Moov Money', 'color' => 'info', 'icon' => '💳'],
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors du chargement de la page de paiement', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('acheteur.commandes')
                ->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    /**
     * Initie le processus de paiement simulé
     * Crée un enregistrement de paiement avec le statut PENDING
     
     * @param Request $request Les données du formulaire de paiement
     * @return \Illuminate\Http\JsonResponse
     */
    public function initializePayment(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'order_id' => 'required|exists:commandes,id',
            'operator' => 'required|in:MTN,Moov',
            'phone_number' => 'required|regex:/^\+?[0-9]{8,15}$/',
        ], [
            'phone_number.regex' => 'Veuillez entrer un numéro de téléphone valide.',
        ]);

        // Récupérer la commande
        $order = Commande::findOrFail($validated['order_id']);

        // Vérifier que la commande est en attente de paiement
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande ne peut pas être payée.'
            ], 400);
        }

        // Supprimer les tentatives de paiement précédentes
        Paiement::where('commande_id', $order->id)->delete();

        // Créer un nouveau paiement avec le statut PENDING
        $payment = Paiement::create([
            'commande_id' => $order->id,
            'montant' => $order->total,
            'methode' => $validated['operator'],
            'phone_number' => $validated['phone_number'],
            'operator' => $validated['operator'],
            'reference' => 'SIM-' . time() . '-' . uniqid(),
            'statut' => 'PENDING',
        ]);

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
     * Simule la vérification du statut de paiement
     * Valide le paiement après un délai simulé
     * Génère aléatoirement succès ou échec (90% succès, 10% échec)
     * @param Request $request Doit contenir payment_id et order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyPayment(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'payment_id' => 'required|exists:paiements,id',
            'order_id' => 'required|exists:commandes,id',
        ]);

        // Récupérer le paiement et la commande
        $payment = Paiement::findOrFail($validated['payment_id']);
        $order = Commande::findOrFail($validated['order_id']);

        // Vérifier que le paiement appartient à la commande
        if ($payment->commande_id !== $order->id) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement invalide pour cette commande.'
            ], 400);
        }

        // ===== SIMULATION DU PAIEMENT =====
        // Générer un résultat aléatoire : 90% succès, 10% échec
        $isSuccess = rand(1, 100) <= 90;

        if ($isSuccess) {
            // ✅ SUCCÈS : Mettre à jour le paiement et la commande
            $payment->update([
                'statut' => 'SUCCESS',
                'payment_date' => now(),
            ]);

            // Mettre à jour le statut de la commande
            $order->update([
                'status' => 'confirmed', // ou 'paid' selon votre logique
                'fedapay_transaction_id' => $payment->reference,
            ]);

            return response()->json([
                'success' => true,
                'status' => 'SUCCESS',
                'message' => 'Paiement réussi ! 🎉',
                'order_id' => $order->id,
                'redirect_url' => route('payment.confirmation', ['order' => $order->id]),
            ]);
        } else {
            // ❌ ÉCHEC : Mettre à jour le paiement avec un motif d'échec
            $failureReasons = [
                'Solde insuffisant sur le compte mobile money.',
                'Mauvais code PIN entré.',
                'Délai d\'expiration du paiement dépassé.',
                'Opérateur temporairement indisponible.',
            ];

            $payment->update([
                'statut' => 'FAILED',
                'payment_date' => now(),
                'failure_reason' => $failureReasons[array_rand($failureReasons)],
            ]);

            return response()->json([
                'success' => false,
                'status' => 'FAILED',
                'message' => 'Échec du paiement.',
                'failure_reason' => $payment->failure_reason,
                'order_id' => $order->id,
            ]);
        }
    }

    /**
     * Affiche la page de confirmation après un paiement réussi
     * Vérifie que la commande a été payée avant d'afficher la page
     * @param Commande $order La commande payée
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function confirmation(Commande $order)
    {
        // Vérifier que la commande a été payée
        if ($order->status !== 'confirmed') {
            return redirect()->route('acheteur.commandes')
                ->with('error', 'Commande non trouvée ou non payée.');
        }

        try {
            // Charger le paiement et les articles
            $order->load([
                'lignecommandes',
                'lignecommandes.product'
            ]);
            
            $payment = $order->payment;

            // Vérifier que le paiement existe
            if (!$payment) {
                return redirect()->route('acheteur.commandes')
                    ->with('error', 'Paiement non trouvé pour cette commande.');
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
