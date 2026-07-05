<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Liste toutes les catégories
    public function index()
    {
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.categories.create');
    }

    // Stocke une nouvelle catégorie
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => str($request->name)->slug(),
        ]);

        return redirect()->route('admin.categories')
            ->with('success', 'Catégorie créée avec succès');
    }

    // Affiche le formulaire d'édition
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Met à jour une catégorie
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => str($request->name)->slug(),
        ]);

        return redirect()->route('admin.categories')
            ->with('success', 'Catégorie mise à jour avec succès');
    }

    // Supprime une catégorie
    public function destroy(Category $category)
    {
        // Vérifier si la catégorie a des produits
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories')
                ->with('error', 'Cette catégorie contient des produits et ne peut pas être supprimée');
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Catégorie supprimée avec succès');
    }
}
