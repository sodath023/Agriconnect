<?php

namespace App\Models;

use App\Models\commande;
use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    //creation de la table paiement avec les champs order_id, montant, methode, reference, statut
    protected $fillable = [
        'order_id',
        'montant',
        'methode',
        'reference',
        'statut',
    ];

    public function commande()
    {
        return $this->belongsTo(commande::class);
    }
}
