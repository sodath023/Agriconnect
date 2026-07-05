<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Produit - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
        .h { background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); padding: 1rem 1.5rem; display: flex; align-items: center; gap: 1rem; position: sticky; top: 0; z-index: 100; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .btn-i { background: var(--w); border: 1px solid #e5e7eb; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; cursor: pointer; color: var(--t); transition: all 0.2s; text-decoration: none; }
        .btn-i:hover { background: var(--gl); border-color: var(--g); color: var(--g); }
        
        .c { max-width: 900px; margin: 0 auto; background: var(--w); min-height: 100vh; }
        .gal { position: relative; width: 100%; height: 350px; background: #e5e7eb; overflow: hidden; }
        .gal img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .gal:hover img { transform: scale(1.05); }
        .badge { position: absolute; top: 1rem; left: 1rem; background: rgba(255,255,255,0.95); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 700; color: var(--g); display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); backdrop-filter: blur(4px); }

        .dt { padding: 1.5rem; }
        .cat { color: var(--o); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .ttl { font-size: 1.75rem; font-weight: 800; color: var(--t); margin-bottom: 0.75rem; line-height: 1.2; }
        .pr-row { display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #f3f4f6; }
        .pr { font-size: 2rem; font-weight: 800; color: var(--g); }
        .un { font-size: 1rem; color: var(--tl); font-weight: 500; }

        .pc { background: var(--gl); border-radius: var(--r); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; text-decoration: none; color: var(--t); transition: transform 0.2s, box-shadow 0.2s; border: 1px solid transparent; }
        .pc:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-color: var(--g); }
        .av { width: 56px; height: 56px; background: var(--g); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; flex-shrink: 0; }
        .pi h4 { font-weight: 700; font-size: 1.05rem; display: flex; align-items: center; gap: 0.4rem; }
        .pi p { font-size: 0.9rem; color: var(--tl); display: flex; align-items: center; gap: 0.3rem; margin-top: 0.25rem; }
        .vf { color: var(--g); font-size: 1rem; }

        .desc-t { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; }
        .desc { font-size: 1rem; color: var(--tl); line-height: 1.7; margin-bottom: 2rem; }
        
        .certs { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 2rem; }
        .cert { background: var(--ol); color: #92571A; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.4rem; }

        .sb { position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 1rem 1.5rem; box-shadow: 0 -4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: space-between; gap: 1rem; z-index: 100; }
        .tot { display: flex; flex-direction: column; }
        .tl { font-size: 0.8rem; color: var(--tl); font-weight: 500; }
        .tv { font-size: 1.5rem; font-weight: 800; color: var(--g); }
        .ba { flex: 1; max-width: 300px; padding: 1rem; background: var(--g); border: none; border-radius: 12px; font-weight: 700; font-size: 1.05rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s ease; box-shadow: 0 4px 14px rgba(26, 107, 60, 0.3); }
        .ba:hover { background: var(--gd); transform: translateY(-2px); }
        .ba:active { transform: scale(0.96); }

        @media(min-width: 768px) {
            .c { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; padding: 2rem; background: var(--bg); min-height: auto; }
            .gal { height: 450px; border-radius: var(--r); position: sticky; top: 100px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
            .dt { background: var(--w); padding: 2.5rem; border-radius: var(--r); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
            .sb { position: static; box-shadow: none; padding: 2rem 0 0 0; border-top: 1px solid #e5e7eb; margin-top: 2rem; backdrop-filter: none; background: transparent; }
            body { padding-bottom: 0; }
        }
    
    </style>
</head>
<body>
    @include('layouts.nav')
    <div class="c">
        
        <div class="dt">
            <header class="h" style="position:static; box-shadow:none; padding:0 0 1.5rem 0; background:transparent;">
                <a href="{{ route('home') }}" class="btn-i"><i class="ph ph-arrow-left"></i></a>
                <span style="font-weight:700; flex:1;">Détail du produit</span>
                <a href="{{ route('panier') }}" class="btn-i"><i class="ph ph-shopping-cart"></i></a>
            </header>
            <div class="cat">{{ $produit->category->name }}</div>
            <h1 class="ttl">{{ $produit->nom }}</h1>
            <div class="pr-row"><span class="pr">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span><span class="un">/ {{ $produit->unite }}</span></div>

            <a href="{{ route('producteur.public') }}" class="pc">
                <div class="av">{{ strtoupper(substr($produit->user->name, 0, 2)) }}</div>
                <div class="pi">
                    <h4>{{ $produit->user->name }} <i class="ph-fill ph-seal-check vf"></i></h4>
                    <p><i class="ph-fill ph-map-pin"></i> {{ $produit->producer->localisation ?? 'Localisation non spécifiée' }} • {{ number_format($produit->producer->noteGlobal ?? 4.8, 1) }}/5</p>
                </div>
                <i class="ph ph-caret-right" style="color: var(--tl); font-size: 1.25rem;"></i>
            </a>

            <h3 class="desc-t">Description du produit</h3>
            <p class="desc">{{ $produit->description }}</p>

            <div class="certs">
                <span class="cert"><i class="ph-fill ph-plant"></i> Agriculture locale</span>
                <span class="cert"><i class="ph-fill ph-clock"></i> Récolte < 48h</span>
                <span class="cert"><i class="ph-fill ph-seal-check"></i> Qualité contrôlée</span>
            </div>

            <div class="sb">
                <div class="tot"><span class="tl">Prix unitaire</span><span class="tv" id="totalPrice">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span></div>
                <button class="ba" onclick="document.getElementById('addToCartForm').submit()" type="button"><i class="ph ph-shopping-cart"></i> Ajouter au panier</button>
            </div>
            
            <form id="addToCartForm" action="{{ route('panier.ajouter') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $produit->id }}">
                <input type="hidden" name="quantite" value="1">
            </form>
        </div>
        <div class="gal">
            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}">
            <div class="badge"><i class="ph-fill ph-check-circle"></i> En stock ({{ $produit->stock }} {{ $produit->unite }})</div>
        </div>

    </div>
</body>
</html>