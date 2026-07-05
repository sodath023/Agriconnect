<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Producteur - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:var(--w);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:.75rem}.logo{font-size:1.25rem;font-weight:800;color:var(--g);text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:var(--tl);text-decoration:none;font-weight:500;transition:all .2s;border-left:3px solid transparent}.ni:hover,.ni.act{background:var(--gl);color:var(--g);border-left-color:var(--g)}
        .sf{padding:1.5rem;border-top:1px solid #e5e7eb}.ui{display:flex;align-items:center;gap:.75rem}.av{width:40px;height:40px;background:var(--g);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}.mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}.d3{animation-delay:.3s}
        .sg{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;margin-bottom:2rem}.sc{background:var(--w);padding:1.5rem;border-radius:var(--r);box-shadow:var(--sh);display:flex;align-items:flex-start;justify-content:space-between;transition:transform .3s,box-shadow .3s}.sc:hover{transform:translateY(-5px);box-shadow:0 10px 15px -3px rgba(0,0,0,0.1)}.sv{font-size:1.75rem;font-weight:800;margin:.5rem 0}.sl{font-size:.875rem;color:var(--tl);font-weight:500}.si{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.5rem}.ig{background:var(--gl);color:var(--g)}.io{background:var(--ol);color:var(--o)}
        .cg{display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:2rem}.card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:1.5rem}.ch{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}.ct{font-size:1.1rem;font-weight:700}
        table{width:100%;border-collapse:collapse}.th{text-align:left;padding:.75rem 1rem;font-size:.8rem;text-transform:uppercase;color:var(--tl);font-weight:600;border-bottom:1px solid #e5e7eb}td{padding:1rem;font-size:.9rem;border-bottom:1px solid #f3f4f6;transition:background .2s}tr:hover td{background:#f9fafb}.bdg{padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:600}.bs{background:var(--gl);color:var(--g)}.bw{background:var(--ol);color:var(--o)}.br{background:#fee2e2;color:#b91c1c}
        .btn{padding:.5rem 1rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:.5rem}.bp{background:var(--g);color:white}.bp:hover{background:var(--gd)}
        .alert{padding:1rem;border-radius:8px;margin-bottom:.75rem;border-left:4px solid;display:flex;align-items:center;gap:1rem}.alr{background:#fee2e2;border-color:#ef4444}.alw{background:var(--ol);border-color:var(--o)}
        .toast{position:fixed;bottom:20px;right:20px;background:var(--t);color:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,.2);display:flex;align-items:center;gap:.75rem;transform:translateY(100px);opacity:0;transition:all .4s cubic-bezier(.175,.885,.32,1.275);z-index:1000}.toast.show{transform:translateY(0);opacity:1}
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.cg{grid-template-columns:1fr}}
    </style>
</head>
<body>
    @include('producteur.layout')
    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">AgriConnect</span><button style="background:none;border:none;font-size:1.5rem;cursor:pointer"><i class="ph ph-bell"></i></button></header>
        <div class="anim"><h1 style="font-size:1.5rem;font-weight:800;margin-bottom:.5rem">Tableau de bord</h1><p style="color:var(--tl);margin-bottom:2rem">Bienvenue, voici un résumé de votre activité agricole aujourd'hui.</p></div>
        <div class="sg">
            <div class="sc anim d1"><div>
                <div class="sl">Chiffre d'affaires (Mois)</div>
                <div class="sv" data-target="{{ $monthlyRevenue }}">0</div>
                <div style="font-size:.8rem;color:var(--g);font-weight:600">{{ $recentOrders->count() > 0 ? 'Mise à jour en temps réel' : 'Aucune vente enregistrée' }}</div></div><div class="si ig">
                <i class="ph ph-currency-xof"></i>
        </div>
        </div>
            <div class="sc anim d2"><div>
                <div class="sl">Commandes en cours</div>
                <div class="sv" data-target="{{ $pendingOrdersCount }}">0</div>
                <div style="font-size:.8rem;color:var(--o);font-weight:600">{{ $pendingOrdersCount > 0 ? $pendingOrdersCount . ' en attente de confirmation' : 'Aucune commande en attente' }}</div>
            </div><div class="si io"><i class="ph ph-clock"></i>
        </div>
    </div>
            <div class="sc anim d3"><div>
                <div class="sl">Produits en ligne</div>
                <div class="sv" data-target="{{ $products->count() }}">0</div><div style="font-size:.8rem;color:var(--tl);font-weight:600">{{ $lowStockProducts->count() > 0 ? $lowStockProducts->count() . ' en rupture de stock' : 'Aucun produit en rupture' }}</div></div><div class="si ig"><i class="ph ph-package"></i></div></div>
        </div>
        <div class="cg anim d2">
            <div class="card"><div class="ch"><h3 class="ct">Évolution des ventes (7 jours)</h3>
            <button class="btn bp" onclick="exportChart()"><i class="ph ph-download-simple">
            </i> Exporter</button></div><canvas id="salesChart" height="120"></canvas></div>
            <div class="card"><h3 class="ct" style="margin-bottom:1rem">Alertes Stock</h3>
                @forelse($lowStockProducts as $product)
                    <div class="alert @if($product->stock === 0) alr @else alw @endif">
                        <i class="ph-fill @if($product->stock === 0) ph-warning @else ph-info @endif" style="color:@if($product->stock === 0) #ef4444 @else var(--o) @endif;font-size:1.5rem"></i>
                        <div>
                            <div style="font-weight:600;font-size:.9rem">{{ $product->nom }}</div>
                            <div style="font-size:.8rem;color:var(--tl)">@if($product->stock === 0) Stock critique @else Stock faible @endif : {{ $product->stock }} {{ $product->unite }}</div>
                        </div>
                    </div>
                @empty
                    <div class="alert alw"><i class="ph-fill ph-check-circle" style="color:var(--g);font-size:1.5rem"></i><div><div style="font-weight:600;font-size:.9rem">Tous les produits sont en stock</div><div style="font-size:.8rem;color:var(--tl)">Aucune alerte à traiter pour l'instant.</div></div></div>
                @endforelse
                <button class="btn bp" style="width:100%;margin-top:1rem" onclick="refreshStocks()"><i class="ph ph-arrows-clockwise"></i> Actualiser les stocks</button>
            </div>
        </div>
        <div class="card anim d3"><div class="ch"><h3 class="ct">Dernières commandes reçues</h3><a href="{{ route('producteur.commandes-recues') }}" style="color:var(--g);font-size:.9rem;font-weight:600;text-decoration:none">Voir tout →</a></div>
            <table><thead><tr><th class="th">ID</th><th class="th">Acheteur</th><th class="th">Produits</th><th class="th">Montant</th><th class="th">Statut</th><th class="th">Action</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td style="font-weight:600">{{ $order['id'] }}</td>
                        <td>{{ $order['buyer'] ?: 'Client' }}</td>
                        <td>{{ $order['products'] }}</td>
                        <td style="font-weight:700">{{ number_format($order['amount'], 0, ',', ' ') }} F</td>
                        <td><span class="bdg {{ $order['status'] === 'pending' ? 'bw' : 'bs' }}">{{ $order['status'] === 'pending' ? 'En attente' : 'Confirmée' }}</span></td>
                        <td><button class="btn bp" data-status="{{ $order['status'] }}" onclick="handleOrderAction(this)">{{ $order['status'] === 'pending' ? 'Accepter' : 'Détails' }}</button></td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--tl);padding:2rem">Aucune commande reçue pour le moment.</td></tr>
                @endforelse
            </tbody></table>
        </div>
    </main>
    <div class="toast" id="toast"><i class="ph-fill ph-check-circle" style="color:#10B981;font-size:1.25rem"></i><span id="toast-msg">Action réussie</span></div>
    <script>
        const salesLabels = ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];
        const salesValues = [15000,22000,18000,35000,42000,38000,55000];

        document.querySelectorAll('.sv').forEach(c=>{const t=+c.getAttribute('data-target');let cur=0;const up=()=>{cur+=t/60;if(cur<t){c.innerText=Math.ceil(cur).toLocaleString('fr-FR')+(t>100?' F':'');requestAnimationFrame(up)}else{c.innerText=t.toLocaleString('fr-FR')+(t>100?' F':'')}};up()});

        new Chart(document.getElementById('salesChart').getContext('2d'),{type:'line',data:{labels:salesLabels,datasets:[{label:'Ventes (FCFA)',data:salesValues,borderColor:'#1A6B3C',backgroundColor:'rgba(26,107,60,0.1)',borderWidth:3,tension:0.4,fill:true,pointBackgroundColor:'#FFF',pointBorderColor:'#1A6B3C',pointBorderWidth:2,pointRadius:5}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{borderDash:[5,5]}},x:{grid:{display:false}}}}});

        function showToast(m){const t=document.getElementById('toast');document.getElementById('toast-msg').innerText=m;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),3000)}

        function handleOrderAction(button){
            const row = button.closest('tr');
            const badge = row.querySelector('.bdg');
            if (button.dataset.status === 'pending') {
                badge.textContent = 'Confirmée';
                badge.className = 'bdg bs';
                button.textContent = 'Détails';
                button.dataset.status = 'confirmed';
                button.className = 'btn';
                button.style.background = '#e5e7eb';
                button.style.color = 'var(--t)';
                showToast('Commande confirmée');
            } else {
                window.location.href = "{{ route('producteur.detail-commandes-recues') }}";
            }
        }

        function exportChart(){
            const rows = [['Jour','Ventes (FCFA)'], ...salesLabels.map((label, index)=>[label, salesValues[index]])];
            const csv = rows.map(row => row.join(',')).join('\n');
            const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'ventes-producteur.csv';
            link.click();
            URL.revokeObjectURL(url);
            showToast('Rapport exporté en CSV');
        }

        function refreshStocks(){
            showToast('Mise à jour des stocks synchronisée');
            setTimeout(() => window.location.reload(), 800);
        }

        const obs=new IntersectionObserver(e=>{e.forEach(en=>{if(en.isIntersecting)en.target.style.animationPlayState='running'})},{threshold:.1});document.querySelectorAll('.anim').forEach(el=>{el.style.opacity='0';obs.observe(el)});
    </script>
</body>
</html>