<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\commande as Commande;
use App\Services\FedaPayService;
use App\Models\Lignecommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommandeController extends Controller
{

    public function __construct(private FedaPayService $fedaPay)
    {
    }

    // fonction pour créer une commande à partir du panier
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $cart = Panier::with(
                'items.product'
            )
                ->where('user_id', auth()->id())
                ->first();

            $total = 0;

            foreach ($cart->items as $item) {
                $total +=
                    $item->product->prix
                    * $item->quantite;
            }

            $validated = $request->validate([
                'firstname' => ['required', 'string', 'max:100'],
                'lastname'  => ['required', 'string', 'max:100'],
                'email'     => ['required', 'email', 'max:150'],
                'phone'     => ['required', 'string', 'max:20'],
                'address'   => ['required', 'string', 'max:255'],
                'city'      => ['required', 'string', 'max:100'],
                'notes'     => ['nullable', 'string', 'max:500'],
            ]);

            $order = Commande::create([

                'reference'    => 'CMD-' . strtoupper(uniqid()),
                'firstname'    => $validated['firstname'],
                'lastname'     => $validated['lastname'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
                'address'      => $validated['address'],
                'city'         => $validated['city'],
                'notes'        => $validated['notes'] ?? null,
                'subtotal'     => $total,
                'shipping_fee' => 1500,
                'total'        => $total+1500,
                'status'       => 'pending',

                'montant_total' => $total,

                'adresse_livraison'
                => $request->adresse_livraison,

                'mode_livraison'
                => $request->mode_livraison,

                'mode_paiement'
                => $request->mode_paiement
            ]);

            foreach ($cart->items as $item) {
                Lignecommande::create([

                    'commande_id' => $order->id,

                    'product_id' => $item->product_id,

                    'name'        => $item->product->nom,

                    'quantity' => $item->quantite,

                    'unit_price'
                    => $item->product->prix,

                    'montant'
                    => $item->product->prix
                        * $item->quantite
                ]);
            }

            $cart->items()->delete();

            DB::commit();

            //paiement FEDAPAY
            $transaction = $this->fedaPay->createTransaction([
                'description'  => "Paiement commande {$order->reference}",
                'amount'       => $total,
                'callback_url' => route('checkout.callback'),
                'customer'     => [
                    'firstname' => $validated['firstname'],
                    'lastname'  => $validated['lastname'],
                    'email'     => $validated['email'],
                    'phone'     => $validated['phone'],
                ],
            ]);
 
            $paymentUrl = $this->fedaPay->generatePaymentUrl($transaction);
 
            $order->update(['fedapay_transaction_id' => $transaction->id]);
 
            return redirect()->away($paymentUrl);
        } catch (\Throwable $e) {
            Log::error('Erreur création transaction FedaPay', [
                'order' => $order->id,
                'error' => $e->getMessage(),
            ]);
 
            $order->update(['status' => 'failed']);
 
            return back()->withInput()->with(
                'error',
                "Une erreur est survenue lors de l'initialisation du paiement. Merci de réessayer."
            );
        }
    }
}
