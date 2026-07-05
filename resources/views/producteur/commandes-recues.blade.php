<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes Reçues - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:var(--w);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:.75rem}.logo{font-size:1.25rem;font-weight:800;color:var(--g);text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:var(--tl);text-decoration:none;font-weight:500;transition:all .2s;border-left:3px solid transparent}.ni:hover,.ni.act{background:var(--gl);color:var(--g);border-left-color:var(--g)}
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}.mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}
        .pt{font-size:1.5rem;font-weight:800;margin-bottom:.5rem}.ps{color:var(--tl);margin-bottom:2rem}
        .alert{background:var(--ol);border:1px solid var(--o);border-radius:var(--r);padding:1rem 1.5rem;display:flex;align-items:center;gap:1rem;margin-bottom:2rem;color:#92571A;font-weight:600}
        .cl{display:flex;flex-direction:column;gap:1rem}
        .ci{background:var(--w);border-radius:var(--r);padding:1.5rem;box-shadow:var(--sh);display:flex;flex-direction:column;gap:1rem;border-left:4px solid var(--o);transition:all .3s}.ci:hover{transform:translateX(5px)}
        .ci.confirmed{border-left-color:var(--g)}
        .ch{display:flex;justify-content:space-between;align-items:flex-start}
        .cid{font-weight:800;font-size:1.1rem}.ctime{font-size:.85rem;color:var(--tl)}
        .cb{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;padding-top:1rem;border-top:1px solid #f3f4f6}
        .camt{font-size:1.25rem;font-weight:800;color:var(--g)}
        .cact{display:flex;gap:.75rem}
        .btn{padding:.6rem 1.2rem;border-radius:8px;font-size:.9rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:.5rem}
        .ba{background:var(--g);color:white}.ba:hover{background:var(--gd)}
        .br{background:#fee2e2;color:#b91c1c}.br:hover{background:#fecaca}
        .bdg{padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700}.bw{background:var(--ol);color:var(--o)}.bs{background:var(--gl);color:var(--g)}
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.cb{flex-direction:column;align-items:flex-start}}
    </style>
</head>
<body>
    
@include('producteur.layout')
    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Commandes</span></header>
        <div class="anim">
            <h1 class="pt">Commandes Reçues</h1>
            <p class="ps">Gérez les demandes d'achat de vos produits.</p>
            
            <div class="alert">
                <i class="ph-fill ph-clock" style="font-size:1.5rem"></i>
                <div>
                    <div>Règle des 4 heures</div>
                    <div style="font-size:.85rem;font-weight:400">Vous devez accepter ou refuser une commande dans un délai maximum de 4h, sinon elle sera automatiquement annulée.</div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert" style="background:#ecfdf3;border-color:#16a34a;color:#166534">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert" style="background:#fef2f2;border-color:#dc2626;color:#991b1b">
                    {{ session('error') }}
                </div>
            @endif
            <div style="margin-bottom:1.5rem;color:var(--tl);font-size:.95rem">
                Les commandes de vos clients apparaîtront automatiquement ici dès qu’ils passent une commande pour l’un de vos produits.
            </div>
            <div class="cl">
                @forelse($orders as $index => $order)
                    <div class="ci {{ $order['status'] === 'confirmed' || $order['status'] === 'paid' ? 'confirmed' : '' }} anim d{{ $index + 1 }}">
                        <div class="ch">
                            <div>
                                <div class="cid">{{ $order['reference'] }}</div>
                                <div style="font-size:.9rem;margin-top:.25rem"><i class="ph ph-user"></i> {{ $order['buyer'] ?: 'Client non renseigné' }} • {{ $order['quantity'] }} article(s) • {{ $order['products'] }}</div>
                            </div>
                            <span class="bdg {{ $order['status_class'] }}">{{ $order['status_label'] }}</span>
                        </div>
                        <div class="cb">
                            <div class="camt">{{ number_format($order['amount'], 0, ',', ' ') }} FCFA</div>
                            <div class="cact">
                                @if(in_array($order['status'], ['pending', 'processing', 'en_attente']))
                                    <form action="{{ route('producteur.commandes-statut', $order['id']) }}" method="POST" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="action" value="refuse">
                                        <button type="submit" class="btn br"><i class="ph ph-x"></i> Refuser</button>
                                    </form>
                                    <form action="{{ route('producteur.commandes-statut', $order['id']) }}" method="POST" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="btn ba"><i class="ph ph-check"></i> Accepter</button>
                                    </form>
                                @else
                                    <button class="btn" style="background:#e5e7eb;color:var(--t)"><i class="ph ph-eye"></i> Voir détails</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ci anim d1">
                        <div style="font-weight:600;color:var(--tl)">Aucune commande pour le moment.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
    <script>
        const obs=new IntersectionObserver(e=>{e.forEach(en=>{if(en.isIntersecting)en.target.style.animationPlayState='running'})},{threshold:.1});
        document.querySelectorAll('.anim').forEach(el=>{el.style.opacity='0';obs.observe(el)});
    </script>
</body>
</html>