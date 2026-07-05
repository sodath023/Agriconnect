<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Liste toutes les catégories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Affiche le formulaire de création
    public function create()
    {
        return response()->json(['message' => 'Formulaire de création de catégorie']);
    }

    // Stocke une nouvelle catégorie
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'category' => $category
        ], 201);
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    // Met à jour une catégorie
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'category' => $category
        ]);
    }

    // Supprime une catégorie
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Catégorie supprimée avec succès']);
    }
}
