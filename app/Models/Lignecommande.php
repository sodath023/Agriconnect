<?php

namespace App\Models;

use App\Models\commande;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Lignecommande extends Model
{
    protected $fillable = [
        'commande_id',
        'product_id',
        'name',
        'unit_price',
        'quantity',
    ];

    public function commande()
    {
        return $this->belongsTo(commande::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
