<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs & KYC - Admin AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        
        /* Sidebar Admin (Sombre) */
        .sidebar{width:260px;background:#111827;color:white;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #374151}.logo{font-size:1.25rem;font-weight:800;color:white;text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:#9CA3AF;text-decoration:none;font-weight:500;transition:all .2s}.ni:hover,.ni.act{background:rgba(255,255,255,0.1);color:white;border-left:3px solid var(--o)}
        .sf{padding:1.5rem;border-top:1px solid #374151}.ui{display:flex;align-items:center;gap:.75rem}.av{width:40px;height:40px;background:#374151;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}
        
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}
        .mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .anim{animation:fadeUp .6s ease-out forwards;opacity:0}.d1{animation-delay:.1s}.d2{animation-delay:.2s}
        
        .ph{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}.pt{font-size:1.5rem;font-weight:800}
        .btn{padding:.6rem 1.2rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:.5rem}
        .bp{background:var(--g);color:white}.bp:hover{background:var(--gd)}
        .bo{background:transparent;border:1.5px solid #d1d5db;color:var(--t)}.bo:hover{background:#f9fafb}
        .ba{background:var(--g);color:white}.ba:hover{background:var(--gd)}
        .br{background:#fee2e2;color:#b91c1c}.br:hover{background:#fecaca}
        
        .card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);overflow:hidden}
        .table-container{overflow-x:auto}
        table{width:100%;border-collapse:collapse}
        .th{text-align:left;padding:1rem;font-size:.8rem;text-transform:uppercase;color:var(--tl);font-weight:600;border-bottom:1px solid #e5e7eb;background:#f9fafb}
        td{padding:1rem;font-size:.9rem;border-bottom:1px solid #f3f4f6;vertical-align:middle;transition:background .2s}
        tr:hover td{background:#f9fafb}
        tr.fade-out{opacity:0;transform:translateX(20px);transition:all .4s ease}
        
        .user-info{display:flex;align-items:center;gap:.75rem}.u-av{width:36px;height:36px;background:var(--gl);color:var(--g);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem}
        .u-name{font-weight:600;color:var(--t)}.u-email{font-size:.8rem;color:var(--tl)}
        .bdg{padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;gap:.3rem}
        .bw{background:var(--ol);color:var(--o)}.bs{background:var(--gl);color:var(--g)}.bd{background:#fee2e2;color:#b91c1c}
        .doc-link{color:var(--g);text-decoration:none;font-weight:600;font-size:.85rem;display:flex;align-items:center;gap:.3rem}.doc-link:hover{text-decoration:underline}
        
        .toast{position:fixed;bottom:20px;right:20px;background:var(--t);color:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,.2);display:flex;align-items:center;gap:.75rem;transform:translateY(100px);opacity:0;transition:all .4s cubic-bezier(.175,.885,.32,1.275);z-index:1000}.toast.show{transform:translateY(0);opacity:1}
        
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.ph{flex-direction:column;align-items:flex-start;gap:1rem}}
    </style>
</head>  
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sh"><a href="{{ route('admin.utilisateurs') }}" class="logo">Agri<span>Connect</span> <span style="font-size:.7rem;background:var(--o);padding:2px 6px;border-radius:4px;color:white;margin-left:5px">ADMIN</span></a></div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="ni"><i class="ph ph-squares-four"></i> Vue d'ensemble</a>
            <a href="{{ route('admin.utilisateurs') }}" class="ni act"><i class="ph ph-users"></i> Utilisateurs & KYC</a>
            <a href="{{ route('admin.moderation') }}" class="ni"><i class="ph ph-shield-warning"></i> Modération</a>
            <a href="{{ route('admin.parametres') }}" class="ni"><i class="ph ph-gear"></i> Paramètres</a>
        </nav>
        <div class="sf"><div class="ui"><div class="av">AD</div><div><div style="font-weight:600;font-size:.9rem">Administrateur</div><div style="font-size:.8rem;color:#9CA3AF">Support Technique</div></div></div></div>
    </aside>

    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Admin Panel</span></header>
        
        <div class="ph anim">
            <div><h1 class="pt">Vérification des Utilisateurs (KYC)</h1><p style="color:var(--tl);font-size:.9rem">Validez l'identité des producteurs pour garantir la sécurité de la plateforme.</p></div>
            <a href="{{ route('admin.utilisateurs.export-pdf') }}" class="btn bo"><i class="ph ph-download-simple"></i> Exporter la liste</a>
        </div>

        <div class="card anim d1">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="th">Utilisateur</th>
                            <th class="th">Rôle</th>
                            <th class="th">Localisation</th>
                            <th class="th">Document KYC</th>
                            <th class="th">Statut</th>
                            <th class="th">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        @forelse($users as $user)
                            @php
                                $profile = $user->role === 'producteur' ? $user->producteur : $user->acheteur;
                                $location = $user->role === 'producteur'
                                    ? optional($profile)->localisation
                                    : optional($profile)->adresseLivraison;
                                $docLabel = $user->role === 'producteur' && !empty(optional($profile)->piece)
                                    ? optional($profile)->piece
                                    : 'Non requis';
                                $isPending = $user->role === 'producteur' && empty(optional($profile)->kycValide);
                                $statusClass = $isPending ? 'bdg bw' : 'bdg bs';
                                $statusLabel = $isPending ? 'En attente' : 'Vérifié';
                                $initials = strtoupper(substr($user->name, 0, 1));
                            @endphp
                            <tr id="user-{{ $user->id }}">
                                <td>
                                    <div class="user-info">
                                        <div class="u-av">{{ $initials }}</div>
                                        <div>
                                            <div class="u-name">{{ $user->name }}</div>
                                            <div class="u-email">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span style="font-weight:600">{{ ucfirst($user->role) }}</span></td>
                                <td>{{ $location ?? 'Non renseignée' }}</td>
                                <td>
                                    @if($user->role === 'producteur' && !empty(optional($profile)->piece))
                                        <a href="#" class="doc-link" onclick="alert('Ouverture de {{ $docLabel }}')"><i class="ph ph-file-pdf"></i> {{ $docLabel }}</a>
                                    @else
                                        <span style="color:var(--tl);font-size:.85rem">{{ $docLabel }}</span>
                                    @endif
                                </td>
                                <td><span class="{{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td>
                                    @if($user->role === 'producteur' && $isPending)
                                        <div style="display:flex;gap:.5rem">
                                            <button class="btn ba" onclick="approveUser('user-{{ $user->id }}')"><i class="ph ph-check"></i> Valider</button>
                                            <button class="btn br" onclick="rejectUser('user-{{ $user->id }}')"><i class="ph ph-x"></i> Rejeter</button>
                                        </div>
                                    @else
                                        @php
                                            $productId = optional($user->products->first())->id;
                                            $detailUrl = $productId ? route('produit', ['id' => $productId]) : route('catalogue');
                                        @endphp
                                        <a href="{{ $detailUrl }}" class="btn bo" style="padding:.4rem .8rem;font-size:.8rem"><i class="ph ph-eye"></i> Détails</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;color:var(--tl);padding:2rem">Aucun utilisateur trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="toast" id="toast"><i class="ph-fill ph-check-circle" style="color:#10B981;font-size:1.25rem"></i><span id="toast-msg">Action réussie</span></div>

    <script>
        function approveUser(id) {
            if(confirm("Valider l'identité de cet utilisateur ? Il pourra désormais publier des annonces.")) {
                const row = document.getElementById(id);
                row.querySelector('.bdg').className = 'bdg bs';
                row.querySelector('.bdg').innerHTML = '<i class="ph ph-check-circle"></i> Vérifié';
                row.querySelectorAll('.btn').forEach(btn => btn.remove()); // Retire les boutons d'action
                showToast("Utilisateur vérifié avec succès et notifié par e-mail.");
            }
        }

        function rejectUser(id) {
            const reason = prompt("Veuillez saisir le motif du refus (sera envoyé à l'utilisateur) :");
            if(reason && reason.trim() !== "") {
                const row = document.getElementById(id);
                row.classList.add('fade-out');
                setTimeout(() => {
                    row.remove();
                    showToast("Demande KYC rejetée et utilisateur notifié.");
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