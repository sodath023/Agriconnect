<?php

namespace App\Models;

use App\Models\commande;
use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    //creation de la table paiement avec les champs commande_id, montant, methode, reference, statut
    protected $fillable = [
        'commande_id',
        'order_id',
        'montant',
        'methode',
        'phone_number',
        'operator',
        'reference',
        'statut',
        'payment_date',
        'failure_reason',
    ];

    // Casting des attributs
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function commande()
    {
        return $this->belongsTo(commande::class, 'commande_id');
    }
}
