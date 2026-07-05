<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Commande #045 - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:var(--w);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:.75rem}
        .logo{font-size:1.25rem;font-weight:800;color:var(--g);text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:var(--tl);text-decoration:none;font-weight:500;transition:all .2s;border-left:3px solid transparent}.ni:hover,.ni.act{background:var(--gl);color:var(--g);border-left-color:var(--g)}
        .sf{padding:1.5rem;border-top:1px solid #e5e7eb}.ui{display:flex;align-items:center;gap:.75rem}.av{width:40px;height:40px;background:var(--g);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}.mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}
        
        .ph{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem}.pt{font-size:1.5rem;font-weight:800}
        .grid{display:grid;grid-template-columns:2fr 1fr;gap:1.5rem}
        .card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:1.5rem;margin-bottom:1.5rem}
        .ct{font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem}
        
        /* Timeline Verticale Animée */
        .timeline{position:relative;padding-left:2rem;margin:1.5rem 0}
        .timeline::before{content:'';position:absolute;left:7px;top:0;bottom:0;width:2px;background:#e5e7eb}
        .tl-item{position:relative;margin-bottom:2rem;padding-left:1.5rem}
        .tl-item::before{content:'';position:absolute;left:-2rem;top:0;width:16px;height:16px;border-radius:50%;background:#e5e7eb;border:3px solid var(--w);z-index:2;transition:all .5s}
        .tl-item.completed::before{background:var(--g);box-shadow:0 0 0 4px var(--gl)}
        .tl-item.active::before{background:var(--w);border-color:var(--g);animation:pulse 2s infinite}
        @keyframes pulse{0%{box-shadow:0 0 0 0 rgba(26,107,60,.4)}70%{box-shadow:0 0 0 8px rgba(26,107,60,0)}100%{box-shadow:0 0 0 0 rgba(26,107,60,0)}}
        .tl-title{font-weight:700;font-size:.95rem;margin-bottom:.25rem}.tl-date{font-size:.85rem;color:var(--tl)}
        
        .prod-row{display:flex;gap:1rem;padding:1rem;background:#f9fafb;border-radius:8px;margin-bottom:1rem}
        .prod-img{width:60px;height:60px;border-radius:8px;object-fit:cover;background:#e5e7eb}
        .prod-info{flex:1}.prod-name{font-weight:600;font-size:.95rem}.prod-meta{font-size:.85rem;color:var(--tl)}
        .price-row{display:flex;justify-content:space-between;margin-bottom:.75rem;font-size:.95rem;color:var(--tl)}
        .price-row.total{border-top:1px dashed #e5e7eb;padding-top:.75rem;margin-top:.75rem;font-size:1.1rem;font-weight:800;color:var(--t)}
        .price-row.total span:last-child{color:var(--g);font-size:1.25rem}
        
        .btn{padding:.75rem 1.25rem;border-radius:8px;font-size:.9rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;width:100%;margin-bottom:.75rem}
        .bp{background:var(--g);color:white}.bp:hover{background:var(--gd)}
        .bo{background:transparent;border:1.5px solid #d1d5db;color:var(--t)}.bo:hover{background:#f9fafb}
        
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
    @include('acheteurs.layout')

    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Détail Commande</span></header>
        
        <div class="ph anim">
            <div>
                <h1 class="pt">Commande {{$commande->reference}}</h1>
                <p style="color:var(--tl);font-size:.9rem">Passée le {{ $commande->created_at->format('d M, Y à H:i') }}</p>
            </div>
            <span style="background:var(--ol);color:var(--o);padding:.5rem 1rem;border-radius:20px;font-weight:700;font-size:.9rem;display:flex;align-items:center;gap:.5rem"><i class="ph ph-clock"></i> {{ ucfirst($commande->status) }}</span>
        </div>

        <div class="grid">
            <div class="anim d1">
                <div class="card">
                    <h3 class="ct"><i class="ph ph-truck" style="color:var(--g)"></i> Suivi de la livraison</h3>
                    <div class="timeline">
                        <div class="tl-item completed ? 'status' : 'confirmed'">
                            <div class="tl-title">Commande confirmée</div>
                            <div class="tl-date">15 Juin, 10:32 • Paiement validé (MTN MoMo)</div>
                        </div>
                        <div class="tl-item completed ? 'status' : 'preparation'">
                            <div class="tl-title">En cours de préparation</div>
                            <div class="tl-date">Votre produit est en train d'être conditionné pour l'expédition.</div>
                        </div>
                        <div class="tl-item completed ? 'status' : 'sent' active ? 'status' : 'preparation'">
                            <div class="tl-title">Expédiée</div>
                            <div class="tl-date">Estimé : 16 Juin, matin</div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-title completed ? 'status' : 'delivered' active ? 'status' : 'sent'">Livrée</div>
                            <div class="tl-date">Quartier Haie Vive, Cotonou</div>
                        </div>
                    </div>
                </div>

                @foreach($commande->lignecommandes as $ligne)
                    <div class="prod-row">
                        <img src="{{ asset('storage/' . $ligne->product->image) }}" alt="{{ $ligne->product->nom }}" class="prod-img">
                        <div class="prod-info">
                            <div class="prod-name">{{ $ligne->product->nom }}</div>
                            <div class="prod-meta">{{ $ligne->quantity }} {{ $ligne->product->unite }} x {{ number_format($ligne->product->prix, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div style="font-weight:700;color:var(--g)">{{ number_format($ligne->quantity * $ligne->product->prix, 0, ',', ' ') }} FCFA</div>
                    </div>
                @endforeach
            </div>

            <div class="anim d2">
                <div class="card">
                    <h3 class="ct"><i class="ph ph-receipt" style="color:var(--g)"></i> Récapitulatif</h3>
                    <div class="price-row"><span>Sous-total</span><span>{{ number_format($commande->lignecommandes->sum(function ($ligne) { return $ligne->quantity * $ligne->product->prix; }), 0, ',', ' ') }} FCFA</span></div>
                    <div class="price-row"><span>Frais de livraison</span><span>1 500 FCFA</span></div>
                    <div class="price-row"><span>Commission plateforme</span><span>Incluse</span></div>
                    <div class="price-row total"><span>Total payé</span><span>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span></div>
                </div>

                <div class="card">
                    <h3 class="ct"><i class="ph ph-map-pin" style="color:var(--g)"></i> Adresse de livraison</h3>
                    <p style="font-size:.95rem;line-height:1.6;color:var(--tl)"><strong>{{ $commande->firstname }} {{ $commande->lastname }}</strong><br>{{$commande->address}}<br>{{$commande->city}}<br>Tél : {{$commande->phone}}</p>
                </div>

                <a class="btn bp" href="https://wa.me/+22961234567" target="_blank"><i class="ph ph-chat-circle-text"></i> Contacter l'agence</a>
                <button class="btn bo" onclick="alert('Téléchargement de la facture PDF...')"><i class="ph ph-file-pdf"></i> Télécharger la facture</button>
            </div>
        </div>
    </main>
    <script>
        const obs=new IntersectionObserver(e=>{e.forEach(en=>{if(en.isIntersecting)en.target.style.animationPlayState='running'})},{threshold:.1});
        document.querySelectorAll('.anim').forEach(el=>{el.style.opacity='0';obs.observe(el)});
    </script>
</body>
</html>