<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coopérative Espoir - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F9FAFB;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t)}
        .h{background:var(--w);padding:1rem 1.5rem;display:flex;align-items:center;gap:1rem;position:sticky;top:0;z-index:100;box-shadow:var(--sh)}
        .bb{background:none;border:none;font-size:1.5rem;cursor:pointer;text-decoration:none;color:var(--t)}.ttl{font-weight:700;font-size:1.1rem;flex:1}
        .hero{background:linear-gradient(135deg, var(--g), var(--gd));color:white;padding:3rem 1.5rem 4rem;text-align:center;position:relative}
        .hero::after{content:'';position:absolute;bottom:-2px;left:0;width:100%;height:40px;background:var(--bg);border-radius:50% 50% 0 0 / 100% 100% 0 0}
        .av{width:100px;height:100px;background:var(--w);color:var(--g);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;font-weight:800;margin:0 auto 1rem;border:4px solid rgba(255,255,255,0.3);box-shadow:0 8px 16px rgba(0,0,0,0.2)}
        .pn{font-size:1.75rem;font-weight:800;margin-bottom:.5rem;display:flex;align-items:center;justify-content:center;gap:.5rem}
        .vb{background:var(--o);color:white;font-size:.75rem;padding:.25rem .6rem;border-radius:6px;font-weight:700;display:inline-flex;align-items:center;gap:.2rem}
        .pm{display:flex;justify-content:center;gap:2rem;margin-top:1.5rem;font-size:.95rem;opacity:.9}
        .pm span{display:flex;align-items:center;gap:.4rem}
        .c{max-width:900px;margin:-2rem auto 0;padding:0 1.5rem 3rem;position:relative;z-index:10}
        .card{background:var(--w);border-radius:var(--r);padding:1.5rem;box-shadow:var(--sh);margin-bottom:1.5rem}
        .ct{font-size:1.1rem;font-weight:700;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;color:var(--g)}
        .sp{display:flex;flex-wrap:wrap;gap:.75rem}
        .st{background:var(--gl);color:var(--g);padding:.5rem 1rem;border-radius:20px;font-size:.9rem;font-weight:600;display:flex;align-items:center;gap:.4rem}
        .pg{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.5rem}
        .pc{background:var(--w);border-radius:var(--r);overflow:hidden;border:1px solid #e5e7eb;text-decoration:none;color:var(--t);transition:all .3s}.pc:hover{transform:translateY(-5px);box-shadow:var(--sh)}
        .pi{width:100%;height:160px;object-fit:cover;background:#e5e7eb}
        .pif{padding:1rem}.pnm{font-size:1rem;font-weight:700;margin-bottom:.25rem}.ppr{color:var(--g);font-weight:800;font-size:1.1rem}
        .rv{border-bottom:1px solid #f3f4f6;padding-bottom:1rem;margin-bottom:1rem}.rv:last-child{border-bottom:none;margin-bottom:0}
        .rh{display:flex;justify-content:space-between;font-size:.9rem;margin-bottom:.5rem}.ro{color:var(--o)}.rt{font-size:.95rem;color:var(--tl);line-height:1.6}
    </style>
</head>
<body>
    <header class="h">
        <a href="javascript:history.back()" class="bb"><i class="ph ph-arrow-left"></i></a>
        <div class="ttl">Profil du producteur</div>
        <button class="bb"><i class="ph ph-share-network"></i></button>
    </header>

    <div class="hero">
        <div class="av">CE</div>
        <div class="pn">Coopérative Espoir <span class="vb"><i class="ph-fill ph-seal-check"></i> Vérifié</span></div>
        <p style="opacity:.9;font-size:1rem;max-width:500px;margin:0 auto">Agriculture durable, commerce équitable et produits de première qualité depuis 2018 au Bénin.</p>
        <div class="pm">
            <span><i class="ph-fill ph-map-pin"></i> Calavi, Bénin</span>
            <span><i class="ph-fill ph-star"></i> 4.8/5 (24 avis)</span>
            <span><i class="ph-fill ph-package"></i> 12 produits</span>
        </div>
    </div>

    <main class="c">
        <div class="card">
            <div class="ct"><i class="ph ph-plant"></i> Spécialités & Certifications</div>
            <div class="sp">
                <span class="st">🥔 Tubercules</span>
                <span class="st">🌽 Céréales</span>
                <span class="st">🌿 Sans pesticides</span>
                <span class="st">🤝 Coopérative certifiée</span>
            </div>
        </div>

        <div class="card">
            <div class="ct"><i class="ph ph-package"></i> Produits disponibles</div>
            <div class="pg">
                <a href="{{ route('produit') }}" class="pc">
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400&q=80" class="pi">
                    <div class="pif"><div class="pnm">Igname Kponan</div><div class="ppr">15 000 F <span style="font-weight:400;color:var(--tl);font-size:.85rem">/ tas</span></div></div>
                </a>
                <a href="{{ route('produit') }}" class="pc">
                    <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&q=80" class="pi">
                    <div class="pif"><div class="pnm">Tomates Fraîches</div><div class="ppr">5 000 F <span style="font-weight:400;color:var(--tl);font-size:.85rem">/ panier</span></div></div>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="ct"><i class="ph ph-chat-circle-text"></i> Avis des acheteurs</div>
            <div class="rv">
                <div class="rh"><span style="font-weight:700">Jean D.</span><span class="ro">★★★★★</span></div>
                <div class="rt">Produits très frais et bien emballés. Livraison rapide à Cotonou. Je recommande vivement cette coopérative !</div>
            </div>
            <div class="rv">
                <div class="rh"><span style="font-weight:700">Resto Le Palmier</span><span class="ro">★★★★☆</span></div>
                <div class="rt">Bon rapport qualité-prix pour les tomates. Quelques petits calibres mais très goûteux. Service client réactif.</div>
            </div>
        </div>
    </main>
</body>
</html>