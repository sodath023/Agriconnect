<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Admin AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --g: #1A6B3C; --gd: #124d2b; --gl: #eef5f1;
            --o: #C17F3B; --ol: #fdf6ed;
            --bg: #F3F4F6; --t: #1F2937; --tl: #6B7280; --w: #FFF;
            --sh: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --r: 12px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--t); display: flex; min-height: 100vh; }

        /* --- SIDEBAR ADMIN (Sombre) --- */
        .sidebar { width: 260px; background: #111827; color: white; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 50; transition: transform 0.3s; }
        .sh { padding: 1.5rem; border-bottom: 1px solid #374151; }
        .logo { font-size: 1.25rem; font-weight: 800; color: white; text-decoration: none; }
        .logo span { color: var(--o); }
        .nav { flex: 1; padding: 1rem 0; }
        .ni { display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.5rem; color: #9CA3AF; text-decoration: none; font-weight: 500; transition: all 0.2s; }
        .ni:hover, .ni.act { background: rgba(255,255,255,0.1); color: white; border-left: 3px solid var(--o); }
        .sf { padding: 1.5rem; border-top: 1px solid #374151; }
        .ui { display: flex; align-items: center; gap: 0.75rem; }
        .av { width: 40px; height: 40px; background: #374151; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; }

        /* --- MAIN CONTENT --- */
        .mc { flex: 1; margin-left: 260px; padding: 2rem; transition: margin 0.3s; }
        .mh { display: none; padding: 1rem; background: var(--w); border-bottom: 1px solid #e5e7eb; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; }

        /* --- ANIMATIONS --- */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .anim { animation: fadeUp 0.6s ease-out forwards; opacity: 0; }
        .d1 { animation-delay: 0.1s; } .d2 { animation-delay: 0.2s; } .d3 { animation-delay: 0.3s; }

        /* --- PAGE HEADER --- */
        .ph { margin-bottom: 2rem; }
        .pt { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .ps { color: var(--tl); font-size: 0.95rem; }

        /* --- FORMS & CARDS --- */
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .card { background: var(--w); border-radius: var(--r); box-shadow: var(--sh); padding: 1.5rem; }
        .ct { font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; color: var(--t); }
        .ct i { color: var(--g); font-size: 1.25rem; }

        .fg { margin-bottom: 1.25rem; }
        .lb { display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--t); }
        .inp { width: 100%; padding: 0.875rem 1rem; border: 1.5px solid #d1d5db; border-radius: 8px; font-size: 1rem; transition: all 0.2s; }
        .inp:focus { outline: none; border-color: var(--g); box-shadow: 0 0 0 4px var(--gl); }
        .helper { font-size: 0.8rem; color: var(--tl); margin-top: 0.4rem; display: flex; align-items: center; gap: 0.3rem; }

        .btn { padding: 0.875rem 1.5rem; border-radius: 8px; font-size: 0.95rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .bp { background: var(--g); color: white; width: 100%; }
        .bp:hover { background: var(--gd); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(26, 107, 60, 0.3); }
        .bp:disabled { background: #9CA3AF; cursor: not-allowed; transform: none; box-shadow: none; }

        /* --- CATEGORY MANAGEMENT --- */
        .cat-list { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem; }
        .cat-tag { background: var(--gl); color: var(--g); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; border: 1px solid transparent; transition: all 0.2s; }
        .cat-tag:hover { border-color: var(--g); }
        .cat-tag .remove { cursor: pointer; opacity: 0.6; transition: opacity 0.2s; }
        .cat-tag .remove:hover { opacity: 1; color: #EF4444; }
        
        .add-cat { display: flex; gap: 0.75rem; }
        .add-cat .inp { flex: 1; }
        .btn-add { background: var(--o); color: white; white-space: nowrap; }
        .btn-add:hover { background: #a0682e; }

        /* --- TOAST --- */
        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--t); color: white; padding: 1rem 1.5rem; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 0.75rem; transform: translateY(100px); opacity: 0; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 1000; }
        .toast.show { transform: translateY(0); opacity: 1; }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .mc { margin-left: 0; padding: 1rem; }
            .mh { display: flex; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sh">
            <a href="{{ route('admin.parametres') }}" class="logo">Agri<span>Connect</span> <span style="font-size:0.7rem; background:var(--o); padding:2px 6px; border-radius:4px; color:white; margin-left:5px;">ADMIN</span></a>
        </div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="ni"><i class="ph ph-squares-four"></i> Vue d'ensemble</a>
            <a href="{{ route('admin.utilisateurs') }}" class="ni"><i class="ph ph-users"></i> Utilisateurs & KYC</a>
            <a href="{{ route('admin.moderation') }}" class="ni"><i class="ph ph-shield-warning"></i> Modération</a>
            <a href="{{ route('admin.parametres') }}" class="ni act"><i class="ph ph-gear"></i> Paramètres</a>
        </nav>
        <div class="sf">
            <div class="ui">
                <div class="av">AD</div>
                <div>
                    <div style="font-weight: 600; font-size: 0.9rem;">Administrateur</div>
                    <div style="font-size: 0.8rem; color: #9CA3AF;">Support Technique</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="mc">
        <header class="mh">
            <button style="background:none; border:none; font-size:1.5rem; cursor:pointer;" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="ph ph-list"></i>
            </button>
            <span style="font-weight: 700;">Paramètres</span>
        </header>

        <div class="ph anim">
            <h1 class="pt">Configuration de la plateforme</h1>
            <p class="ps">Gérez les règles métier, les commissions et les catégories de produits de manière centralisée.</p>
        </div>

        <form id="settingsForm" onsubmit="saveSettings(event)">
            <div class="grid">
                <!-- Paramètres Financiers -->
                <div class="card anim d1">
                    <h3 class="ct"><i class="ph ph-currency-circle-dollar"></i> Paramètres Financiers</h3>
                    <div class="fg">
                        <label class="lb">Taux de commission plateforme (%)</label>
                        <input type="number" class="inp" id="commission" value="4" min="0" max="20" step="0.5" required>
                        <div class="helper"><i class="ph ph-info"></i> Ce pourcentage est prélevé automatiquement sur chaque transaction réussie.</div>
                    </div>
                    <div class="fg">
                        <label class="lb">Frais de livraison par défaut (FCFA)</label>
                        <input type="number" class="inp" id="deliveryFee" value="1500" min="0" step="100" required>
                        <div class="helper"><i class="ph ph-info"></i> S'applique si aucune zone géographique spécifique n'est configurée.</div>
                    </div>
                </div>

                <!-- Paramètres Opérationnels -->
                <div class="card anim d2">
                    <h3 class="ct"><i class="ph ph-clock"></i> Paramètres Opérationnels</h3>
                    <div class="fg">
                        <label class="lb">Délai de confirmation commande (heures)</label>
                        <input type="number" class="inp" id="confirmDelay" value="4" min="1" max="24" required>
                        <div class="helper"><i class="ph ph-info"></i> Conformément au CDC (Section 5.3.1), délai max avant annulation auto.</div>
                    </div>
                    <div class="fg">
                        <label class="lb">Délai de virement producteur (heures)</label>
                        <input type="number" class="inp" id="payoutDelay" value="48" min="24" step="24" required>
                        <div class="helper"><i class="ph ph-info"></i> Délai après livraison confirmée pour le déblocage des fonds.</div>
                    </div>
                </div>
            </div>

            <!-- Gestion des Catégories -->
            <div class="card anim d3" style="margin-bottom: 2rem;">
                <h3 class="ct"><i class="ph ph-tag"></i> Gestion des Catégories de Produits</h3>
                <div class="cat-list" id="catList">
                    <div class="cat-tag">🥔 Tubercules <i class="ph ph-x remove" onclick="removeCat(this)"></i></div>
                    <div class="cat-tag">🌽 Céréales <i class="ph ph-x remove" onclick="removeCat(this)"></i></div>
                    <div class="cat-tag">🫘 Légumineuses <i class="ph ph-x remove" onclick="removeCat(this)"></i></div>
                    <div class="cat-tag">🥬 Légumes Frais <i class="ph ph-x remove" onclick="removeCat(this)"></i></div>
                </div>
                <div class="add-cat">
                    <input type="text" class="inp" id="newCatInput" placeholder="Nouvelle catégorie (ex: Fruits)">
                    <button type="button" class="btn btn-add" onclick="addCat()"><i class="ph ph-plus"></i> Ajouter</button>
                </div>
            </div>

            <!-- Bouton de Sauvegarde -->
            <div class="anim d3" style="max-width: 400px;">
                <button type="submit" class="btn bp" id="saveBtn">
                    <i class="ph ph-floppy-disk"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </main>

    <!-- TOAST NOTIFICATION -->
    <div class="toast" id="toast">
        <i class="ph-fill ph-check-circle" style="color: #10B981; font-size: 1.25rem;"></i>
        <span id="toast-msg">Paramètres enregistrés avec succès</span>
    </div>

    <script>
        // 1. Gestion de l'ajout de catégorie
        function addCat() {
            const input = document.getElementById('newCatInput');
            const value = input.value.trim();
            if (value) {
                const list = document.getElementById('catList');
                const tag = document.createElement('div');
                tag.className = 'cat-tag';
                tag.innerHTML = `🏷️ ${value} <i class="ph ph-x remove" onclick="removeCat(this)"></i>`;
                list.appendChild(tag);
                input.value = '';
                showToast("Catégorie ajoutée avec succès");
            }
        }

        // 2. Gestion de la suppression de catégorie
        function removeCat(icon) {
            if (confirm("Supprimer cette catégorie ? Les produits associés devront être reclassés.")) {
                icon.parentElement.remove();
                showToast("Catégorie supprimée");
            }
        }

        // 3. Sauvegarde des paramètres (Simulation)
        function saveSettings(e) {
            e.preventDefault();
            const btn = document.getElementById('saveBtn');
            const originalText = btn.innerHTML;
            
            // État de chargement
            btn.disabled = true;
            btn.innerHTML = '<div style="width:20px;height:20px;border:3px solid rgba(255,255,255,0.3);border-top-color:white;border-radius:50%;animation:spin 1s linear infinite"></div> Enregistrement...';
            
            // Simulation d'appel API (1s)
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                showToast("✅ Configuration de la plateforme mise à jour !");
            }, 1000);
        }

        // 4. Toast Notification System
        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-msg').innerText = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // 5. Scroll Reveal Animation
        const obs = new IntersectionObserver(e => {
            e.forEach(en => { if (en.isIntersecting) en.target.style.animationPlayState = 'running' });
        }, { threshold: 0.1 });
        document.querySelectorAll('.anim').forEach(el => { el.style.opacity = '0'; obs.observe(el) });
    </script>
    <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
</body>
</html>