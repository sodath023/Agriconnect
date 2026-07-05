<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandeAcheteurController extends Controller
{
    //fonction pour afficher la page de confirmation de commande
    public function index()
{
    return Order::with([
        'items.product',
        'payment'
    ])
    ->where('user_id', auth()->id())
    ->latest()
    ->get();
}

}
