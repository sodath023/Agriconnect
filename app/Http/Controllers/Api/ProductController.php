<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Liste tous les produits de l'utilisateur connecté
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return response()->json($products);
    }

    // Affiche le formulaire de création
    public function create()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories]);
    }

    // Stocke un nouveau produit
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unite' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'unite' => $request->unite,
            'image' => $image,
            'latitude' => 0,
            'longitude' => 0,
            'statut' => 'en_attente'
        ]);

        if ($product) {
            return redirect()->route('producteur.mes-produits')->with('success', 'Produit créé avec succès');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la création du produit');
        }
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $categories = Category::all();
        
        return view('producteur.edit-produit', compact(
            'product',
            'categories'
        ));
    }

    // Met à jour un produit
    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unite' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
            $product->image = $image;
        }

        $product->update([
            'category_id' => $request->category_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'unite' => $request->unite ?? $product->unite,
            'latitude' => $request->latitude ?? $product->latitude,
            'longitude' => $request->longitude ?? $product->longitude
        ]);

        if ($product) {
            return redirect()->route('producteur.mes-produits')->with('success', 'Produit mis à jour avec succès');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du produit');
        }
    }

    // Supprime un produit
    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('producteur.mes-produits')->with('success', 'Produit supprimé avec succès');
    }
}
