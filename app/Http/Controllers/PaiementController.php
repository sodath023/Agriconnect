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
}
