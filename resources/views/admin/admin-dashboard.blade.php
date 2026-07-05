<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:#111827;color:white;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #374151}.logo{font-size:1.25rem;font-weight:800;color:white;text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:#9CA3AF;text-decoration:none;font-weight:500;transition:all .2s}.ni:hover,.ni.act{background:rgba(255,255,255,0.1);color:white;border-left:3px solid var(--o)}
        .sf{padding:1.5rem;border-top:1px solid #374151}
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}.mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}.d3{animation-delay:.3s}
        .sg{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;margin-bottom:2rem}.sc{background:var(--w);padding:1.5rem;border-radius:var(--r);box-shadow:var(--sh);border-top:4px solid var(--g);transition:transform .3s}.sc:hover{transform:translateY(-5px)}.sc.o{border-top-color:var(--o)}.sv{font-size:1.75rem;font-weight:800;margin:.5rem 0}.sl{font-size:.875rem;color:var(--tl);font-weight:500}
        .cg{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem}.card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:1.5rem}.ct{font-size:1.1rem;font-weight:700;margin-bottom:1.5rem}
        .alert{display:flex;gap:1rem;padding:1rem;background:#fee2e2;border-radius:8px;margin-bottom:.75rem;border-left:4px solid #ef4444;align-items:center}.alert.k{background:var(--ol);border-left-color:var(--o)}
        .btn{padding:.5rem 1rem;border-radius:6px;font-size:.8rem;font-weight:600;border:none;cursor:pointer;margin-right:.5rem;transition:all .2s}.ba{background:var(--g);color:white}.br{background:#fee2e2;color:#b91c1c}.btn:hover{opacity:.9}
        .toast{position:fixed;bottom:20px;right:20px;background:var(--t);color:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,.2);display:flex;align-items:center;gap:.75rem;transform:translateY(100px);opacity:0;transition:all .4s cubic-bezier(.175,.885,.32,1.275);z-index:1000}.toast.show{transform:translateY(0);opacity:1}
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.cg{grid-template-columns:1fr}}
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sh"><a href="{{ route('admin.dashboard') }}" class="logo">Agri<span>Connect</span> <span style="font-size:.7rem;background:var(--o);padding:2px 6px;border-radius:4px;color:white;margin-left:5px">ADMIN</span></a></div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="ni act"><i class="ph ph-squares-four"></i> Vue d'ensemble</a>
            <a href="{{ route('admin.utilisateurs') }}" class="ni"><i class="ph ph-users"></i> Utilisateurs & KYC</a>
            <a href="{{ route('admin.moderation') }}" class="ni"><i class="ph ph-shield-warning"></i> Modération</a>
            <a href="{{ route('admin.parametres') }}" class="ni"><i class="ph ph-gear"></i> Paramètres</a>
        </nav>
        <div class="sf"><div style="display:flex;align-items:center;gap:.75rem"><div style="width:40px;height:40px;background:#374151;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700">AD</div><div><div style="font-weight:600;font-size:.9rem">Administrateur</div><div style="font-size:.8rem;color:#9CA3AF">Support Technique</div></div></div></div>
    </aside>
    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Admin Panel</span></header>
        <div class="anim"><h1 style="font-size:1.5rem;font-weight:800;margin-bottom:.5rem">Tableau de bord Administrateur</h1><p style="color:var(--tl);margin-bottom:2rem">Supervision globale de la plateforme AgriConnect.</p></div>
        <div class="sg">
            <div class="sc anim d1"><div class="sl">Chiffre d'affaires total</div><div class="sv" data-target="{{ $totalRevenue }}">0 F</div><div style="font-size:.8rem;color:var(--g);font-weight:600">{{ $validatedProducts }} produits validés</div></div>
            <div class="sc o anim d2"><div class="sl">Commissions perçues (4%)</div><div class="sv" data-target="{{ $platformFees }}">0 F</div><div style="font-size:.8rem;color:var(--o);font-weight:600">{{ $pendingProducts }} en attente de validation</div></div>
            <div class="sc anim d3" style="border-top-color:#3B82F6"><div class="sl">Utilisateurs actifs</div><div class="sv" data-target="{{ $activeUsers }}">0</div><div style="font-size:.8rem;color:#3B82F6;font-weight:600">{{ $buyers }} Acheteurs, {{ $producers }} Producteurs</div></div>
        </div>
        <div class="cg anim d2">
            <div class="card"><h3 class="ct">Inscriptions par mois</h3><canvas id="userChart"></canvas></div>
            <div class="card"><h3 class="ct">Actions requises</h3>
                <div class="alert k" id="k1"><i class="ph-fill ph-identification-card" style="font-size:1.5rem;color:var(--o)"></i><div style="flex:1"><div style="font-weight:600;font-size:.9rem">Produits en attente : {{ $pendingProducts }}</div><div style="font-size:.8rem;color:var(--tl)">À valider dans la section moderation.</div></div><a href="{{ route('admin.moderation') }}" class="btn ba">Voir</a></div>
                <div class="alert" id="a1"><i class="ph-fill ph-warning" style="font-size:1.5rem;color:#ef4444"></i><div style="flex:1"><div style="font-weight:600;font-size:.9rem">Utilisateurs enregistrés : {{ $activeUsers }}</div><div style="font-size:.8rem;color:var(--tl)">{{ $buyers }} acheteurs et {{ $producers }} producteurs.</div></div><a href="{{ route('admin.utilisateurs') }}" class="btn br">Gérer</a></div>
            </div>
        </div>
    </main>
    <div class="toast" id="toast"><i class="ph-fill ph-check-circle" style="color:#10B981;font-size:1.25rem"></i><span id="toast-msg">Action réussie</span></div>
    <script>
        document.querySelectorAll('.sv').forEach(c=>{const t=+c.getAttribute('data-target');let cur=0;const up=()=>{cur+=t/50;if(cur<t){c.innerText=(t>1000?Math.ceil(cur).toLocaleString('fr-FR')+' F':Math.ceil(cur).toLocaleString('fr-FR'));requestAnimationFrame(up)}else{c.innerText=(t>1000?t.toLocaleString('fr-FR')+' F':t.toLocaleString('fr-FR'))}};up()});
        new Chart(document.getElementById('userChart').getContext('2d'),{type:'bar',data:{labels:@json($labels),datasets:[{label:'Producteurs',data:@json($producerSeries),backgroundColor:'#1A6B3C',borderRadius:4},{label:'Acheteurs',data:@json($buyerSeries),backgroundColor:'#C17F3B',borderRadius:4}]},options:{responsive:true,scales:{y:{beginAtZero:true}}}});
        function showToast(m){const t=document.getElementById('toast');document.getElementById('toast-msg').innerText=m;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),3000)}
        const obs=new IntersectionObserver(e=>{e.forEach(en=>{if(en.isIntersecting)en.target.style.animationPlayState='running'})},{threshold:.1});document.querySelectorAll('.anim').forEach(el=>{el.style.opacity='0';obs.observe(el)});
    </script>
</body>
</html>