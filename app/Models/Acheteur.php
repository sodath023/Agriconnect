<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acheteur extends Model
{
    protected $fillable = [
        'user_id',
        'typeacheteur',
        'adresseLivraison',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adressesLivraison()
    {
        return $this->hasMany(AdressesLivraison::class);
    }
}
