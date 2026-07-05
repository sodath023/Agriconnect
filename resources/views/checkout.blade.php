<!DOCTYPE html>
{{--
    Page de checkout — plateforme de vente de produits agricoles
    Paiement via FedaPay (redirection sécurisée).

    NOTE D'INTÉGRATION :
    Ce fichier est autonome (balises <html> complètes) pour pouvoir être testé
    immédiatement. Si vous avez déjà un layout (resources/views/layouts/app.blade.php),
    remplacez le <head> par @extends('layouts.app') et placez le contenu du <body>
    dans @section('content').
--}}
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finaliser ma commande — Paiement sécurisé</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg: #F2EEE2;
            --surface: #FFFFFF;
            --ink: #232017;
            --leaf: #2F4A33;
            --leaf-dark: #213424;
            --ochre: #C8862B;
            --clay: #B6492F;
            --line: #D9D0B8;
        }
        body{ background: var(--bg); color: var(--ink); font-family:'Inter', sans-serif; }
        .font-display{ font-family:'Space Grotesk', sans-serif; }
        .font-mono{ font-family:'IBM Plex Mono', monospace; }

        /* Bord "ticket déchiré" en haut du récapitulatif de commande */
        .ticket{ position: relative; background: var(--surface); }
        .ticket::before{
            content:""; position:absolute; top:-1px; left:0; right:0; height:14px;
            background-image:
                linear-gradient(135deg, var(--bg) 50%, transparent 50%),
                linear-gradient(225deg, var(--bg) 50%, transparent 50%);
            background-size: 18px 18px;
            background-position: 0 0, 9px 0;
            background-repeat: repeat-x;
        }

        /* Tampon "paiement sécurisé" */
        .stamp{
            width: 104px; height: 104px; border-radius: 50%;
            border: 2px dashed var(--ochre); color: var(--ochre);
            display:flex; align-items:center; justify-content:center; text-align:center;
            transform: rotate(-9deg); padding: 8px; flex-shrink:0;
        }

        .field{
            width:100%; border:1px solid var(--line); background:#fff; border-radius:0.5rem;
            padding:0.65rem 0.85rem; font-size:0.95rem; color:var(--ink);
            transition: border-color .15s, box-shadow .15s;
        }
        .field:focus{ outline:none; border-color:var(--leaf); box-shadow:0 0 0 3px rgba(47,74,51,0.15); }
        .field-error{ border-color: var(--clay) !important; }

        .leader-row{
            display:flex; align-items:baseline; gap:0.5rem;
        }
        .leader-row .dots{ flex:1; border-bottom:1px dotted var(--line); margin-bottom:4px; }

        @media (prefers-reduced-motion: no-preference){
            .pay-btn{ transition: transform .12s ease, box-shadow .12s ease; }
            .pay-btn:hover{ transform: translateY(-1px); }
        }
    </style>
</head>
<body class="min-h-screen">

    {{-- En-tête / fil d'étapes --}}
    <header class="border-b" style="border-color: var(--line);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="font-display font-bold text-lg" style="color:var(--leaf-dark);">
                🌾 AgroMarché
            </a>
            <ol class="hidden sm:flex items-center gap-2 text-sm font-medium" style="color:#8a8270;">
                <li class="flex items-center gap-2">
                    <span>Panier</span>
                    <span>→</span>
                </li>
                <li class="flex items-center gap-2" style="color:var(--leaf-dark);">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:var(--leaf);">2</span>
                    <span>Livraison &amp; paiement</span>
                </li>
            </ol>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        @if (session('error'))
            <div class="mb-6 rounded-lg border px-4 py-3 text-sm" style="background:#FBEAE3; border-color:var(--clay); color:#7a2f1a;">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1.4fr_1fr] gap-8 lg:gap-10 items-start">

            {{-- ============ COLONNE GAUCHE : FORMULAIRE ============ --}}
            <section>
                <h1 class="font-display text-2xl sm:text-3xl font-bold mb-1" style="color:var(--leaf-dark);">
                    Finaliser ma commande
                </h1>
                <p class="text-sm mb-8" style="color:#6f6857;">
                    Renseignez vos informations de livraison, vous serez ensuite redirigé vers FedaPay pour régler en toute sécurité.
                </p>
                @php
                    $livraison = 1500;
                    $subtotal = $cart->items->sum(function ($item) {
                        return $item->quantite * $item->product->prix;
                    });
                    $total = $subtotal + $livraison;
                @endphp
                <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                    @csrf

                    {{-- Informations de livraison --}}
                    <div class="bg-white rounded-xl border p-5 sm:p-6 mb-6" style="border-color: var(--line);">
                        <h2 class="font-display font-bold text-sm uppercase tracking-wide mb-4" style="color:var(--leaf-dark);">
                            Informations de livraison
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="firstname" class="block text-sm font-medium mb-1.5">Prénom</label>
                                <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                       class="field @error('firstname') field-error @enderror" required>
                                @error('firstname')
                                    <p class="text-xs mt-1" style="color:var(--clay);">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="lastname" class="block text-sm font-medium mb-1.5">Nom</label>
                                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                                       class="field @error('lastname') field-error @enderror" required>
                                @error('lastname')
                                    <p class="text-xs mt-1" style="color:var(--clay);">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium mb-1.5">Téléphone (Mobile Money)</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+229 90 00 00 00"
                                       class="field @error('phone') field-error @enderror" required>
                                @error('phone')
                                    <p class="text-xs mt-1" style="color:var(--clay);">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium mb-1.5">E-mail</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       class="field @error('email') field-error @enderror" required>
                                @error('email')
                                    <p class="text-xs mt-1" style="color:var(--clay);">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium mb-1.5">Adresse de livraison</label>
                                <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Quartier, rue, point de repère…"
                                       class="field @error('address') field-error @enderror" required>
                                @error('address')
                                    <p class="text-xs mt-1" style="color:var(--clay);">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium mb-1.5">Ville / Commune</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}"
                                       class="field @error('city') field-error @enderror" required>
                                @error('city')
                                    <p class="text-xs mt-1" style="color:var(--clay);">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="notes" class="block text-sm font-medium mb-1.5">Instructions de livraison <span class="font-normal" style="color:#9a9382;">(optionnel)</span></label>
                                <textarea id="notes" name="notes" rows="2"
                                          class="field @error('notes') field-error @enderror">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Mode de paiement --}}
                    <div class="bg-white rounded-xl border p-5 sm:p-6 mb-6" style="border-color: var(--line);">
                        <h2 class="font-display font-bold text-sm uppercase tracking-wide mb-4" style="color:var(--leaf-dark);">
                            Mode de paiement
                        </h2>

                        <div class="flex items-start gap-4 rounded-lg p-4" style="background:#F7F4EA; border:1px solid var(--line);">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-display font-bold text-white shrink-0" style="background:var(--leaf);">
                                F
                            </div>
                            <div class="text-sm">
                                <p class="font-semibold mb-0.5">Paiement sécurisé via FedaPay</p>
                                <p style="color:#6f6857;">MTN Mobile Money, Moov Money ou carte bancaire. Vous choisirez votre moyen de paiement sur la page sécurisée FedaPay après avoir cliqué sur « Payer maintenant ».</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="pay-btn"
                            class="pay-btn w-full font-display font-bold text-white rounded-xl py-3.5 text-base shadow-sm"
                            style="background:var(--leaf);">
                        Payer {{ number_format($total, 0, ',', ' ') }} FCFA avec FedaPay
                    </button>
                    <p class="text-xs text-center mt-3" style="color:#9a9382;">
                        En continuant, vous acceptez d'être redirigé vers la plateforme de paiement FedaPay.
                    </p>
                </form>
            </section>

            {{-- ============ COLONNE DROITE : RÉCAPITULATIF (bon de commande) ============ --}}
            <aside class="lg:sticky lg:top-8">
                <div class="ticket rounded-xl border overflow-hidden" style="border-color: var(--line);">
                    <div class="p-5 sm:p-6 pt-7">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="font-display font-bold text-sm uppercase tracking-wide" style="color:var(--leaf-dark);">
                                Bon de commande
                            </h2>
                            <a href="{{ route('panier') }}" class="text-xs font-medium underline" style="color:#6f6857;">
                                Modifier
                            </a>
                        </div>

                        <ul class="space-y-3 mb-5">
                            @foreach ($cart->items as $item)
                                <li class="flex items-start gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-cover bg-center shrink-0" style="background-color:#EFE9D6; background-image:url('{{ $item->product->image ?? '' }}');"></div>
                                    <div class="flex-1">
                                        <div class="leader-row">
                                            <span class="text-sm font-medium">{{ $item->product->nom}}</span>
                                            <span class="dots"></span>
                                            <span class="font-mono text-sm">{{ number_format($item->product->prix * $item->quantite, 0, ',', ' ') }}</span>
                                        </div>
                                        <p class="text-xs" style="color:#9a9382;">Qté : {{ $item->quantite }} × {{ number_format($item->product->prix, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="space-y-2 pt-4 border-t" style="border-color: var(--line);">
                            <div class="leader-row text-sm" style="color:#6f6857;">
                                <span>Sous-total</span>
                                <span class="dots"></span>
                                <span class="font-mono">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="leader-row text-sm" style="color:#6f6857;">
                                <span>Livraison</span>
                                <span class="dots"></span>
                                <span class="font-mono">
                                    {{ $livraison > 0 ? number_format($livraison, 0, ',', ' ') . ' FCFA' : 'Offerte' }}
                                </span>
                            </div>
                            <div class="leader-row pt-2 mt-1 border-t" style="border-color: var(--line);">
                                <span class="font-display font-bold">Total</span>
                                <span class="dots"></span>
                                <span class="font-mono font-bold text-lg" style="color:var(--leaf-dark);">
                                    {{ number_format($total, 0, ',', ' ') }} FCFA
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 px-5 sm:px-6 py-5" style="background:#F7F4EA; border-top:1px dashed var(--line);">
                        <div class="stamp">
                            <span class="font-display text-[0.6rem] font-bold uppercase leading-tight">
                                Paiement<br>Sécurisé<br>FedaPay
                            </span>
                        </div>
                        <p class="text-xs leading-relaxed" style="color:#6f6857;">
                            Vos données de paiement ne sont jamais stockées sur notre plateforme : tout est géré directement par FedaPay.
                        </p>
                    </div>
                </div>
            </aside>

        </div>
    </main>

    <script>
        // Empêche le double-clic / double-soumission pendant la redirection vers FedaPay
        document.getElementById('checkout-form').addEventListener('submit', function () {
            var btn = document.getElementById('pay-btn');
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.innerText = 'Redirection vers FedaPay…';
        });
    </script>
</body>
</html>