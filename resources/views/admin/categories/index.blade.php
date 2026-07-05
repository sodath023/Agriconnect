@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Catégories</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter une catégorie
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nom</th>
                    <th class="border px-4 py-2">Slug</th>
                    <th class="border px-4 py-2">Produits</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $category->id }}</td>
                        <td class="border px-4 py-2">{{ $category->name }}</td>
                        <td class="border px-4 py-2">{{ $category->slug }}</td>
                        <td class="border px-4 py-2 text-center">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $category->products_count }}</span>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Éditer</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-2 text-center text-gray-500">Aucune catégorie trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
