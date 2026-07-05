<?php

namespace App\Http\Controllers;

use App\Models\Acheteur;
use App\Models\commande;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // Afficher le tableau de bord du client
        $commandes = commande::where('acheteur_id', auth()->id())->orderBy('created_at', 'desc')->get();
        $totalCommandes = $commandes->count();
        $totalMontant = $commandes->sum('montant_total');
        return view('Acheteurs.dashboard-acheteur', compact('totalCommandes', 'totalMontant', 'commandes'));
    }
    public function indexCommandes()
    {
        // Afficher la page de mes commandes du client
        $commandes = commande::where('acheteur_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('Acheteurs.mes-commandes', compact('commandes'));
    }
    public function indexTransversal()
    {
        // Afficher la page de transversal du client
        return view('Acheteurs.transversal');
    }
    public function indexdetailCommandes($id)
    {
        // Afficher la page de detail de mes commandes du client
        $commande = commande::findOrFail($id);
        return view('acheteurs.detail-commande', compact('commande'));
    }

    public function profile()
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        $client = Acheteur::where('user_id', $user->id)->first();

        if (! $client) {
            $client = Acheteur::create([
                'user_id' => $user->id,
                'typeacheteur' => 'particulier',
                'adresseLivraison' => '',
            ]);
        }

        return view('acheteurs.profil-acheteur', compact('client'));
    }

    public function updateProfile(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'typeacheteur' => 'required|string|in:particulier,restaurateur,grossiste',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $client = Acheteur::where('user_id', auth()->id())->first();

        if (! $client) {
            $client = Acheteur::create([
                'user_id' => auth()->id(),
                'typeacheteur' => $request->input('typeacheteur'),
                'adresseLivraison' => '',
            ]);
        } else {
            $client->update([
                'typeacheteur' => $request->input('typeacheteur'),
            ]);
        }

        // Mettre à jour les informations de l'utilisateur
        $user = auth()->user();
        $user->update([
            'name' => $request->input('name'),
            'telephone' => $request->input('telephone'),
            'email' => $request->input('email'),
        ]);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
}
