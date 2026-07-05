<?php

namespace App\Http\Controllers;

use App\Models\Acheteur;
use App\Models\Producteur;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Services\SmsServices;

class AuthController extends Controller
{
    private $smsService;

    public function __construct(SmsServices $smsService)
    {
        $this->smsService = $smsService;
    }

    public function getconnexion()
    {
        return view('connexion');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = trim($request->identifier);
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL) !== false;
        $normalizedIdentifier = $isEmail ? mb_strtolower($identifier) : $this->normalizePhone($identifier);

        $credentials = [
            'password' => $request->password,
        ];

        if ($isEmail) {
            $credentials['email'] = $normalizedIdentifier;
        } else {
            $credentials['telephone'] = $normalizedIdentifier;
        }

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'identifier' => 'Les informations de connexion sont incorrectes.',
            ])->onlyInput('identifier');
        }

        $request->session()->regenerate();

        if (Auth::user()->role === 'producteur') {
            return redirect()->route('producteur.dashboard');
        } else if (Auth::user()->role === 'administrateur') {
            return redirect()->route('admin.dashboard');
        }else {
            return redirect()->route('acheteur.dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('connexion');
    }

    public function getinscription()
    {
        return view('auth.inscription');
    }

    public function inscription(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:acheteur,producteur',
        ]);

        $validatedData['telephone'] = $this->normalizePhone($validatedData['telephone']);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'telephone' => $validatedData['telephone'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        $telephone = "+229" . $validatedData['telephone'];
        // Générer et envoyer l'OTP
        $otp = Otp::generate($telephone);

        $sent = $this->smsService->send(
            $telephone,
            "Bienvenue ! Votre code de confirmation : {$otp->token}. Valable 10 minutes."
        );

        if (! $sent) {
            Log::warning('Échec d\'envoi du SMS OTP pour l\'inscription.', ['user_id' => $user->id, 'telephone' => $telephone]);

            Auth::login($user);

            return redirect()->route($user->role === 'producteur' ? 'producteur.dashboard' : 'acheteur.dashboard')
                ->with('success', 'Inscription réussie. Le code de vérification n\'a pas pu être envoyé, mais votre compte est déjà créé.');
        }

        // Stocker l'ID en session pour l'étape de vérification
        session([
            'pending_user_id'    => $user->id,
            'otp_identifier'     => $telephone,
        ]);

        return redirect()->route('otp.form')
                         ->with('success', 'Code envoyé au ' . $request->telephone)
                         ->with('info', 'Veuillez vérifier votre téléphone pour le code de confirmation.'.$otp->token);
    }

    // Étape 3 — Afficher le formulaire de saisie du code
    public function showVerifyForm()
    {
        if (! session('pending_user_id')) {
            return redirect()->route('inscription');
        }

        return view('otp');
    }

    // Étape 4 — Vérifier le code et activer le compte
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'token' => 'required|digits:6',
        ]);

        $userId     = session('pending_user_id');
        $identifier = session('otp_identifier');

        if (! $userId || ! $identifier) {
            return redirect()->route('inscription')
                             ->withErrors(['token' => 'Session expirée, recommencez l\'inscription.']);
        }

        if (! Otp::verify($identifier, $request->token)) {
            return back()->withErrors(['token' => 'Code invalide ou expiré.']);
        }

        $user = User::findOrFail($userId);
        $user->markEmailAsVerified(); // Marquer l'email comme vérifié

        if ($user->role === 'producteur') {
            Producteur::create([
                'user_id' => $user->id,
                'localisation' => '',
                'description' => '',
                'certification' => false,
                'noteGlobal' => null,
                'kycValide' => false,
                'piece' => $request->file('piece') ? $request->file('piece')->store('pieces') : null,
            ]);
        } elseif ($user->role === 'acheteur') {
            Acheteur::create([
                'user_id' => $user->id,
                'typeacheteur' => false,
                'adresseLivraison' => '',
            ]);
        }



        // Nettoyer la session
        session()->forget(['pending_user_id', 'otp_identifier']);

        // Connecter automatiquement l'utilisateur
        Auth::login($user);

        if ($user->role === 'producteur') {
            return redirect()->route('producteur.dashboard')->with('success', 'Inscription réussie. Bienvenue !');
        } else {
            return redirect()->route('acheteur.dashboard')->with('success', 'Inscription réussie. Bienvenue !');
        }
    }

    // Renvoyer le code OTP
    public function resendOtp()
    {
        $identifier = session('otp_identifier');
        $userId     = session('pending_user_id');

        if (! $identifier || ! $userId) {
            return redirect()->route('inscription');
        }

        $otp = Otp::generate($identifier);

        $sent = $this->smsService->send(
            $identifier,
            "Votre nouveau code de confirmation : {$otp->token}. Valable 10 minutes."
        );

        if (! $sent) {
            return back()->withErrors(['token' => 'Échec de renvoi du SMS.']);
        }

        return back()->with('success', 'Nouveau code envoyé.');
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', trim($phone));

        if ($digits === '') {
            return trim($phone);
        }

        if (strlen($digits) > 8 && str_starts_with($digits, '229')) {
            $digits = substr($digits, 3);
        }

        return $digits;
    }
}
