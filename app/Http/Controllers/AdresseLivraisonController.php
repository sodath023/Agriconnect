<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdressesLivraison;

class AdresseLivraisonController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'acheteur_id' => 'required|exists:acheteurs,id',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'téléphone' => 'required|string|max:20',
            'type' => 'required|in:domicile,travail,autre',
            'par_defaut' => 'required|boolean',
        ]);
        
        AdressesLivraison::create($validatedData);

        return redirect()->back()->with('success', 'Adresse de livraison ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'acheteur_id' => 'required|exists:acheteurs,id',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'téléphone' => 'required|string|max:20',
            'type' => 'required|in:domicile,travail,autre',
            'par_defaut' => 'required|boolean',
        ]);

        $adresseLivraison = AdressesLivraison::findOrFail($id);
        $adresseLivraison->update($validatedData);

        return redirect()->back()->with('success', 'Adresse de livraison mise à jour avec succès.');
    }   

    public function destroy($id)
    {
        $adresseLivraison = AdressesLivraison::findOrFail($id);
        $adresseLivraison->delete();

        return redirect()->back()->with('success', 'Adresse de livraison supprimée avec succès.');
    }
}
