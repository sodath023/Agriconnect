<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Commande;
use App\Models\Panier;
use App\Models\Lignecommande;

class ProducteurController extends Controller
{

    public function indexcommandesRecues()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        $productIds = Product::where('user_id', $user->id)->pluck('id');
        $orders = collect();

        if ($productIds->isNotEmpty()) {
            $orders = Lignecommande::whereIn('product_id', $productIds)
                ->with(['commande' => function ($query) {
                    $query->latest('created_at');
                }])
                ->get()
                ->groupBy('commande_id')
                ->map(function ($lineItems) {
                    $firstItem = $lineItems->first();
                    $commande = $firstItem->commande;
                    $status = $commande?->status ?? 'pending';

                    return [
                        'id' => $commande?->id,
                        'reference' => $commande?->reference ?? '#CMD-' . $firstItem->commande_id,
                        'buyer' => trim(($commande->firstname ?? '') . ' ' . ($commande->lastname ?? '')),
                        'products' => $lineItems->pluck('name')->unique()->implode(', '),
                        'quantity' => $lineItems->sum('quantity'),
                        'amount' => (int) ($commande->total ?? 0),
                        'status' => $status,
                        'status_label' => $this->formatOrderStatus($status),
                        'status_class' => $this->statusClass($status),
                        'created_at' => $commande?->created_at,
                        'items' => $lineItems,
                    ];
                })
                ->sortByDesc(function ($order) {
                    return $order['created_at'] ?? now();
                })
                ->values();
        }

        return view('producteur.commandes-recues', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Commande $commande)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        $hasProductFromProducer = Lignecommande::where('commande_id', $commande->id)
            ->whereIn('product_id', Product::where('user_id', $user->id)->pluck('id'))
            ->exists();

        if (! $hasProductFromProducer) {
            abort(403);
        }

        $action = $request->input('action');
        $status = match ($action) {
            'accept' => 'confirmed',
            'refuse' => 'canceled',
            default => $commande->status,
        };

        $commande->update(['status' => $status]);

        return redirect()->route('producteur.commandes-recues')->with('success', 'Commande mise à jour avec succès.');
    }

    public function createSampleOrder()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        $product = Product::where('user_id', $user->id)->first();

        if (! $product) {
            return redirect()->route('producteur.commandes-recues')->with('error', 'Ajoutez d’abord un produit pour pouvoir créer une commande de test.');
        }

        $commande = Commande::create([
            'reference' => 'CMD-TEST-' . now()->format('YmdHis'),
            'firstname' => 'Client',
            'lastname' => 'Test',
            'email' => 'client@example.com',
            'phone' => '97000000',
            'address' => 'Cotonou',
            'city' => 'Cotonou',
            'subtotal' => $product->prix * 2,
            'total' => $product->prix * 2,
            'status' => 'pending',
        ]);

        Lignecommande::create([
            'commande_id' => $commande->id,
            'product_id' => $product->id,
            'name' => $product->nom,
            'unit_price' => $product->prix,
            'quantity' => 2,
        ]);

        return redirect()->route('producteur.commandes-recues')->with('success', 'Une commande de test a été ajoutée.');
    }

    public function indexconfirmation()
    {
        // Logique pour récupérer les commandes reçues du producteur
        return view('producteur.confirmation');
    }

    public function indexdashboardproducteur()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        $products = Product::where('user_id', $user->id)
            ->latest()
            ->get();

        $productIds = $products->pluck('id');
        $lineItems = collect();
        $recentOrders = collect();
        $monthlyRevenue = 0;
        $pendingOrdersCount = 0;

        if ($productIds->isNotEmpty()) {
            $lineItems = Lignecommande::whereIn('product_id', $productIds)
                ->with(['commande' => function ($query) {
                    $query->latest('created_at');
                }])
                ->get();

            $recentOrders = $lineItems->map(function ($item) {
                $commande = $item->commande;

                return [
                    'id' => $commande?->reference ?? '#CMD-' . $item->commande_id,
                    'buyer' => trim(($commande->firstname ?? '') . ' ' . ($commande->lastname ?? '')),
                    'products' => $item->name,
                    'amount' => (int) ($commande->total ?? 0),
                    'status' => $commande->status ?? 'pending',
                ];
            })->take(5);

            $monthlyRevenue = $lineItems->sum(function ($item) {
                return (int) ($item->commande->total ?? 0);
            });

            $pendingOrdersCount = $lineItems->filter(function ($item) {
                $status = $item->commande->status ?? 'pending';
                return in_array($status, ['pending', 'processing', 'en_attente']);
            })->count();
        }

        $lowStockProducts = $products->filter(function ($product) {
            return $product->stock <= 5;
        })->values();

        $salesSeries = collect(range(6, 0))->map(function ($daysAgo) use ($lineItems) {
            $day = now()->subDays($daysAgo)->startOfDay();
            $nextDay = (clone $day)->endOfDay();

            $revenue = $lineItems->filter(function ($item) use ($day, $nextDay) {
                $commande = $item->commande;
                return $commande && $commande->created_at && $commande->created_at >= $day && $commande->created_at <= $nextDay;
            })->sum(function ($item) {
                return (int) ($item->commande->total ?? 0);
            });

            return [
                'day' => $day->locale('fr')->translatedFormat('D'),
                'value' => $revenue,
            ];
        });

        return view('producteur.dashboard-producteur', compact(
            'products',
            'recentOrders',
            'monthlyRevenue',
            'pendingOrdersCount',
            'lowStockProducts',
            'salesSeries'
        ));
    }

    public function indexcreerAnnonce()
    {
        // Logique pour récupérer les informations nécessaires à la création d'une annonce
        $categories = Category::all(); // Récupère toutes les catégories depuis la base de données
        // Logique pour créer une annonce du producteur
        return view('producteur.creer-annonce', ['categories' => $categories]);
    }

    private function formatOrderStatus(string $status): string
    {
        return match ($status) {
            'confirmed', 'paid' => 'Confirmée',
            'canceled', 'cancelled', 'refused' => 'Refusée',
            'processing' => 'En cours',
            default => 'En attente',
        };
    }

    private function statusClass(string $status): string
    {
        return match ($status) {
            'confirmed', 'paid' => 'bs',
            'canceled', 'cancelled', 'refused' => 'br',
            default => 'bw',
        };
    }

    public function indexdetailCommandesRecues()
    {
        return view('producteur.detail-commande-recue');
    }

    public function indexmesProducts()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        $products = Product::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->get();

        return view('producteur.mes-produits', ['products' => $products]);
    }

    public function indexmesRevenus()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('connexion');
        }

        $products = Product::where('user_id', $user->id)->get();
        $productIds = $products->pluck('id');

        $lineItems = collect();
        $transactions = collect();
        $monthlyRevenue = collect();
        $confirmedRevenue = 0;
        $pendingRevenue = 0;
        $platformFees = 0;
        $availableBalance = 0;

        if ($productIds->isNotEmpty()) {
            $lineItems = Lignecommande::whereIn('product_id', $productIds)
                ->with(['commande'])
                ->get();

            $confirmedRevenue = $lineItems->filter(function ($item) {
                $status = $item->commande->status ?? 'pending';
                return in_array($status, ['confirmed', 'paid']);
            })->sum(function ($item) {
                return (int) ($item->unit_price * $item->quantity);
            });

            $pendingRevenue = $lineItems->filter(function ($item) {
                $status = $item->commande->status ?? 'pending';
                return in_array($status, ['pending', 'processing', 'en_attente']);
            })->sum(function ($item) {
                return (int) ($item->unit_price * $item->quantity);
            });

            $platformFees = (int) round($confirmedRevenue * 0.04);
            $availableBalance = $confirmedRevenue - $platformFees;

            $transactions = $lineItems->filter(function ($item) {
                return $item->commande;
            })->map(function ($item) {
                $commande = $item->commande;
                $status = $commande->status ?? 'pending';
                $amount = (int) ($item->unit_price * $item->quantity);

                return [
                    'date' => $commande->created_at?->translatedFormat('d M') ?? '-',
                    'label' => 'Vente ' . ($commande->reference ?? '#CMD-' . $item->commande_id),
                    'amount' => $amount,
                    'type' => 'sale',
                    'status_label' => $this->formatOrderStatus($status),
                    'status_class' => $this->statusClass($status),
                ];
            })->take(8)->values();

            $monthlyRevenue = collect(range(5, 0))->map(function ($monthOffset) use ($lineItems) {
                $monthStart = now()->subMonths($monthOffset)->startOfMonth();
                $monthEnd = (clone $monthStart)->endOfMonth();

                $revenue = $lineItems->filter(function ($item) use ($monthStart, $monthEnd) {
                    $commande = $item->commande;
                    return $commande && $commande->created_at && $commande->created_at >= $monthStart && $commande->created_at <= $monthEnd;
                })->sum(function ($item) {
                    return (int) ($item->unit_price * $item->quantity);
                });

                return [
                    'month' => $monthStart->locale('fr')->translatedFormat('M'),
                    'value' => $revenue,
                ];
            });
        }

        return view('producteur.mes-revenus', compact(
            'products',
            'confirmedRevenue',
            'pendingRevenue',
            'platformFees',
            'availableBalance',
            'transactions',
            'monthlyRevenue'
        ));
    }
}
