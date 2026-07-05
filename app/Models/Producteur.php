<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producteur extends Model
{
    protected $fillable = [
        'user_id',
        'localisation',
        'description',
        'piece',
        'certification',
        'noteGlobal',
        'kycValide',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
