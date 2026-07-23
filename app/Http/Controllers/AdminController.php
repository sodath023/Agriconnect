<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\commande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function indexdashboardadmin()
    {
        $totalRevenue = (int) commande::whereIn('status', ['paid', 'confirmed'])->sum('total');
        $platformFees = (int) round($totalRevenue * 0.04);
        $activeUsers = User::count();
        $buyers = User::where('role', 'acheteur')->count();
        $producers = User::where('role', 'producteur')->count();
        $pendingProducts = Product::where('statut', 'en_attente')->count();
        $validatedProducts = Product::where('statut', 'valide')->count();

        $driver = DB::connection()->getDriverName();
        $monthExpression = $driver === 'sqlite'
            ? "CAST(strftime('%m', created_at) AS INTEGER)"
            : 'MONTH(created_at)';

        $monthlySignups = User::select(
            DB::raw("{$monthExpression} as month"),
            DB::raw('count(*) as total')
        )
            ->whereNotNull('created_at')
            ->groupBy(DB::raw($monthExpression))
            ->orderBy(DB::raw($monthExpression))
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $monthlyProducers = User::where('role', 'producteur')->select(
            DB::raw("{$monthExpression} as month"),
            DB::raw('count(*) as total')
        )
            ->whereNotNull('created_at')
            ->groupBy(DB::raw($monthExpression))
            ->orderBy(DB::raw($monthExpression))
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $monthlyBuyers = User::where('role', 'acheteur')->select(
            DB::raw("{$monthExpression} as month"),
            DB::raw('count(*) as total')
        )
            ->whereNotNull('created_at')
            ->groupBy(DB::raw($monthExpression))
            ->orderBy(DB::raw($monthExpression))
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $labels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'];
        $producerSeries = array_values(array_map(fn($month) => $monthlyProducers[$month] ?? 0, range(1, 6)));
        $buyerSeries = array_values(array_map(fn($month) => $monthlyBuyers[$month] ?? 0, range(1, 6)));

        return view('admin.admin-dashboard', compact(
            'totalRevenue',
            'platformFees',
            'activeUsers',
            'buyers',
            'producers',
            'pendingProducts',
            'validatedProducts',
            'labels',
            'producerSeries',
            'buyerSeries'
        ));
    }

    public function indexmoderationadmin()
    {
        $products = Product::with(['user', 'category'])
            ->where('statut', 'en_attente')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.admin-moderation', compact('products'));
    }

    public function indexparametresadmin()
    {
        return view('admin.admin-parametres');
    }

    public function indexutilisateursadmin()
    {
        $users = User::with(['producteur', 'acheteur', 'products'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.admin-utilisateurs', compact('users'));
    }

    public function exportUsersPdf()
    {
        $users = User::with(['producteur', 'acheteur', 'products'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.users-pdf', compact('users'));

        return $pdf->download('utilisateurs-kyc.pdf');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.utilisateurs')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('admin.utilisateurs')->with('success', 'Rôle de l\'utilisateur mis à jour avec succès.');
    }

    public function validerProduit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->statut = "valide";
        $product->save();

        return redirect()->route('admin.moderation')->with('success', 'Statut du produit mis à jour avec succès.');
    }

    public function rejeterProduit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->statut = "rejete";
        $product->save();

        return redirect()->route('admin.moderation')->with('success', 'Statut du produit mis à jour avec succès.');
    }
}