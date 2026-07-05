<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Panier;
use App\Models\ElementPanier;
use App\Models\Product;
use App\Models\commande as Commande;
use App\Models\Lignecommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('index', compact('categories'));
    }

    public function detailProduit(Request $request, $id = null)
    {
        if (! $id) {
            return redirect()->route('catalogue');
        }

        $produit = Product::with(['category', 'user'])->findOrFail($id);

        return view('produit', compact('produit'));
    }

    public function catalogue(Request $request)
    {
        $categories = Category::query()->orderBy('name')->get();
        $produits = Product::query()
            ->with(['category', 'user'])
            ->orderBy('nom')
            ->paginate(15);

        return view('catalogue', compact('categories', 'produits'));
    }

    public function ajouter(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $cart = Panier::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $item = ElementPanier::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,

        ]);

        $item->quantite = ($item->exists ? $item->quantite : 0) + $request->quantite;
        $item->save();

        return redirect()->route('panier')->with('success', 'Produit ajouté au panier.');
    }

    public function panier()
    {
        $cart = Panier::with('items.product.category')
            ->where('user_id', auth()->id())
            ->first();

        $items = $cart?->items ?? collect();

        return view('panier', compact('cart', 'items'));
    }

    public function mettreAJour(Request $request, ElementPanier $item)
    {
        if ($item->panier->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $item->update(['quantite' => $request->quantite]);

        return redirect()->route('panier')->with('success', 'Quantité mise à jour.');
    }

    public function supprimer(ElementPanier $item)
    {
        if ($item->panier->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('panier')->with('success', 'Article supprimé du panier.');
    }

    public function checkout()
    {
        $cart = Panier::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('panier')->with('error', 'Votre panier est vide.');
        }

        return view('checkout', compact('cart'));
    }


}