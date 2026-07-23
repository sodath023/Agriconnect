<?php

/**
 * EXEMPLE : Modification du CommandeController
 * 
 * Ce fichier montre comment modifier votre CommandeController actuel
 * pour rediriger vers la page de paiement après création de la commande.
 */

// ============================================================================
// AVANT (Ancien flux avec FedaPay)
// ============================================================================

class CommandeControllerOld extends Controller
{
    public function store(Request $request)
    {
        // ... validation et création de la commande ...
        
        $order = Commande::create([
            'reference' => 'CMD-' . time(),
            'firstname' => $request->firstname,
            // ... autres champs ...
        ]);

        // ❌ ANCIEN : Redirection vers FedaPay
        return redirect('https://checkout.fedapay.com/pay/' . $order->id);
    }
}

// ============================================================================
// APRÈS (Nouveau flux avec Simulation Mobile Money)
// ============================================================================

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Récupérer les articles du panier
        $panier = session('panier', []);

        if (empty($panier)) {
            return redirect()->route('panier')
                ->with('error', 'Votre panier est vide.');
        }

        // Calculer les montants
        $subtotal = collect($panier)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $shipping_fee = 1000; // Frais de livraison (à adapter)
        $total = $subtotal + $shipping_fee;

        // Créer la commande
        $order = Commande::create([
            'reference' => 'CMD-' . time() . '-' . strtoupper(substr(md5(rand()), 0, 6)),
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'notes' => $validated['notes'] ?? null,
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping_fee,
            'total' => $total,
            'status' => 'pending',
            'acheteur_id' => auth()->user()->acheteur_id ?? null,
        ]);

        // Créer les lignes de commande
        foreach ($panier as $productId => $item) {
            \App\Models\Lignecommande::create([
                'commande_id' => $order->id,
                'product_id' => $productId,
                'name' => $item['name'],
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // ✅ NOUVEAU : Redirection vers la page de paiement simulée
        return redirect()->route('payment.show', ['order' => $order->id])
            ->with('success', 'Commande créée avec succès. Veuillez procéder au paiement.');
    }
}

// ============================================================================
// VERSION ALTERNATIVE (avec gestion d'erreurs améliorée)
// ============================================================================

class CommandeControllerAdvanced extends Controller
{
    public function store(Request $request)
    {
        try {
            // Valider les données
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|regex:/^\+?[0-9]{8,15}$/',
                'address' => 'required|string|max:500',
                'city' => 'required|string|max:255',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Récupérer et valider le panier
            $panier = session('panier', []);

            if (empty($panier)) {
                return redirect()->route('panier')
                    ->with('error', 'Votre panier est vide.');
            }

            // Vérifier la disponibilité des produits
            foreach ($panier as $productId => $item) {
                $product = \App\Models\Product::find($productId);
                
                if (!$product) {
                    return redirect()->route('panier')
                        ->with('error', 'Un produit de votre panier n\'existe plus.');
                }

                if ($product->stock < $item['quantity']) {
                    return redirect()->route('panier')
                        ->with('error', 'Stock insuffisant pour ' . $product->name);
                }
            }

            // Calculer les montants
            $subtotal = collect($panier)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            // Calculer les frais de livraison
            $shipping_fee = $this->calculateShippingFee($validated['city']);

            $total = $subtotal + $shipping_fee;

            // Valider les montants
            if ($total < config('payment.general.min_amount', 1000)) {
                return redirect()->route('panier')
                    ->with('error', 'Le montant minimum n\'a pas été atteint.');
            }

            if ($total > config('payment.general.max_amount', 10000000)) {
                return redirect()->route('panier')
                    ->with('error', 'Le montant dépasse la limite autorisée.');
            }

            // Créer la commande
            $order = Commande::create([
                'reference' => $this->generateOrderReference(),
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'notes' => $validated['notes'] ?? null,
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping_fee,
                'total' => $total,
                'status' => 'pending',
                'acheteur_id' => auth()->user()->acheteur_id ?? null,
            ]);

            // Créer les lignes de commande
            foreach ($panier as $productId => $item) {
                $product = \App\Models\Product::find($productId);

                \App\Models\Lignecommande::create([
                    'commande_id' => $order->id,
                    'product_id' => $productId,
                    'name' => $product->name,
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);

                // Décrémenter le stock (optionnel)
                // $product->decrement('stock', $item['quantity']);
            }

            // Vider le panier
            session()->forget('panier');

            // Log de la commande créée
            \Log::info('Commande créée', [
                'order_id' => $order->id,
                'reference' => $order->reference,
                'total' => $order->total,
                'user_id' => auth()->id(),
            ]);

            // ✅ Redirection vers paiement
            return redirect()->route('payment.show', ['order' => $order->id])
                ->with('success', 'Commande créée avec succès. Veuillez procéder au paiement.');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de commande', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('panier')
                ->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    /**
     * Générer une référence de commande unique
     */
    protected function generateOrderReference(): string
    {
        do {
            $reference = 'CMD-' . time() . '-' . strtoupper(substr(md5(rand()), 0, 6));
        } while (Commande::where('reference', $reference)->exists());

        return $reference;
    }

    /**
     * Calculer les frais de livraison selon la ville
     */
    protected function calculateShippingFee(string $city): int
    {
        $fees = [
            'yaoundé' => 1000,
            'douala' => 1500,
            'buea' => 2000,
            'bamenda' => 2000,
        ];

        return $fees[strtolower($city)] ?? 2000; // Frais par défaut
    }
}

// ============================================================================
// POINTS IMPORTANTS
// ============================================================================

/*
1. VARIABLES SESSION
   - session('panier') retourne les articles du panier
   - session()->forget('panier') vide le panier après création
   - Adapter selon votre structure

2. MODÈLE LIGNECOMMANDE
   - Créer une ligne pour chaque produit du panier
   - Utiliser les champs: commande_id, product_id, name, unit_price, quantity

3. REDIRECTION VERS PAIEMENT
   - Route: 'payment.show'
   - Paramètre: ['order' => $order->id]
   - Message: 'Veuillez procéder au paiement'

4. ERREURS À GÉRER
   - Panier vide
   - Produit supprimé
   - Stock insuffisant
   - Montant minimum/maximum
   - Exceptions générales

5. LOGS
   - Enregistrer toutes les commandes créées
   - Enregistrer les erreurs
   - Utile pour le débogage et l'audit
*/
