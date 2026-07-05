<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Acheteur - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:var(--w);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s cubic-bezier(.4,0,.2,1)}
        .sh{padding:1.5rem;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:.75rem}
        .logo{font-size:1.25rem;font-weight:800;color:var(--g);text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}
        .ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:var(--tl);text-decoration:none;font-weight:500;transition:all .2s;border-left:3px solid transparent}
        .ni:hover,.ni.act{background:var(--gl);color:var(--g);border-left-color:var(--g)}
        .sf{padding:1.5rem;border-top:1px solid #e5e7eb}.ui{display:flex;align-items:center;gap:.75rem}.av{width:40px;height:40px;background:var(--g);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}
        
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}
        .mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}.d3{animation-delay:.3s}
        
        .sg{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;margin-bottom:2rem}
        .sc{background:var(--w);padding:1.5rem;border-radius:var(--r);box-shadow:var(--sh);display:flex;align-items:flex-start;justify-content:space-between;transition:transform .3s,box-shadow .3s}
        .sc:hover{transform:translateY(-5px);box-shadow:0 10px 15px -3px rgba(0,0,0,0.1)}
        .sv{font-size:1.75rem;font-weight:800;margin:.5rem 0}.sl{font-size:.875rem;color:var(--tl);font-weight:500}
        .si{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.5rem}.ig{background:var(--gl);color:var(--g)}.io{background:var(--ol);color:var(--o)}
        
        .tracking{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:1.5rem;margin-bottom:2rem;position:relative;overflow:hidden}
        .ts{display:flex;justify-content:space-between;position:relative;margin:2rem 0}
        .ts::before{content:'';position:absolute;top:15px;left:0;width:100%;height:4px;background:#e5e7eb;z-index:0}
        .ts::after{content:'';position:absolute;top:15px;left:0;width:66%;height:4px;background:var(--g);z-index:1;transition:width 1.2s cubic-bezier(.4,0,.2,1)}
        .step{position:relative;z-index:2;text-align:center;flex:1}
        .sd{width:34px;height:34px;background:var(--w);border:3px solid #e5e7eb;border-radius:50%;margin:0 auto .5rem;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--tl);transition:all .5s}
        .step.comp .sd{background:var(--g);border-color:var(--g);color:white}
        .step.act .sd{border-color:var(--g);color:var(--g);animation:pulse 2s infinite}
        @keyframes pulse{0%{box-shadow:0 0 0 0 rgba(26,107,60,.4)}70%{box-shadow:0 0 0 10px rgba(26,107,60,0)}100%{box-shadow:0 0 0 0 rgba(26,107,60,0)}}
        .slb{font-size:.8rem;font-weight:600;color:var(--tl)}.step.comp .slb,.step.act .slb{color:var(--g)}
        
        .card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:1.5rem}
        table{width:100%;border-collapse:collapse}.th{text-align:left;padding:.75rem 1rem;font-size:.8rem;text-transform:uppercase;color:var(--tl);font-weight:600;border-bottom:1px solid #e5e7eb}
        td{padding:1rem;font-size:.9rem;border-bottom:1px solid #f3f4f6;transition:background .2s}tr:hover td{background:#f9fafb}
        .bdg{padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:600}.bs{background:var(--gl);color:var(--g)}.bw{background:var(--ol);color:var(--o)}
        .btn{padding:.5rem 1rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:.5rem}
        .bp{background:var(--g);color:white}.bp:hover{background:var(--gd)}
        .toast{position:fixed;bottom:20px;right:20px;background:var(--t);color:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,.2);display:flex;align-items:center;gap:.75rem;transform:translateY(100px);opacity:0;transition:all .4s cubic-bezier(.175,.885,.32,1.275);z-index:1000}
        .toast.show{transform:translateY(0);opacity:1}
        
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.ts{flex-direction:column;gap:1rem}.ts::before,.ts::after{display:none}.step{display:flex;align-items:center;gap:1rem;text-align:left}.sd{margin:0}}
    </style>
</head>
<body>
    @include('acheteurs.layout')
    <main class="mc">
        <header class="mh">
            <button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button>
            <span style="font-weight:700">Espace Acheteur</span>
            <button style="background:none;border:none;font-size:1.5rem;cursor:pointer"><i class="ph ph-bell"></i></button>
        </header>

        <div class="anim"><h1 style="font-size:1.5rem;font-weight:800;margin-bottom:.5rem">Bonjour, Jean 👋</h1><p style="color:var(--tl);margin-bottom:2rem">Voici le suivi de vos dernières activités et commandes en cours.</p></div>

        <div class="sg">
            <div class="sc anim d1"><div><div class="sl">Commandes</div><div class="sv" data-target="4">{{$totalCommandes}}</div><div style="font-size:.8rem;color:var(--g);font-weight:600">↑ +2 vs mois dernier</div></div><div class="si ig"><i class="ph ph-shopping-cart"></i></div></div>
            <div class="sc anim d2"><div><div class="sl">Dépenses totales</div><div class="sv" data-target="87500">{{$totalMontant}} F</div><div style="font-size:.8rem;color:var(--o);font-weight:600">Budget maîtrisé</div></div><div class="si io"><i class="ph ph-wallet"></i></div></div>
            <div class="sc anim d3"><div><div class="sl">Producteurs favoris</div><div class="sv" data-target="3">0</div><div style="font-size:.8rem;color:var(--tl);font-weight:600">Suivi actif</div></div><div class="si ig"><i class="ph ph-heart"></i></div></div>
        </div>

        <div class="tracking anim d2">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
                <h3 style="font-size:1.1rem;font-weight:700">Suivi de la commande #CMD-045</h3>
                <span class="bdg bw">En préparation</span>
            </div>
            <div class="ts">
                <div class="step comp"><div class="sd"><i class="ph-bold ph-check"></i></div><div class="slb">Commandée<br><small>15 Juin, 10:30</small></div></div>
                <div class="step comp"><div class="sd"><i class="ph-bold ph-check"></i></div><div class="slb">Payée<br><small>15 Juin, 10:32</small></div></div>
                <div class="step act"><div class="sd">3</div><div class="slb">En préparation<br><small>Par le producteur</small></div></div>
                <div class="step"><div class="sd">4</div><div class="slb">Expédiée</div></div>
                <div class="step"><div class="sd">5</div><div class="slb">Livrée</div></div>
            </div>
            <div style="background:#f9fafb;padding:1rem;border-radius:8px;display:flex;gap:1rem;align-items:center;margin-top:1.5rem">
                <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=100&q=80" style="width:60px;height:60px;border-radius:8px;object-fit:cover">
                <div style="flex:1"><div style="font-weight:600">2 x Igname Kponan</div><div style="font-size:.85rem;color:var(--tl)">Vendeur: Coopérative Espoir • Calavi</div></div>
                <div style="font-weight:800;color:var(--g)">30 000 F</div>
            </div>
        </div>

        <div class="card anim d3">
            <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:1rem">Commandes récentes</h3>
            <table>
                <thead><tr><th class="th">ID</th><th class="th">Date</th><th class="th">Produits</th><th class="th">Montant</th><th class="th">Statut</th><th class="th">Action</th></tr></thead>
                <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td>#CMD-{{ str_pad($commande->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $commande->created_at->format('d M, Y') }}</td>
                            <td>{{ $commande->lignecommandes->count() }} produit(s)</td>
                            <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} F</td>
                            <td>
                                @if($commande->status === 'pending')
                                    <span class="bdg bw">En attente</span>
                                @elseif($commande->status === 'preparation')
                                    <span class="bdg bw">En préparation</span>
                                @elseif($commande->status === 'sent')
                                    <span class="bdg bs">Expédiée</span>
                                @elseif($commande->status === 'delivered')
                                    <span class="bdg bs">Livrée</span>
                                @elseif($commande->status === 'failed')
                                    <span class="bdg br">Échouée</span>
                                @elseif($commande->status === 'cancelled')
                                    <span class="bdg bw">Annulée</span>
                                @endif
                            </td>
                            <td><a href="{{ route('acheteur.detail-commandes', $commande->id) }}" class="btn bp"><i class="ph ph-eye"></i> Voir</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    <div class="toast" id="toast"><i class="ph-fill ph-check-circle" style="color:#10B981;font-size:1.25rem"></i><span id="toast-msg">Action réussie</span></div>
    <script>
        document.querySelectorAll('.sv').forEach(c=>{const t=+c.getAttribute('data-target');let cur=0;const up=()=>{cur+=t/60;if(cur<t){c.innerText=Math.ceil(cur).toLocaleString('fr-FR')+(t>100?' F':'');requestAnimationFrame(up)}else{c.innerText=t.toLocaleString('fr-FR')+(t>100?' F':'')}};up()});
        function showToast(m){const t=document.getElementById('toast');document.getElementById('toast-msg').innerText=m;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),3000)}
        const obs=new IntersectionObserver(e=>{e.forEach(en=>{if(en.isIntersecting){en.target.style.animationPlayState='running'}})},{threshold:.1});document.querySelectorAll('.anim').forEach(el=>{el.style.opacity='0';obs.observe(el)});
    </script>
</body>
</html>