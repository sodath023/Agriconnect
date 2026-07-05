<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Revenus - AgriConnect</title>
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
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}
        
        .ph{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem}.pt{font-size:1.5rem;font-weight:800}
        .sg{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;margin-bottom:2rem}
        .sc{background:var(--w);padding:1.5rem;border-radius:var(--r);box-shadow:var(--sh);transition:transform .3s}.sc:hover{transform:translateY(-5px)}
        .sc.wallet{background:linear-gradient(135deg, var(--g), var(--gd));color:white;border:none}
        .sl{font-size:.85rem;opacity:.9;margin-bottom:.5rem}.sv{font-size:1.75rem;font-weight:800;margin-bottom:.5rem}
        .st{font-size:.8rem;font-weight:600;display:flex;align-items:center;gap:.3rem}.st.up{color:#86efac}.st.down{color:#fca5a5}
        .sc.wallet .st{color:rgba(255,255,255,.8)}
        
        .cg{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem}
        .card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:1.5rem}
        .ct{font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center}
        
        table{width:100%;border-collapse:collapse}.th{text-align:left;padding:.75rem 1rem;font-size:.8rem;text-transform:uppercase;color:var(--tl);font-weight:600;border-bottom:1px solid #e5e7eb}
        td{padding:1rem;font-size:.9rem;border-bottom:1px solid #f3f4f6;transition:background .2s}tr:hover td{background:#f9fafb}
        .bdg{padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700}
        .bs{background:var(--gl);color:var(--g)}.bw{background:var(--ol);color:var(--o)}.bb{background:#dbeafe;color:#1e40af}
        
        .btn{padding:.75rem 1.25rem;border-radius:8px;font-size:.9rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;justify-content:center;gap:.5rem}
        .bp{background:var(--g);color:white}.bp:hover{background:var(--gd)}
        .bo{background:rgba(255,255,255,.2);color:white;border:1px solid rgba(255,255,255,.3)}.bo:hover{background:rgba(255,255,255,.3)}
        
        .toast{position:fixed;bottom:20px;right:20px;background:var(--t);color:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,.2);display:flex;align-items:center;gap:.75rem;transform:translateY(100px);opacity:0;transition:all .4s cubic-bezier(.175,.885,.32,1.275);z-index:1000}.toast.show{transform:translateY(0);opacity:1}
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.cg{grid-template-columns:1fr}}
    </style>
</head>
<body>
   @include('producteur.layout')

    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Mes Revenus</span></header>
        
        <div class="ph anim">
            <div>
                <h1 class="pt">Portefeuille & Revenus</h1>
                <p style="color:var(--tl);font-size:.9rem">Suivez vos gains, les commissions et demandez vos virements.</p>
            </div>
            <button class="btn bp" onclick="showToast('Demande de virement de {{ number_format($availableBalance ?? 0, 0, ',', ' ') }} F initiée. Délai : 48h.')"><i class="ph ph-bank"></i> Demander un virement</button>
        </div>

        <div class="sg">
            <div class="sc wallet anim d1">
                <div class="sl">Solde disponible (après commission 4%)</div>
                <div class="sv" data-target="{{ $availableBalance ?? 0 }}">0 F</div>
                <div class="st up"><i class="ph ph-trend-up"></i> Prêt à être viré sur votre compte Mobile Money</div>
                <button class="btn bo" style="margin-top:1rem;width:100%" onclick="showToast('Demande de virement initiée !')"><i class="ph ph-paper-plane-right"></i> Tout virer</button>
            </div>
            <div class="sc anim d2">
                <div class="sl">Chiffre d'affaires confirmé</div>
                <div class="sv" style="color:var(--g)" data-target="{{ $confirmedRevenue ?? 0 }}">0 F</div>
                <div class="st up"><i class="ph ph-trend-up"></i> {{ $products->count() }} produit(s) en ligne</div>
            </div>
            <div class="sc anim d3">
                <div class="sl">Commissions prélevées (4%)</div>
                <div class="sv" style="color:var(--o)" data-target="{{ $platformFees ?? 0 }}">0 F</div>
                <div class="st" style="color:var(--tl)"><i class="ph ph-info"></i> {{ number_format($pendingRevenue ?? 0, 0, ',', ' ') }} F en attente de validation</div>
            </div>
        </div>

        <div class="cg anim d2">
            <div class="card">
                <div class="ct">Évolution des revenus (6 mois) <button class="btn" style="background:#f3f4f6;color:var(--t);padding:.4rem .8rem;font-size:.8rem" onclick="showToast('Rapport CSV téléchargé')"><i class="ph ph-download-simple"></i> Exporter</button></div>
                <canvas id="revenueChart" height="150"></canvas>
            </div>
            <div class="card">
                <div class="ct">Dernières transactions</div>
                <div style="max-height:300px;overflow-y:auto">
                    <table>
                        <thead><tr><th class="th">Date</th><th class="th">Type</th><th class="th">Montant</th><th class="th">Statut</th></tr></thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction['date'] }}</td>
                                    <td>{{ $transaction['label'] }}</td>
                                    <td style="color:var(--g);font-weight:600">+ {{ number_format($transaction['amount'], 0, ',', ' ') }} F</td>
                                    <td><span class="bdg {{ $transaction['status_class'] }}">{{ $transaction['status_label'] }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center;color:var(--tl)">Aucune transaction pour le moment.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="toast" id="toast"><i class="ph-fill ph-check-circle" style="color:#10B981;font-size:1.25rem"></i><span id="toast-msg">Action réussie</span></div>

    <script>
        // 1. Animation des compteurs
        document.querySelectorAll('.sv').forEach(c=>{
            const t=+c.getAttribute('data-target');let cur=0;
            const up=()=>{cur+=t/60;if(cur<t){c.innerText=Math.ceil(cur).toLocaleString('fr-FR')+' F';requestAnimationFrame(up)}else{c.innerText=t.toLocaleString('fr-FR')+' F'}};
            up();
        });

        // 2. Graphique Chart.js
        const revenueData = @json($monthlyRevenue->map(fn ($item) => $item['value'])->values());
        const revenueLabels = @json($monthlyRevenue->map(fn ($item) => ucfirst($item['month']))->values());

        new Chart(document.getElementById('revenueChart').getContext('2d'),{
            type:'bar',
            data:{
                labels: revenueLabels,
                datasets:[{
                    label:'Revenus nets (FCFA)',
                    data: revenueData,
                    backgroundColor:'#1A6B3C',
                    borderRadius:6,
                    barThickness:20
                }]
            },
            options:{
                responsive:true,
                plugins:{legend:{display:false}},
                scales:{
                    y:{beginAtZero:true,grid:{color:'#f3f4f6'}},
                    x:{grid:{display:false}}
                }
            }
        });

        // 3. Toast Notification
        function showToast(m){const t=document.getElementById('toast');document.getElementById('toast-msg').innerText=m;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),3000)}

        // 4. Scroll Reveal
        const obs=new IntersectionObserver(e=>{e.forEach(en=>{if(en.isIntersecting)en.target.style.animationPlayState='running'})},{threshold:.1});
        document.querySelectorAll('.anim').forEach(el=>{el.style.opacity='0';obs.observe(el)});
    </script>
</body>
</html>