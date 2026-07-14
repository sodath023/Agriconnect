<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    //fonction pour stocker un nouveau produit
    public function store(Request $request)
    {
        $request->validate([

        'category_id'=>'required|exists:categories,id',

        'nom'=>'required',

        'description'=>'string',

        'prix'=>'required|numeric',

        'stock'=>'required|integer',

        'image'=>'required|image'
    ]);

    $image = null;

    if($request->hasFile('image'))
    {
        $image = $request->file('image')
                ->store('products','public');
    }

    $product = Product::create([

        'user_id'=>Auth::id(),

        'category_id'=>$request->category_id,

        'nom'=>$request->nom,

        'description'=>$request->description,

        'prix'=>$request->prix,

        'stock'=>$request->stock,

        'image'=>$image,

        'latitude'=>$request->latitude,

        'longitude'=>$request->longitude
    ]);

    return response()->json([
        'message'=>'Produit créé',
        'product'=>$product
    ]);
}
//liste des produits validés
public function index()
{
    return Product::with([
        'producer',
        'category'
    ])
    ->where('statut','valide')
    ->latest()
    ->paginate(12);
}
//details d'un produit
public function show(Product $product)
{
    return $product->load([
        'producer',
        'category'
    ]);
}

}