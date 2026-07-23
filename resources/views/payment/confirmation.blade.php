@extends('layouts.app', ['title' => 'Paiement confirmé - Agriconnect'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        
        {{-- Animation de succès --}}
        <div class="text-center mb-8 animate-bounce">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-500 text-white mb-6">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        {{-- En-tête de confirmation --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-green-900 mb-3">✅ Paiement Confirmé!</h1>
            <p class="text-lg text-green-700">Votre commande a été payée avec succès</p>
        </div>

        {{-- Contenu principal --}}
        <div class="grid gap-8 lg:grid-cols-3">
            
            {{-- Colonne gauche: Détails de confirmation --}}
            <div class="lg:col-span-2">
                
                {{-- Carte de confirmation --}}
                <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                    <div class="border-4 border-dashed border-green-300 rounded-lg p-6 text-center mb-6">
                        <p class="text-sm text-green-600 font-bold tracking-widest mb-2">CONFIRMATION DE PAIEMENT</p>
                        <p class="text-3xl font-bold text-green-900">Référence #{{ $payment->reference }}</p>
                    </div>

                    {{-- Informations du paiement --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8 pb-8 border-b border-gray-200">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold mb-2">STATUT DU PAIEMENT</p>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-lg font-bold text-green-600">{{ $payment->statut }} ✅</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold mb-2">MONTANT PAYÉ</p>
                            <p class="text-lg font-bold text-gray-800">
                                {{ number_format($payment->montant, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold mb-2">OPÉRATEUR</p>
                            <p class="text-lg font-semibold">
                                @if($payment->operator === 'MTN')
                                    📱 MTN Mobile Money
                                @elseif($payment->operator === 'Moov')
                                    💳 Moov Money
                                @else
                                    💰 {{ $payment->methode }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold mb-2">DATE & HEURE</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y H:i') : 'À l\'instant' }}
                            </p>
                        </div>
                    </div>

                    {{-- Détails de la livraison --}}
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📦 Détails de votre commande</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 font-semibold mb-2">NUMÉRO DE COMMANDE</p>
                                <p class="text-lg font-bold text-gray-800">#{{ $order->reference }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold mb-2">STATUT</p>
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                                    ✅ {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 font-semibold mb-3">ADRESSE DE LIVRAISON</p>
                            <div class="text-gray-800">
                                <p class="font-semibold">{{ $order->firstname }} {{ $order->lastname }}</p>
                                <p class="text-sm">{{ $order->phone }}</p>
                                <p class="text-sm">{{ $order->email }}</p>
                                <p class="mt-2 font-semibold">📍 {{ $order->address }}</p>
                                <p class="text-sm">{{ $order->city }}</p>
                                @if($order->notes)
                                    <p class="text-sm mt-2 text-gray-600"><strong>Notes:</strong> {{ $order->notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Articles commandés --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">🛍️ Articles commandés</h3>
                        
                        <div class="space-y-3">
                            @forelse ($order->lignecommandes as $item)
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $item?->product?->name ?? ($item?->name ?? 'Produit supprimé') }}</p>
                                        <p class="text-sm text-gray-600">Quantité: <strong>{{ $item?->quantity ?? 0 }}</strong></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-800">
                                            {{ number_format(($item?->quantity ?? 0) * ($item?->unit_price ?? 0), 0, ',', ' ') }} FCFA
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            @ {{ number_format($item?->unit_price ?? 0, 0, ',', ' ') }} FCFA
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Aucun article</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Résumé des montants --}}
                    <div class="border-t border-gray-200 pt-6">
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Sous-total</span>
                                <span>{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Frais de livraison</span>
                                <span>{{ number_format($order->shipping_fee ?? 0, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg flex justify-between items-center">
                            <span class="font-bold text-gray-800 text-lg">Total payé</span>
                            <span class="text-3xl font-bold text-green-600">
                                {{ number_format($order->total, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Prochaines étapes --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                    <h3 class="font-bold text-blue-900 mb-3">📋 Prochaines étapes</h3>
                    <ol class="text-blue-800 text-sm space-y-2 list-decimal list-inside">
                        <li>Vous recevrez un SMS de confirmation sous peu</li>
                        <li>Votre commande sera préparée par le producteur</li>
                        <li>Vous serez notifié une fois que la commande est prête pour la livraison</li>
                        <li>La livraison sera effectuée à l'adresse indiquée</li>
                    </ol>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('acheteur.commandes') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg text-center transition-all transform hover:scale-105">
                        📋 Voir mes commandes
                    </a>
                    <a href="{{ route('home') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 rounded-lg text-center transition-all transform hover:scale-105">
                        🏠 Retour à l'accueil
                    </a>
                </div>
            </div>

            {{-- Colonne droite: Ticket de paiement --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center border-b-2 border-dashed pb-4">
                        🎟️ Ticket de Paiement
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Référence</p>
                            <p class="font-mono font-bold text-gray-800 break-all">{{ $payment->reference }}</p>
                        </div>

                        <div class="border-t border-dashed pt-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Montant</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ number_format($payment->montant, 0, ',', ' ') }} FCFA
                            </p>
                        </div>

                        <div class="border-t border-dashed pt-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Opérateur</p>
                            <p class="font-semibold">
                                @if($payment->operator === 'MTN')
                                    MTN Mobile Money
                                @elseif($payment->operator === 'Moov')
                                    Moov Money
                                @else
                                    {{ $payment->methode }}
                                @endif
                            </p>
                        </div>

                        <div class="border-t border-dashed pt-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Téléphone</p>
                            <p class="font-mono font-semibold">{{ $payment->phone_number }}</p>
                        </div>

                        <div class="border-t border-dashed pt-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Date & Heure</p>
                            <p class="text-sm">
                                {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'Aujourd\'hui' }}<br>
                                <span class="text-xs text-gray-600">
                                    {{ $payment->payment_date ? $payment->payment_date->format('H:i:s') : '00:00:00' }}
                                </span>
                            </p>
                        </div>

                        <div class="border-t border-dashed pt-4 mt-4">
                            <p class="text-center text-green-600 font-bold">✅ PAIEMENT RÉUSSI</p>
                        </div>
                    </div>

                    {{-- Bouton d'impression (optionnel) --}}
                    <button 
                        onclick="window.print()" 
                        class="w-full mt-6 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg transition print:hidden"
                    >
                        🖨️ Imprimer le reçu
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles pour l'impression --}}
<style>
    @media print {
        body {
            background: white;
        }
        
        .print\:hidden {
            display: none;
        }
        
        .sticky {
            position: static;
        }
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .animate-bounce {
        animation: bounce 1s infinite;
    }
</style>
@endsection
