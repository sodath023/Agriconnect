<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'role',
        'password',
    ];

    protected $attributes = [
        'role' => 'acheteur',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function producteur()
    {
        return $this->hasOne(Producteur::class);
    }

    public function acheteur()
    {
        return $this->hasOne(Acheteur::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function markEmailAsVerified(): void
    {
        $this->email_verified_at = now();
        $this->save();
    }
}
