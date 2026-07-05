<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['identifier', 'token', 'used', 'expires_at'];

    public static function generate($identifier): self
    {
        self::where('identifier', $identifier)->delete(); // Supprimer les anciens OTP pour cet identifiant
        $token = rand(100000, 999999); // Génère un code OTP à 6 chiffres
        $expiresAt = now()->addMinutes(10); // L'OTP expire après 10 minutes

        return self::create([
            'identifier' => $identifier,
            'token' => $token,
            'expires_at' => $expiresAt,
        ]);
    }

    public static function verify($identifier, $token): bool
    {
        $otp = self::where('identifier', $identifier)
                    ->where('token', $token)
                    ->where('used', false)
                    ->where('expires_at', '>', now())
                    ->first();

        if ($otp) {
            $otp->update(['used' => true]); // Marquer l'OTP comme utilisé
            return true;
        }

        return false;
    }
}
