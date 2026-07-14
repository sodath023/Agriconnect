<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modération - Admin AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:#111827;color:white;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #374151}.logo{font-size:1.25rem;font-weight:800;color:white;text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:#9CA3AF;text-decoration:none;font-weight:500;transition:all .2s}.ni:hover,.ni.act{background:rgba(255,255,255,0.1);color:white;border-left:3px solid var(--o)}
        .sf{padding:1.5rem;border-top:1px solid #374151}.ui{display:flex;align-items:center;gap:.75rem}.av{width:40px;height:40px;background:#374151;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}.mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}
        .ph{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}.pt{font-size:1.5rem;font-weight:800}
        .tabs{display:flex;gap:1rem;margin-bottom:1.5rem;border-bottom:2px solid #e5e7eb;padding-bottom:0}
        .tab{padding:.75rem 1.5rem;font-weight:600;color:var(--tl);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;transition:all .2s;background:none;border-top:none;border-left:none;border-right:none;font-size:1rem}
        .tab.act{color:var(--g);border-bottom-color:var(--g)}
        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1.5rem}
        .card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);overflow:hidden;transition:all .3s;border-left:4px solid transparent}
        .card:hover{transform:translateY(-4px);box-shadow:0 10px 15px -3px rgba(0,0,0,0.1)}
        .card.flagged{border-left-color:#ef4444}
        .card.pending{border-left-color:var(--o)}
        .c-img{height:160px;background:#e5e7eb;position:relative}.c-img img{width:100%;height:100%;object-fit:cover}
        .c-badge{position:absolute;top:.75rem;right:.75rem;padding:.25rem .6rem;border-radius:6px;font-size:.75rem;font-weight:700;background:rgba(255,255,255,.9);backdrop-filter:blur(4px)}
        .c-body{padding:1.25rem}
        .c-cat{font-size:.75rem;text-transform:uppercase;color:var(--o);font-weight:700;margin-bottom:.25rem}
        .c-title{font-weight:700;font-size:1.05rem;margin-bottom:.5rem}
        .c-meta{font-size:.85rem;color:var(--tl);display:flex;align-items:center;gap:.4rem;margin-bottom:1rem}
        .c-price{font-size:1.1rem;font-weight:800;color:var(--g);margin-bottom:1rem}
        .c-actions{display:flex;gap:.75rem}
        .btn{flex:1;padding:.6rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:.4rem}
        .ba{background:var(--g);color:white}.ba:hover{background:var(--gd)}
        .br{background:#fee2e2;color:#b91c1c}.br:hover{background:#fecaca}
        .toast{position:fixed;bottom:20px;right:20px;background:var(--t);color:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,.2);display:flex;align-items:center;gap:.75rem;transform:translateY(100px);opacity:0;transition:all .4s cubic-bezier(.175,.885,.32,1.275);z-index:1000}.toast.show{transform:translateY(0);opacity:1}
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sh"><a href="{{ route('admin.moderation') }}" class="logo">Agri<span>Connect</span> <span style="font-size:.7rem;background:var(--o);padding:2px 6px;border-radius:4px;color:white;margin-left:5px">ADMIN</span></a></div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="ni"><i class="ph ph-squares-four"></i> Vue d'ensemble</a>
            <a href="{{ route('admin.utilisateurs') }}" class="ni"><i class="ph ph-users"></i> Utilisateurs & KYC</a>
            <a href="{{ route('admin.moderation') }}" class="ni act"><i class="ph ph-shield-warning"></i> Modération</a>
            <a href="{{ route('admin.parametres') }}" class="ni"><i class="ph ph-gear"></i> Paramètres</a>
        </nav>
        <div class="sf"><div class="ui"><div class="av">AD</div><div><div style="font-weight:600;font-size:.9rem">Administrateur</div><div style="font-size:.8rem;color:#9CA3AF">Support Technique</div></div></div></div>
    </aside>

    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Modération</span></header>
        
        <div class="ph anim">
            <div><h1 class="pt">Modération des Annonces</h1><p style="color:var(--tl);font-size:.9rem">Validez les nouvelles annonces ou traitez les signalements des utilisateurs.</p></div>
        </div>

        <div class="tabs anim d1">
            <button class="tab act" onclick="filterCards('pending', this)">En attente de validation ({{ $products->count() }})</button>
            <button class="tab" onclick="filterCards('flagged', this)">Signalements (0)</button>
        </div>
 
        <div class="grid" id="moderationGrid">
            @forelse($products as $product)
                <div class="card pending anim d2" id="prod-{{ $product->id }}" data-status="pending">
                    <div class="c-img">
                        @if(!empty($product->image))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nom }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#6B7280;background:#e5e7eb">Aucune image</div>
                        @endif
                        @if($product->statut === 'en_attente')
                            <div class="c-badge" style="background:#ef4444;color:white">En attente</div>
                        @endif
                    </div>
                    <div class="c-body">
                        <div class="c-cat">{{ $product->category?->name ?? 'Sans catégorie' }}</div>
                        <div class="c-title">{{ $product->nom }}</div>
                        <div class="c-meta"><i class="ph ph-user"></i> {{ $product->user?->name ?? 'Utilisateur inconnu' }} &middot; <i class="ph ph-clock"></i> {{ $product->created_at ? $product->created_at->diffForHumans() : 'Date inconnue' }}</div>
                        <div class="c-price">{{ number_format($product->prix ?? 0, 0, ',', ' ') }} FCFA</div>
                        <div class="c-actions">
                            <a href="{{ route('admin.moderation.valider-produit', ['id' => $product->id]) }}" class="btn ba" onclick="approveProd('prod-{{ $product->id }}')"><i class="ph ph-check-circle"></i> Valider</a>
                            <a href="{{ route('admin.moderation.rejeter-produit', ['id' => $product->id]) }}" class="btn br" onclick="rejectProd('prod-{{ $product->id }}')"><i class="ph ph-x-circle"></i> Rejeter</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card anim d2" style="grid-column: 1 / -1; padding: 2rem; text-align: center; color: var(--tl)">
                    Aucune annonce en attente de validation.
                </div>
            @endforelse

        </div>
    </main>

    <div class="toast" id="toast"><i class="ph-fill ph-check-circle" style="color:#10B981;font-size:1.25rem"></i><span id="toast-msg">Action réussie</span></div>

    <script>
        function filterCards(status, btn) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('act'));
            btn.classList.add('act');

            document.querySelectorAll('.card').forEach(card => {
                if (status === 'all' || card.getAttribute('data-status') === status) {
                    card.style.display = 'block';
                    card.style.animation = 'none';
                    card.offsetHeight;
                    card.style.animation = 'fadeUp 0.4s ease-out forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function approveProd(id) {
            const card = document.getElementById(id);
            if(card.getAttribute('data-status') === 'flagged') {
                if(confirm("Ignorer ce signalement et maintenir l'annonce en ligne ?")) {
                    card.style.opacity = '0.5';
                    showToast("Signalement ignoré. L'annonce reste active.");
                }
            } else {
                if(confirm("Publier cette annonce sur le catalogue public ?")) {
                    card.style.opacity = '0.5';
                    showToast("Annonce publiée avec succès sur le catalogue.");
                }
            }
        }

        function rejectProd(id) {
            const reason = prompt("Veuillez saisir le motif du refus/suppression (sera envoyé au producteur) :");
            if(reason && reason.trim() !== "") {
                const card = document.getElementById(id);
                card.style.transition = 'all 0.4s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.remove();
                    showToast("Annonce supprimée et producteur notifié.");
                }, 400);
            }
        }

        function showToast(m) {
            const t = document.getElementById('toast');
            document.getElementById('toast-msg').innerText = m;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        const obs = new IntersectionObserver(e => {
            e.forEach(en => { if (en.isIntersecting) en.target.style.animationPlayState = 'running' });
        }, { threshold: 0.1 });
        document.querySelectorAll('.anim').forEach(el => { el.style.opacity = '0'; obs.observe(el) });
    </script>
</body>
</html>