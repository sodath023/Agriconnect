    <aside class="sidebar" id="sidebar">
        <div class="sh"><a href="{{ route('producteur.dashboard') }}" class="logo"><i class="ph-fill ph-plant"></i> Agri<span>Connect</span></a></div>
        <nav class="nav">
            <a href="{{ route('producteur.dashboard') }}" class="ni act"><i class="ph ph-squares-four"></i> Tableau de bord</a>
            <a href="{{ route('producteur.mes-produits') }}" class="ni"><i class="ph ph-package"></i> Mes Produits</a>
            <a href="{{ route('producteur.commandes-recues') }}" class="ni"><i class="ph ph-shopping-bag"></i> Commandes Reçues <span class="bdg bw" style="margin-left:auto">3</span></a>
            <a href="{{ route('producteur.mes-revenus') }}" class="ni"><i class="ph ph-wallet"></i> Mes Revenus</a>
        </nav>
        <div class="sf"><div class="ui"><div class="av"></div><div><div style="font-weight:600;font-size:.9rem">{{ auth()->user()->name }}</div></div></div>
        <a href="{{ route('deconnexion') }}" class="ni" style="margin-top:1rem;color:#EF4444"><i class="ph ph-sign-out"></i> Déconnexion</a></div>
    </aside>
    <script>
        active = "{{ Route::currentRouteName() }}";
        document.querySelectorAll('.ni').forEach(el => {
            if (el.getAttribute('href') === active) {
                el.classList.add('act');
            }
        });
    </script>