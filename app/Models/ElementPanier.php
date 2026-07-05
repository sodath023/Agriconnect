<?php

namespace App\Models;

use App\Models\Panier;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ElementPanier extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantite',
    ];

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
