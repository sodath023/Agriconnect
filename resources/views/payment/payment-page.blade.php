@extends('layouts.app', ['title' => 'Paiement - Agriconnect'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        
        {{-- En-tête --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-900 mb-2">💳 Page de Paiement</h1>
            <p class="text-green-700">Commande <strong>#{{ $order->reference }}</strong></p>
        </div>

        {{-- Contenu principal --}}
        <div class="grid gap-8 lg:grid-cols-3">
            
            {{-- Colonne gauche: Formulaire de paiement --}}
            <div class="lg:col-span-2">
                
                {{-- Erreur générale --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <strong>Erreur!</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Message d'info --}}
                @if (session('info'))
                    <div class="alert alert-info mb-4" role="alert">
                        {{ session('info') }}
                    </div>
                @endif

                {{-- Carte de paiement --}}
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="text-2xl">📱</span> Choisir l'opérateur
                    </h2>

                    <form id="paymentForm" class="space-y-6">
                        @csrf
                        
                        <!-- Input caché pour order_id -->
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        {{-- Choix de l'opérateur --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-4">Opérateur de paiement</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($operators as $code => $operator)
                                    <label class="operator-choice cursor-pointer">
                                        <input 
                                            type="radio" 
                                            name="operator" 
                                            value="{{ $code }}" 
                                            class="hidden peer"
                                            required
                                        >
                                        <div class="p-4 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-green-600 peer-checked:bg-green-50 hover:border-green-400">
                                            <div class="text-center">
                                                <span class="text-4xl block mb-2">{{ $operator['icon'] }}</span>
                                                <span class="font-bold text-lg text-gray-800">{{ $operator['name'] }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('operator')
                                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Numéro de téléphone --}}
                        <div>
                            <label for="phone" class="block text-gray-700 font-semibold mb-2">
                                Numéro de téléphone <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <select class="w-20 px-3 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-200 bg-white text-gray-800">
                                    <option selected>+237</option>
                                    <option>+225</option>
                                    <option>+221</option>
                                    <option>+230</option>
                                </select>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone_number" 
                                    class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-200"
                                    placeholder="6 12 34 56 78"
                                    pattern="[0-9]{8,15}"
                                    required
                                    value="{{ old('phone_number', auth()->user()->telephone ?? '') }}"
                                >
                            </div>
                            @error('phone_number')
                                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                            @enderror
                            <p class="text-gray-500 text-sm mt-2">
                                📍 Conseil: Utilisez le numéro associé à votre compte mobile money
                            </p>
                        </div>

                        {{-- Conditions d'utilisation --}}
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <input 
                                type="checkbox" 
                                id="terms" 
                                name="terms" 
                                class="mt-1 w-4 h-4 text-green-600 cursor-pointer"
                                required
                            >
                            <label for="terms" class="text-sm text-gray-700 cursor-pointer">
                                Je confirme que j'accepte les conditions de paiement et que le numéro saisi est correct.
                            </label>
                        </div>

                        {{-- Bouton de paiement --}}
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 rounded-lg transition-all transform hover:scale-105 flex items-center justify-center gap-2 text-lg"
                            id="submitBtn"
                        >
                            <span id="btnText">💰 Confirmer le paiement</span>
                            <span id="btnLoader" class="hidden animate-spin">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </span>
                        </button>

                        {{-- Remarque de simulation --}}
                        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded text-sm text-yellow-800">
                            <strong>⚠️ Simulation</strong><br>
                            Ceci est une simulation. Le paiement n'est pas réel. Un code USSD ne vous sera pas demandé.
                        </div>
                    </form>
                </div>
            </div>

            {{-- Colonne droite: Récapitulatif de la commande --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="text-xl">📦</span> Récapitulatif
                    </h3>

                    {{-- Détails de la livraison --}}
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold mb-2">LIVRAISON</p>
                        <p class="text-gray-800 text-sm mb-1">
                            <strong>{{ $order->firstname }} {{ $order->lastname }}</strong>
                        </p>
                        <p class="text-gray-600 text-xs">
                            📍 {{ $order->address }}<br>
                            {{ $order->city }}
                        </p>
                    </div>

                    {{-- Produits --}}
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold mb-3">ARTICLES</p>
                        <div class="space-y-3">
                            @forelse ($order->lignecommandes as $item)
                                <div class="flex justify-between text-sm">
                                    <div class="text-gray-700">
                                        <p class="font-medium truncate">{{ $item?->product?->name ?? ($item?->name ?? 'Produit') }}</p>
                                        <p class="text-gray-500 text-xs">Qty: {{ $item?->quantity ?? 0 }}</p>
                                    </div>
                                    <p class="font-semibold text-gray-800 text-right">
                                        {{ number_format(($item?->quantity ?? 0) * ($item?->unit_price ?? 0), 0, ',', ' ') }} FCFA
                                    </p>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">Aucun article</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Montants --}}
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Sous-total</span>
                            <span>{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Frais de livraison</span>
                            <span>{{ number_format($order->shipping_fee ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center bg-green-50 p-4 rounded-lg">
                        <span class="font-bold text-gray-800">Total à payer</span>
                        <span class="text-2xl font-bold text-green-600">
                            {{ number_format($order->total, 0, ',', ' ') }} FCFA
                        </span>
                    </div>

                    {{-- Statut du paiement existant --}}
                    @if ($payment)
                        <div class="mt-4 p-3 rounded-lg 
                            @if($payment->statut === 'SUCCESS') 
                                bg-green-100 border-l-4 border-green-500 text-green-800
                            @elseif($payment->statut === 'FAILED')
                                bg-red-100 border-l-4 border-red-500 text-red-800
                            @else
                                bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800
                            @endif
                        ">
                            <p class="text-xs font-semibold">
                                @if($payment->statut === 'SUCCESS')
                                    ✅ PAIEMENT RÉUSSI
                                @elseif($payment->statut === 'FAILED')
                                    ❌ PAIEMENT ÉCHOUÉ
                                @else
                                    ⏳ EN ATTENTE
                                @endif
                            </p>
                            <p class="text-xs mt-1">Référence: {{ $payment->reference }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal d'attente et de traitement --}}
<div id="processingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-2xl p-8 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4 animate-pulse">
                <svg class="w-8 h-8 text-green-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Traitement du paiement...</h3>
            <p class="text-gray-600 mb-6">
                Veuillez patienter. Nous traitons votre demande de paiement.
            </p>
            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                <div class="bg-green-600 h-full animate-pulse" style="animation: progress 3s ease-in-out infinite;"></div>
            </div>
            <p class="text-gray-500 text-sm mt-4">Ne fermez pas cette page</p>
        </div>
    </div>
</div>

{{-- Styles personnalisés et animations --}}
<style>
    @keyframes progress {
        0% { width: 0; }
        50% { width: 100%; }
        100% { width: 0; }
    }
    
    .operator-choice input[type="radio"]:checked + div {
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }

    #submitBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');
    const processingModal = document.getElementById('processingModal');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validation
        const operator = document.querySelector('input[name="operator"]:checked');
        const phone = document.getElementById('phone').value.trim();
        const terms = document.getElementById('terms').checked;

        if (!operator || !phone || !terms) {
            alert('Veuillez remplir tous les champs requis.');
            return;
        }

        // Désactiver le bouton
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoader.classList.remove('hidden');

        // Afficher le modal de traitement
        processingModal.classList.remove('hidden');

        try {
            // 1️⃣ Étape 1: Initialiser le paiement
            const initResponse = await fetch('{{ route("payment.initialize") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({
                    order_id: document.querySelector('input[name="order_id"]').value,
                    operator: operator.value,
                    phone_number: document.querySelector('input[name="phone_number"]').value,
                }),
            });

            const initData = await initResponse.json();

            if (!initData.success) {
                throw new Error(initData.message || 'Erreur lors de l\'initialisation du paiement');
            }

            // 2️⃣ Étape 2: Attendre quelques secondes (simulation du traitement)
            await new Promise(resolve => setTimeout(resolve, 3000));

            // 3️⃣ Étape 3: Vérifier le statut du paiement
            const verifyResponse = await fetch('{{ route("payment.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({
                    payment_id: initData.payment_id,
                    order_id: initData.order_id,
                }),
            });

            const verifyData = await verifyResponse.json();

            // 4️⃣ Étape 4: Traiter le résultat
            if (verifyData.success && verifyData.status === 'SUCCESS') {
                // ✅ SUCCÈS
                await new Promise(resolve => setTimeout(resolve, 1500));
                window.location.href = verifyData.redirect_url;
            } else {
                // ❌ ÉCHEC
                processingModal.classList.add('hidden');
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');

                // Afficher le message d'erreur
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger mt-4';
                errorDiv.innerHTML = `
                    <strong>❌ Paiement échoué</strong><br>
                    ${verifyData.failure_reason || verifyData.message}<br><br>
                    <small>Référence: ${verifyData.order_id}</small>
                `;
                form.parentElement.insertBefore(errorDiv, form);

                // Faire défiler vers le message d'erreur
                errorDiv.scrollIntoView({ behavior: 'smooth' });
            }

        } catch (error) {
            processingModal.classList.add('hidden');
            submitBtn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoader.classList.add('hidden');

            console.error('Erreur:', error);
            alert('Erreur: ' + error.message);
        }
    });

    // Validation du numéro de téléphone en temps réel
    document.getElementById('phone').addEventListener('input', function() {
        const phone = this.value.trim();
        const isValid = /^[0-9]{8,15}$/.test(phone);
        this.classList.toggle('border-red-500', !isValid && phone.length > 0);
        this.classList.toggle('border-green-500', isValid);
    });
});
</script>
@endsection
