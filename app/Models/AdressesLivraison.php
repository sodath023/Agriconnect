<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdressesLivraison extends Model
{
    protected $fillable = [
        'acheteur_id',
        'adresse',
        'ville',
        'téléphone',
        'type',
        'par_defaut',
    ];
}
