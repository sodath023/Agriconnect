<?php

namespace App\Models;

use App\Models\ElementPanier;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ElementPanier::class, 'cart_id');
    }
}
