<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Produits - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --g: #1A6B3C;
            --gd: #124d2b;
            --gl: #eef5f1;
            --o: #C17F3B;
            --ol: #fdf6ed;
            --bg: #F3F4F6;
            --t: #1F2937;
            --tl: #6B7280;
            --w: #FFF;
            --sh: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --r: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: var(--bg);
            color: var(--t);
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background: var(--w);
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 50;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sh {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--g);
            text-decoration: none;
        }

        .logo span {
            color: var(--o);
        }

        .nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .ni {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: var(--tl);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .ni:hover,
        .ni.act {
            background: var(--gl);
            color: var(--g);
            border-left-color: var(--g);
        }

        .sf {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .ui {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .av {
            width: 40px;
            height: 40px;
            background: var(--g);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* --- MAIN CONTENT --- */
        .mc {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            transition: margin 0.3s;
        }

        .mh {
            display: none;
            padding: 1rem;
            background: var(--w);
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        /* --- ANIMATIONS --- */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim {
            animation: fadeUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .d1 {
            animation-delay: 0.1s;
        }

        .d2 {
            animation-delay: 0.2s;
        }

        .d3 {
            animation-delay: 0.3s;
        }

        /* --- PAGE HEADER & FILTERS --- */
        .ph {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pt {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .filters {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
        }

        .filters::-webkit-scrollbar {
            display: none;
        }

        .f-chip {
            padding: 0.5rem 1rem;
            background: var(--w);
            border: 1.5px solid #e5e7eb;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--t);
        }

        .f-chip:hover {
            border-color: var(--g);
            color: var(--g);
        }

        .f-chip.act {
            background: var(--g);
            color: white;
            border-color: var(--g);
        }

        /* --- PRODUCT GRID --- */
        .pg {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .pc {
            background: var(--w);
            border-radius: var(--r);
            overflow: hidden;
            box-shadow: var(--sh);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
        }

        .pc:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
        }

        .pi {
            height: 180px;
            background: #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .pi img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .pc:hover .pi img {
            transform: scale(1.08);
        }

        .st-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.3rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
        }

        .st-active {
            background: rgba(26, 107, 60, 0.9);
            color: white;
        }

        .st-out {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .st-arch {
            background: rgba(107, 114, 128, 0.9);
            color: white;
        }

        .pif {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .pcat {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--o);
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .pn {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            color: var(--t);
        }

        .ploc {
            font-size: 0.85rem;
            color: var(--tl);
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin-bottom: 1rem;
        }

        .prw {
            display: flex;
            justify-content: left;
            align-items: baseline;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .pp {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--g);
        }

        .pu {
            font-size: 0.9rem;
            color: var(--tl);
            font-weight: 500;
        }

        .pstock {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--t);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .pstock.low {
            color: var(--o);
        }

        .pact {
            display: flex;
            gap: 0.5rem;
            margin-top: auto;
        }

        .ab {
            flex: 1;
            padding: 0.6rem;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .abe {
            background: #e0e7ff;
            color: #3730a3;
        }

        .abe:hover {
            background: #c7d2fe;
        }

        .abd {
            background: #fee2e2;
            color: #b91c1c;
        }

        .abd:hover {
            background: #fecaca;
        }

        /* --- FAB (Floating Action Button) --- */
        .fab {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            background: var(--g);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 16px rgba(26, 107, 60, 0.3);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            z-index: 40;
        }

        .fab-tooltip {
            position: absolute;
            right: 70px;
            background: var(--t);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .fab:hover .fab-tooltip {
            opacity: 1;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .mc {
                margin-left: 0;
                padding: 1rem;
            }

            .mh {
                display: flex;
            }

            .pg {
                grid-template-columns: 1fr;
            }

            .ph {
                flex-direction: column;
                align-items: flex-start;
            }

            .fab {
                bottom: 1.5rem;
                right: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    @include('producteur.layout')

    <!-- MAIN CONTENT -->
    <main class="mc">
        <header class="mh">
            <button style="background: none; border: none; font-size: 1.5rem; cursor: pointer;" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="ph ph-list"></i>
            </button>
            <span style="font-weight: 700;">Mes Produits</span>
            <button style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                <i class="ph ph-bell"></i>
            </button>
        </header>

        <div class="ph anim">
            <div>
                <h1 class="pt">Gestion du Catalogue</h1>
                <p style="color: var(--tl); margin-top: 0.25rem;">Gérez vos annonces, vos stocks et vos prix en temps réel.</p>
            </div>
            <a href="{{ route('producteur.creer-annonce') }}" class="fab" style="position: static; width: auto; height: auto; padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 0.95rem; font-weight: 600; box-shadow: 0 4px 12px rgba(26, 107, 60, 0.2);">
                </i> Nouveau produit
            </a>
        </div>

        <!-- Filtres -->
        <div class="filters anim d1">
    <button class="f-chip act" onclick="filterProducts('all', this)">
        Tous ({{ $products->count() }})
    </button>
    <button class="f-chip" onclick="filterProducts('en_attente', this)">
        En attente ({{ $products->where('statut', 'en_attente')->count() }})
    </button>
    <button class="f-chip" onclick="filterProducts('valide', this)">
        En ligne ({{ $products->where('statut', 'valide')->count() }})
    </button>
    <button class="f-chip" onclick="filterProducts('rupture', this)">
        Rupture de stock ({{ $products->where('stock', 0)->count() }})
    </button>
    <button class="f-chip" onclick="filterProducts('rejete', this)">
        Archivés ({{ $products->where('statut', 'rejete')->count() }})
    </button>
</div>

        <!-- Grille de Produits -->
        @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
        @endif
        <div class="pg" id="productGrid">
            <!-- Produit 1 : En ligne -->

            @if($products->isEmpty())
            <p style="color: var(--tl); font-size: 1rem; margin-top: 2rem;">Vous n'avez pas encore publié de produits. Cliquez sur "Nouveau produit" pour commencer.</p>
            @endif
            @foreach($products as $product)
            <div class="pc anim d2" data-status="{{ $product->statut }}" data-stock="{{ $product->stock == 0 ? 'rupture' : 'disponible' }}">
               
              
                <div class="pi">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nom }}">
                    @if($product->stock == 0)
                    <span class="st-badge st-out">Rupture de stock</span>
                    @elseif($product->statut === 'valide')
                    <span class="st-badge st-active">En ligne</span>
                    @elseif($product->statut === 'en_attente')
                    <span class="st-badge st-pending">En attente</span>
                    @elseif($product->statut === 'rejete')
                    <span class="st-badge st-arch">Archivé</span>
                    @endif
                </div>
                <div class="pif">
                    <div class="pcat">{{ $product->category->name }}</div>
                    <div class="pn">{{ $product->nom }}</div>
                    <div class="ploc"><i class="ph ph-map-pin"></i> {{ auth()->user()->localisation }}</div>
                    <div class="prw">
                        <div class="pp">{{ number_format($product->prix, 0, ',', ' ') }} FCFA</div>
                        <span class="pu">/{{ $product->unite }}</span>
                    </div>
                    <div class="pstock {{ $product->stock <= 5 ? 'low' : '' }}">
                        <i class="ph ph-box"></i> {{ $product->stock }} disponible(s)
                    </div>
                    <div class="pact">
                        <a href="{{ route('editer-annonce', $product->id) }}" class="ab abe"><i class="ph ph-pencil"></i> Éditer</a>
                        <form action="{{ route('supprimer-annonce', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ab abd" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                <i class="ph ph-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Floating Action Button (Mobile) -->
    <a href="{{ route('producteur.creer-annonce') }}" class="fab">
        <i class="ph ph-plus"></i>
        <span class="fab-tooltip">Nouveau produit</span>
    </a>

    <script>
        // 1. Animation au scroll (Intersection Observer)
        const obs = new IntersectionObserver(e => {
            e.forEach(en => {
                if (en.isIntersecting) en.target.style.animationPlayState = 'running';
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.anim').forEach(el => {
            el.style.opacity = '0';
            obs.observe(el);
        });

        // 2. Filtrage des produits
    function filterProducts(filter, btn) {
    document.querySelectorAll('.f-chip').forEach(c => c.classList.remove('act'));
    btn.classList.add('act');

    const cards = document.querySelectorAll('.pc');
    let visibleCount = 0;

    cards.forEach(card => {
        const status = card.getAttribute('data-status');
        const stock = card.getAttribute('data-stock');
        let show = false;

        switch (filter) {
            case 'all':
                show = true;
                break;
            case 'en_attente':
                show = status === 'en_attente' && stock !== 'rupture';
                break;
            case 'valide':
                show = status === 'valide' && stock !== 'rupture';
                break;
            case 'rupture':
                show = stock === 'rupture';
                break;
            case 'rejete':
                show = status === 'rejete';
                break;
        }

        if (show) {
            card.style.display = 'flex';
            card.style.animation = 'none';
            card.offsetHeight; // reflow
            card.style.animation = 'fadeUp 0.4s ease-out forwards';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('emptyFilterMsg').style.display = visibleCount === 0 ? 'block' : 'none';
}
    </script>
</body>

</html>