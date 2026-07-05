<?php

namespace App\Models;

use App\Models\Lignecommande;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    protected $fillable = [
        'reference',
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'city',
        'notes',
        'subtotal',
        'shipping_fee',
        'total',
        'status',
        'fedapay_transaction_id',
        'acheteur_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lignecommandes()
    {
        return $this->hasMany(Lignecommande::class, 'commande_id');
    }

    public function payment()
    {
        return $this->hasOne(paiement::class, 'commande_id');
    }
}
