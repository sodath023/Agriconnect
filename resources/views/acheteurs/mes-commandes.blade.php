<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        
        /* Sidebar */
        .sidebar{width:260px;background:var(--w);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s cubic-bezier(.4,0,.2,1)}
        .sh{padding:1.5rem;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:.75rem}
        .logo{font-size:1.25rem;font-weight:800;color:var(--g);text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}
        .ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:var(--tl);text-decoration:none;font-weight:500;transition:all .2s;border-left:3px solid transparent}
        .ni:hover,.ni.act{background:var(--gl);color:var(--g);border-left-color:var(--g)}
        .sf{padding:1.5rem;border-top:1px solid #e5e7eb}.ui{display:flex;align-items:center;gap:.75rem}.av{width:40px;height:40px;background:var(--g);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}
        
        /* Main Content */
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}
        .mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        
        /* Animations */
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}
        
        /* Page Header */
        .ph{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}
        .pt{font-size:1.5rem;font-weight:800}
        
        /* Tabs */
        .tabs{display:flex;gap:1rem;margin-bottom:1.5rem;border-bottom:2px solid #e5e7eb;padding-bottom:0}
        .tab{padding:.75rem 1.5rem;font-weight:600;color:var(--tl);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;transition:all .2s;background:none;border-top:none;border-left:none;border-right:none;font-size:1rem}
        .tab.act{color:var(--g);border-bottom-color:var(--g)}
        
        /* Order Cards */
        .cl{display:flex;flex-direction:column;gap:1rem}
        .oc{background:var(--w);border-radius:var(--r);padding:1.5rem;box-shadow:var(--sh);transition:all .3s;border-left:4px solid transparent}
        .oc:hover{transform:translateX(5px);box-shadow:0 10px 15px -3px rgba(0,0,0,0.1)}
        .oc.status-active{border-left-color:var(--o)}
        .oc.status-done{border-left-color:var(--g)}
        
        .och{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem}
        .oci{font-weight:800;font-size:1.1rem;color:var(--t)}
        .ocd{font-size:.85rem;color:var(--tl);margin-top:.25rem}
        
        .bdg{padding:.3rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;gap:.3rem}
        .bw{background:var(--ol);color:var(--o)}.bs{background:var(--gl);color:var(--g)}.bb{background:#dbeafe;color:#1e40af}
        
        .ocb{display:flex;justify-content:space-between;align-items:center;padding-top:1rem;border-top:1px solid #f3f4f6;flex-wrap:wrap;gap:1rem}
        .ocp{font-size:1.25rem;font-weight:800;color:var(--g)}
        .ocprod{font-size:.9rem;color:var(--tl);display:flex;align-items:center;gap:.4rem;margin-bottom:.25rem}
        
        .btn{padding:.6rem 1.2rem;border-radius:8px;font-size:.9rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:.5rem;text-decoration:none}
        .bp{background:var(--g);color:white}.bp:hover{background:var(--gd);transform:translateY(-2px)}
        .bo{background:transparent;border:1.5px solid #d1d5db;color:var(--t)}.bo:hover{background:#f9fafb}

        /* Responsive */
        @media(max-width:1024px){
            .sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}
            .mc{margin-left:0;padding:1rem}.mh{display:flex}
            .och{flex-direction:column;gap:.5rem}.ocb{flex-direction:column;align-items:flex-start}
            .btn{width:100%;justify-content:center}
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    @include('acheteurs.layout')

    <!-- MAIN CONTENT -->
    <main class="mc">
        <header class="mh">
            <button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button>
            <span style="font-weight:700">Mes Commandes</span>
            <button style="background:none;border:none;font-size:1.5rem;cursor:pointer"><i class="ph ph-bell"></i></button>
        </header>

        <div class="ph anim">
            <h1 class="pt">Historique de mes commandes</h1>
            <a href="{{ route('catalogue') }}" class="btn bp"><i class="ph ph-plus"></i> Nouvelle commande</a>
        </div>

        <!-- Tabs -->
        <div class="tabs anim d1">
            <button class="tab act" onclick="switchTab('active', this)">En cours ({{ $commandes->where('status', '!=', 'delivered')->where('status', '!=', 'cancelled')->where('status', '!=', 'failed')->count() }})</button>
            <button class="tab" onclick="switchTab('history', this)">Historique ({{ $commandes->whereIn('status', ['delivered', 'cancelled', 'failed'])->count() }})</button>
        </div>

        <!-- Liste En Cours -->
        <div id="tab-active" class="cl anim d2">
            @foreach($commandes as $commande)
            @if($commande->status !== 'delivered' && $commande->status !== 'cancelled' && $commande->status !== 'failed')
                <div class="oc status-active">
                    <div class="och">
                        <div>
                            <div class="oci">#{{ $commande->reference }}</div>
                            <div class="ocd" style="display: flex;"><i class="ph ph-calendar"></i> {{ $commande->created_at->format('d M, Y à H:i') }}</div>
                        </div>
                        <span class="bdg bw"  style="display: flex;">{{ ucfirst($commande->status) }}</span>
                    </div>
                    <div style="font-size:.9rem;margin-bottom:1rem;color:var(--t)">{{ $commande->lignecommandes->sum('quantity') }} kg de produits</div>
                    <div class="ocb">
                        <div class="ocp">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
                        <a href="{{ route('acheteur.detail-commandes', ['id' => $commande->id]) }}" class="btn "  style="display: flex;"><i class="ph ph-eye"></i></a>
                    </div>
                </div>
            @endif
            @endforeach
        </div>

        <!-- Liste Historique (Cachée par défaut) -->
        <div id="tab-history" class="cl" style="display:none">
            @foreach($commandes as $commande)
            @if($commande->status === 'delivered' || $commande->status === 'cancelled' || $commande->status === 'failed')
                <div class="oc status-done">
                    <div class="och">
                        <div>
                            <div class="oci">#{{ $commande->reference }}</div>
                            <div class="ocd" style="display: flex;"><i class="ph ph-calendar"></i> {{ $commande->created_at->format('d M, Y à H:i') }}</div>
                        </div>
                        <span class="bdg bs" style="display: flex;"><i class="ph ph-check-circle"></i> {{ ucfirst($commande->status) }}</span>
                    </div>
                    <div style="font-size:.9rem;margin-bottom:1rem;color:var(--t)">{{ $commande->lignecommandes->sum('quantity') }} kg de produits</div>
                    <div class="ocb">
                        <div class="ocp">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
                        <a href="{{ route('acheteur.detail-commandes', ['id' => $commande->id]) }}" class="btn "  style="display: flex;"><i class="ph ph-eye"></i></a>
                    </div>
                </div>
            @endif
            @endforeach
        </div>

        <!-- Liste Historique (Cachée par défaut) -->
        <div id="tab-history" class="cl" style="display:none">
            @foreach($commandes as $commande)
            @if($commande->status === 'delivered' || $commande->status === 'cancelled' || $commande->status === 'failed')
                <div class="oc status-done">
                    <div class="och">
                        <div>
                            <div class="oci">#{{ $commande->reference }}</div>
                            <div class="ocd" style="display: flex;"><i class="ph ph-calendar"></i> {{ $commande->created_at->format('d M, Y à H:i') }}</div>
                        </div>
                        <span class="bdg bs" style="display: flex;"><i class="ph ph-check-circle"></i> {{ ucfirst($commande->status) }}</span>
                    </div>
                    <div style="font-size:.9rem;margin-bottom:1rem;color:var(--t)">{{ $commande->lignecommandes->sum('quantity') }} kg de produits</div>
                    <div class="ocb">
                        <div class="ocp">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
                        <a href="{{ route('acheteur.detail-commandes', ['id' => $commande->id]) }}" class="btn "  style="display: flex;"><i class="ph ph-eye"></i></a>
                    </div>
                </div>
            @endif
            @endforeach
        </div>
    </main>

    <script>
        // Gestion des onglets
        function switchTab(tabId, btn) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('act'));
            btn.classList.add('act');
            
            document.getElementById('tab-active').style.display = tabId === 'active' ? 'flex' : 'none';
            document.getElementById('tab-history').style.display = tabId === 'history' ? 'flex' : 'none';
            
            // Réappliquer l'animation sur le contenu visible
            const visibleList = document.getElementById(tabId === 'active' ? 'tab-active' : 'tab-history');
            visibleList.classList.remove('anim', 'd2');
            void visibleList.offsetWidth; // Trigger reflow
            visibleList.classList.add('anim', 'd2');
        }

        // Animation au scroll (Intersection Observer)
        const obs = new IntersectionObserver(e => {
            e.forEach(en => { if (en.isIntersecting) en.target.style.animationPlayState = 'running' });
        }, { threshold: 0.1 });
        document.querySelectorAll('.anim').forEach(el => { el.style.opacity = '0'; obs.observe(el) });
    </script>
</body>
</html>