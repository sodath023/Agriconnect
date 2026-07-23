@extends('layouts.app', ['title' => 'Paiement - AgriConnect'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4">
    <div class="max-w-5xl mx-auto">

        {{-- Indicateur de progression --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div id="step-indicator-1" class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">1</div>
                        <span class="font-semibold text-gray-800">Récapitulatif</span>
                    </div>
                    <div class="mx-4 h-1 w-12 bg-gray-300 rounded" id="progress-line"></div>
                    <div id="step-indicator-2" class="flex items-center gap-2 opacity-50">
                        <div class="w-10 h-10 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold">2</div>
                        <span class="font-semibold text-gray-600">Paiement</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Messages de session --}}
        @if (session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- ÉTAPE 1 : Récapitulatif + Choix Opérateur --}}
        <div id="step-1" class="transition-all duration-300">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Récapitulatif de votre commande</h2>

                {{-- Infos de livraison --}}
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📍 Adresse de livraison</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-semibold">{{ $order->firstname }} {{ $order->lastname }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $order->phone }}</p>
                        <p class="text-sm text-gray-600">{{ $order->email }}</p>
                        <p class="font-semibold text-gray-800 mt-3">📌 {{ $order->address }}</p>
                        <p class="text-sm text-gray-600">{{ $order->city }}</p>
                    </div>
                </div>

                {{-- Articles commandés --}}
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">🛍️ Articles commandés</h3>
                    <div class="space-y-3">
                        @forelse ($order->lignecommandes as $item)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item?->product?->name ?? ($item?->name ?? 'Produit') }}</p>
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
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Sous-total</span>
                            <span>{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Frais de livraison</span>
                            <span>{{ number_format($order->shipping_fee ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>

                {{-- Total --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg mb-8 border-2 border-blue-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total à payer</span>
                        <span class="text-4xl font-bold text-blue-600">
                            {{ number_format($order->total, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>

                {{-- Choix de l'opérateur --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">💳 Choisir l'opérateur de paiement</h3>
                    <form id="operatorForm" class="space-y-4">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- MTN --}}
                            <label class="operator-btn cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="operator" 
                                    value="MTN" 
                                    class="hidden peer"
                                    required
                                >
                                <div class="p-6 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:ring-2 peer-checked:ring-yellow-200 hover:border-yellow-400 cursor-pointer">
                                    <div class="text-center">
                                        <span class="text-5xl block mb-3">📱</span>
                                        <p class="font-bold text-lg text-gray-800">MTN Mobile Money</p>
                                        <p class="text-sm text-gray-600 mt-1">Paiement sécurisé</p>
                                    </div>
                                </div>
                            </label>

                            {{-- Moov --}}
                            <label class="operator-btn cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="operator" 
                                    value="Moov" 
                                    class="hidden peer"
                                >
                                <div class="p-6 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 hover:border-blue-400 cursor-pointer">
                                    <div class="text-center">
                                        <span class="text-5xl block mb-3">💳</span>
                                        <p class="font-bold text-lg text-gray-800">Moov Money</p>
                                        <p class="text-sm text-gray-600 mt-1">Paiement rapide</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('operator')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </form>
                </div>

                {{-- Bouton Payer --}}
                <div class="flex gap-4">
                    <a href="{{ route('panier') }}" class="flex-1 px-6 py-3 border-2 border-gray-400 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                        ← Retour au panier
                    </a>
                    <button 
                        type="button"
                        onclick="goToStep2()"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-green-700 transition-all transform hover:scale-105"
                    >
                        💰 Payer → 
                    </button>
                </div>

                {{-- Note de simulation --}}
                <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded text-sm text-yellow-800">
                    <strong>⚠️ Simulation</strong><br>
                    Ceci est une simulation de paiement. Aucune transaction réelle ne sera effectuée.
                </div>
            </div>
        </div>

        {{-- ÉTAPE 2 : Formulaire de Paiement --}}
        <div id="step-2" class="hidden transition-all duration-300">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                {{-- En-tête stylisé selon l'opérateur --}}
                <div id="payment-header" class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-8 text-white">
                    <h2 class="text-3xl font-bold">💳 Paiement MTN Mobile Money</h2>
                    <p class="mt-2 opacity-90">Montant: <span class="font-bold text-xl">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span></p>
                </div>

                <div class="p-8">
                    {{-- Formulaire de paiement --}}
                    <form id="paymentForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="operator" id="hidden-operator" value="">

                        {{-- Numéro de téléphone --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-3">
                                📱 Numéro de téléphone
                            </label>
                            <div class="flex gap-3">
                                <select class="w-24 px-3 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                                    <option selected>+237</option>
                                    <option>+225</option>
                                    <option>+221</option>
                                </select>
                                <input 
                                    type="tel" 
                                    id="phone_number"
                                    name="phone_number" 
                                    class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200"
                                    placeholder="6 12 34 56 78"
                                    pattern="[0-9]{8,15}"
                                    required
                                >
                            </div>
                            <p class="text-gray-500 text-sm mt-2">Utilisez le numéro de votre compte mobile money</p>
                        </div>

                        {{-- PIN (optionnel pour simulation) --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-3">
                                🔐 Code PIN
                            </label>
                            <input 
                                type="password" 
                                id="pin"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200"
                                placeholder="Entrez un code (optionnel)"
                                maxlength="4"
                            >
                            <p class="text-gray-500 text-sm mt-2">Laissez vide pour la simulation</p>
                        </div>

                        {{-- Conditions --}}
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <input 
                                type="checkbox" 
                                id="terms"
                                class="mt-1 w-4 h-4 text-green-600"
                                required
                            >
                            <label for="terms" class="text-sm text-gray-700">
                                Je confirme que j'accepte les conditions et que le numéro est correct
                            </label>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex gap-4">
                            <button 
                                type="button"
                                onclick="goToStep1()"
                                class="flex-1 px-6 py-3 border-2 border-gray-400 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition"
                            >
                                ← Retour
                            </button>
                            <button 
                                type="submit"
                                id="confirmBtn"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-green-700 transition-all transform hover:scale-105 flex items-center justify-center gap-2"
                            >
                                <span id="btnText">✓ Confirmer le paiement</span>
                                <span id="btnLoader" class="hidden animate-spin">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>

                    {{-- Affichage des erreurs --}}
                    <div id="errorDisplay" class="hidden mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <p id="errorMessage" class="text-red-800 font-semibold"></p>
                        <p id="errorReason" class="text-red-700 text-sm mt-1"></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de traitement --}}
        <div id="processingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-2xl p-8 max-w-md w-full mx-4 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4 animate-pulse">
                    <svg class="w-8 h-8 text-green-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Traitement du paiement...</h3>
                <p class="text-gray-600 mb-6">Veuillez patienter. Nous traitons votre demande.</p>
                <p class="text-gray-500 text-sm">Ne fermez pas cette page</p>
            </div>
        </div>
    </div>
</div>

<style>
    .operator-btn input[type="radio"]:checked + div {
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
    }

    #confirmBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<script>
    // Données globales
    let selectedOperator = null;
    const operatorThemes = {
        'MTN': {
            bgGradient: 'from-yellow-500 to-yellow-600',
            borderColor: 'border-yellow-500',
            accentColor: 'text-yellow-600',
        },
        'Moov': {
            bgGradient: 'from-blue-500 to-blue-600',
            borderColor: 'border-blue-500',
            accentColor: 'text-blue-600',
        }
    };

    // Aller à l'étape 2
    function goToStep2() {
        const operator = document.querySelector('input[name="operator"]:checked');
        
        if (!operator) {
            alert('Veuillez sélectionner un opérateur');
            return;
        }

        selectedOperator = operator.value;
        document.getElementById('hidden-operator').value = selectedOperator;

        // Mettre à jour le thème
        updatePaymentTheme(selectedOperator);

        // Transition vers étape 2
        document.getElementById('step-1').classList.add('hidden');
        document.getElementById('step-2').classList.remove('hidden');

        // Mettre à jour l'indicateur
        updateStepIndicator(2);

        // Focus sur le champ téléphone
        setTimeout(() => document.getElementById('phone_number').focus(), 100);

        // Scroll vers le haut
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Aller à l'étape 1
    function goToStep1() {
        document.getElementById('step-2').classList.add('hidden');
        document.getElementById('step-1').classList.remove('hidden');
        document.getElementById('errorDisplay').classList.add('hidden');

        // Mettre à jour l'indicateur
        updateStepIndicator(1);

        // Scroll vers le haut
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Mettre à jour le thème selon l'opérateur
    function updatePaymentTheme(operator) {
        const header = document.getElementById('payment-header');
        const theme = operatorThemes[operator];
        
        header.className = `bg-gradient-to-r ${theme.bgGradient} p-8 text-white`;
        
        const title = header.querySelector('h2');
        const operatorName = operator === 'MTN' ? 'MTN Mobile Money' : 'Moov Money';
        title.textContent = `💳 Paiement ${operatorName}`;
    }

    // Mettre à jour l'indicateur d'étape
    function updateStepIndicator(step) {
        const line = document.getElementById('progress-line');
        const ind1 = document.getElementById('step-indicator-1');
        const ind2 = document.getElementById('step-indicator-2');
        
        if (step === 2) {
            line.classList.add('bg-green-500');
            ind1.classList.add('opacity-50');
            ind2.classList.remove('opacity-50');
        } else {
            line.classList.remove('bg-green-500');
            ind1.classList.remove('opacity-50');
            ind2.classList.add('opacity-50');
        }
    }

    // Traiter le paiement
    document.getElementById('paymentForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const phone = document.getElementById('phone_number').value.trim();
        const terms = document.getElementById('terms').checked;

        if (!phone || !terms) {
            alert('Veuillez remplir tous les champs');
            return;
        }

        // Afficher le modal de traitement
        document.getElementById('processingModal').classList.remove('hidden');
        document.getElementById('confirmBtn').disabled = true;

        try {
            // 1️⃣ Initialiser le paiement
            const initResponse = await fetch('{{ route("payment.initialize") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({
                    order_id: document.querySelector('input[name="order_id"]').value,
                    operator: selectedOperator,
                    phone_number: phone,
                }),
            });

            const initData = await initResponse.json();

            if (!initData.success) {
                throw new Error(initData.message || 'Erreur lors de l\'initialisation');
            }

            // 2️⃣ Attendre 3 secondes
            await new Promise(resolve => setTimeout(resolve, 3000));

            // 3️⃣ Vérifier le statut
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

            if (verifyData.success && verifyData.status === 'SUCCESS') {
                // ✅ Succès
                await new Promise(resolve => setTimeout(resolve, 1500));
                window.location.href = verifyData.redirect_url;
            } else {
                // ❌ Échec
                document.getElementById('processingModal').classList.add('hidden');
                document.getElementById('confirmBtn').disabled = false;

                document.getElementById('errorDisplay').classList.remove('hidden');
                document.getElementById('errorMessage').textContent = '❌ Paiement échoué';
                document.getElementById('errorReason').textContent = verifyData.failure_reason || verifyData.message;
            }

        } catch (error) {
            document.getElementById('processingModal').classList.add('hidden');
            document.getElementById('confirmBtn').disabled = false;

            console.error('Erreur:', error);
            alert('Erreur: ' + error.message);
        }
    });

    // Validation du téléphone en temps réel
    document.getElementById('phone_number').addEventListener('input', function() {
        const phone = this.value.trim();
        const isValid = /^[0-9]{8,15}$/.test(phone);
        this.classList.toggle('border-red-500', !isValid && phone.length > 0);
        this.classList.toggle('border-green-500', isValid);
    });
</script>

@endsection
