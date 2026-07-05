<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'nom',
        'description',
        'prix',
        'stock',
        'unite',
        'image',
        'latitude',
        'longitude',
        'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function producer()
    {
        return $this->hasOneThrough(Producteur::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}