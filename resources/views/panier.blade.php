<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier & Paiement - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --g: #1A6B3C;
            --gd: #124d2b;
            --gl: #eef5f1;
            --o: #C17F3B;
            --bg: #F3F4F6;
            --t: #1F2937;
            --tl: #6B7280;
            --w: #FFF;
            --r: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--t);
            padding-bottom: 120px;
        }

        .h {
            background: var(--w);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .bb {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            text-decoration: none;
            color: var(--t);
        }

        .ttl {
            font-weight: 700;
            font-size: 1.1rem;
            flex: 1;
        }

        .c {
            max-width: 600px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .it {
            background: var(--w);
            border-radius: var(--r);
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
        }

        .it:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
        }

        .ii {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            background: #e5e7eb;
            flex-shrink: 0;
        }

        .inf {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .inm {
            font-weight: 700;
            font-size: 1rem;
        }

        .ipr {
            font-size: 0.85rem;
            color: var(--tl);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .ib {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }

        .ip {
            font-weight: 800;
            color: var(--g);
            font-size: 1.1rem;
        }

        .qty {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--bg);
            border-radius: 8px;
            padding: 0.25rem;
        }

        .qb {
            width: 32px;
            height: 32px;
            border: none;
            background: var(--w);
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .qb:hover {
            background: var(--gl);
            color: var(--g);
        }

        .qv {
            font-size: 0.95rem;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
        }

        .st {
            font-size: 1rem;
            font-weight: 700;
            margin: 2rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .po {
            background: var(--w);
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .po:hover {
            border-color: var(--gl);
        }

        .po.sel {
            border-color: var(--g);
            background: var(--gl);
            box-shadow: 0 0 0 3px rgba(26, 107, 60, 0.1);
        }

        .rd {
            width: 22px;
            height: 22px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .po.sel .rd {
            border-color: var(--g);
            background: var(--g);
            box-shadow: inset 0 0 0 3px white;
        }

        .pl {
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sm {
            background: var(--w);
            border-radius: var(--r);
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .rw {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            color: var(--tl);
        }

        .rw.tot {
            border-top: 1px dashed #e5e7eb;
            padding-top: 1rem;
            margin-top: 1rem;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--t);
        }

        .rw.tot span:last-child {
            color: var(--g);
            font-size: 1.5rem;
        }

        .sb {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.25rem 1.5rem;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            z-index: 100;
        }

        .bp {
            flex: 1;
            max-width: 300px;
            padding: 1rem;
            background: var(--g);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s;
            box-shadow: 0 4px 14px rgba(26, 107, 60, 0.3);
        }

        .bp:hover {
            background: var(--gd);
            transform: translateY(-2px);
        }

        .bp:disabled {
            background: #d1d5db;
            box-shadow: none;
            transform: none;
            cursor: not-allowed;
        }

        .upd{
            display: flex;
            justify-content: space-between;
        }

        .upd > input{
            width: 50px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <header class="h">
        <a href="{{ url('/catalogue') }}" class="bb"><i class="ph ph-arrow-left"></i></a>
        <div class="ttl">Mon Panier ({{ $items->count() }} articles)</div>
    </header>

    <div class="c">
        @php
            $livraison = 1500;
            $sousTotal = $items->sum(function ($item) {
                return $item->quantite * $item->product->prix;
            });
            $total = $sousTotal + $livraison;
        @endphp
        @if($items->count() == 0)
        <div class="it" style="text-align: center;">
            <p style="text-align: center !important;">Panier vide</p>
        </div>
        @else
        @foreach($items as $item)
        <div class="it">
            <img src="{{ $item->product->image }}" alt="{{ $item->product->nom }}" class="ii">
            <div class="inf">

                <div>
                    <div class="inm">{{ $item->product->nom }}</div>
                    <div class="ipr"><i class="ph ph-tag"></i> {{ $item->product->category->nom }}</div>
                </div>
                <div class="ib">
                    <div class="ip" id="price{{ $item->id }}">{{ number_format($item->product->prix * $item->quantite, 0, ',', ' ') }} F</div>
                    <form action="{{ route('panier.supprimer', $item->id) }}" method="POST"
                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit du panier ?');"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-del">
                            <i class="ph ph-trash"></i>
                        </button>
                    </form>
                        <form action="{{ route('panier.mettreAJour', $item->id) }}" method="POST" class="upd">
                            @csrf
                            @method('PUT')

                            <input class="qty" type="number"
                                name="quantite"
                                value="{{ $item->quantite }}"
                                min="1">

                            <button class="qty" style="background-color: yellow; padding: 7px;" type="submit">
                                Mettre à jour
                            </button>
                        </form>
                </div>
            </div>
        </div>
        @endforeach
        
        <div class="sm">
            <div class="rw"><span>Sous-total</span><span id="sub">{{ number_format($sousTotal, 0, ',', ' ') }} FCFA</span></div>
            <div class="rw"><span>Frais de livraison</span><span>{{ number_format($livraison, 0, ',', ' ') }} FCFA</span></div>
            <div class="rw tot"><span>Total à payer</span><span id="tot">{{ number_format($total, 0, ',', ' ') }} FCFA</span></div>
        </div>
        @endif
        <div class="sb">
            <div style="display:flex; flex-direction:column;">
                <span style="font-size:0.8rem; color:var(--tl); font-weight:500;">Total</span>
                <span style="font-size:1.5rem; font-weight:800; color:var(--g);" id="sbTot">{{ number_format($total, 0, ',', ' ') }}  F</span>
            </div>
            @if ($cart && $items->isNotEmpty())
                <a class="bp" id="payBtn" href="{{ route('checkout') }}">
                    <i class="ph-fill ph-lock-key"></i> Payer maintenant
                </a>
            @else
                <span class="bp" aria-disabled="true" style="opacity:.5; pointer-events:none;">
                    <i class="ph-fill ph-lock-key"></i> Panier vide
                </span>
            @endif
        </div>
    </div>


    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</body>

</html>