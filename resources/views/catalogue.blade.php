<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --g: #1A6B3C; --gd: #124d2b; --gl: #eef5f1; --o: #C17F3B; --bg: #F3F4F6; --t: #1F2937; --tl: #6B7280; --w: #FFF; --r: 16px; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--t); padding-bottom: 2rem; }
        
        .h { background: var(--w); padding: 1rem 1.5rem; position: scroll; z-index: 100; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1rem; }
        .logo { font-size: 1.2rem; font-weight: 800; color: var(--g); text-decoration: none; white-space: nowrap; } .logo span { color: var(--o); }
        .srch { flex: 1; position: relative; }
        .srch input { width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1.5px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; background: #F9FAFB; transition: all 0.2s; }
        .srch input:focus { outline: none; border-color: var(--g); background: var(--w); box-shadow: 0 0 0 3px var(--gl); }
        .srch i { position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--tl); font-size: 1.2rem; }
        .ci { position: relative; font-size: 1.5rem; color: var(--t); text-decoration: none; padding: 0.5rem; border-radius: 50%; transition: background 0.2s; }
        .ci:hover { background: var(--gl); color: var(--g); }
        .bdg { position: absolute; top: 0; right: 0; background: var(--o); color: white; font-size: 0.7rem; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; border: 2px solid var(--w); }

        .c { max-width: 1200px; margin: 0 auto; padding: 1.5rem; }
        .flt { display: flex; gap: 0.75rem; overflow-x: auto; padding-bottom: 1rem; margin-bottom: 1rem; scrollbar-width: none; }
        .flt::-webkit-scrollbar { display: none; }
        .chip { padding: 0.6rem 1.25rem; background: var(--w); border: 1.5px solid #e5e7eb; border-radius: 24px; font-size: 0.9rem; font-weight: 600; white-space: nowrap; cursor: pointer; text-decoration: none; color: var(--t); transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem; }
        .chip:hover { border-color: var(--g); color: var(--g); }
        .chip.act { background: var(--g); color: white; border-color: var(--g); box-shadow: 0 4px 12px rgba(26, 107, 60, 0.2); }

        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .pc { background: var(--w); border-radius: var(--r); overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.03); text-decoration: none; color: var(--t); display: block; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.03); }
        .pc:hover { transform: translateY(-6px); box-shadow: 0 12px 24px -8px rgba(0,0,0,0.15); }
        .ib { height: 200px; background: #e5e7eb; position: relative; overflow: hidden; }
        .ib img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .pc:hover .ib img { transform: scale(1.08); }
        .stock { position: absolute; top: 1rem; left: 1rem; background: rgba(255,255,255,0.95); padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.8rem; font-weight: 700; color: var(--g); display: flex; align-items: center; gap: 0.3rem; backdrop-filter: blur(4px); }
        
        .info { padding: 1.25rem; }
        .cat { font-size: 0.75rem; text-transform: uppercase; color: var(--o); font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.4rem; }
        .nm { font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; line-height: 1.3; }
        .pr-row { display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 1rem; }
        .pr { color: var(--g); font-weight: 800; font-size: 1.25rem; }
        .un { font-size: 0.9rem; color: var(--tl); font-weight: 500; }
        .pd { display: flex; align-items: center; justify-content: space-between; padding-top: 1rem; border-top: 1px solid #f3f4f6; }
        .prod { font-size: 0.85rem; color: var(--tl); display: flex; align-items: center; gap: 0.4rem; }
        .vf { color: var(--g); font-size: 1rem; }
        .add-btn { width: 36px; height: 36px; border-radius: 50%; background: var(--gl); color: var(--g); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 1.2rem; }
        .add-btn:hover { background: var(--g); color: white; transform: scale(1.1); }
    </style>
</head>
<body>
    @include('layouts.nav')

    <div class="c">
        <div class="flt">
            <a href="{{ url('/catalogue') }}" class="chip {{ request('category') ? '' : 'act' }}"><i class="ph ph-squares-four"></i> Tout</a>
            @foreach($categories as $category)
                <a href="{{ url('/catalogue') }}?category={{ $category->slug }}" class="chip {{ request('category') === $category->slug ? 'act' : '' }}">
                    {{ $category->icon ?? '🏷️' }} {{ $category->name }}
                </a>
            @endforeach
            
        <div class="srch">
            <i class="ph ph-magnifying-glass"></i>
            <input id="searchInput" type="text" placeholder="Rechercher (ex: Igname, Tomate)..." autocomplete="off" aria-label="Rechercher un produit">
        </div> 
        </div>

        <div class="grid">
            @foreach($produits as $produit)
                    <a href="{{ route('produit', $produit->id) }}" class="pc" data-search="{{ strtolower($produit->nom . ' ' . $produit->category->name . ' ' . $produit->user->name) }}">
                    <div class="ib">
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}">
                        <div class="stock"><i class="ph ph-box"></i> {{ $produit->stock }} en stock</div>
                    </div>
                    <div class="info">
                        <div class="cat">{{ $produit->category->name }}</div>
                        <div class="nm">{{ $produit->nom }}</div>
                        <div class="pr-row">
                            <span class="pr">{{ number_format($produit->prix, 0, ',', ' ') }} F CFA</span>
                            <span class="un">/ {{ $produit->unite }}</span>
                        </div>
                        <div class="pd">
                            <button class="add-btn"><i class="ph ph-plus"></i></button>

                            <div class="prod"><i class="ph-fill ph-user"></i> {{ $produit->user->name }} • {{ number_format($produit->producer->noteGlobal ?? 4.8, 1) }}/5</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const cards = Array.from(document.querySelectorAll('.pc'));

            if (!searchInput || cards.length === 0) return;

            const normalize = (value) => value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');

            searchInput.addEventListener('input', function () {
                const term = normalize(this.value.trim());

                cards.forEach(card => {
                    const searchText = normalize(card.getAttribute('data-search') || '');
                    const visible = !term || searchText.includes(term);
                    card.style.display = visible ? '' : 'none';
                });
            });
        });
    </script>
</body>
</html>