<aside class="sidebar" id="sidebar">
        <div class="sh"><a href="/" class="logo"><i class="ph-fill ph-plant"></i> Agri<span>Connect</span></a></div>
        <nav class="nav">
            <a href="/dashboard-acheteur" class="ni act"><i class="ph ph-squares-four"></i> Tableau de bord</a>
            <a href="/mes-commandes" class="ni"><i class="ph ph-shopping-bag"></i> Mes Commandes</a>
            <a href="" class="ni"><i class="ph ph-heart"></i> Producteurs Favoris</a>
            <a href="/profil-acheteur" class="ni"><i class="ph ph-user"></i> Mon Profil & Adresses</a>
        </nav>
        <div class="sf"><div class="ui"><div class="av">U</div><div><div style="font-weight:600;font-size:.9rem">{{auth()->user()->name}}</div><div style="font-size:.8rem;color:var(--tl)">{{auth()->user()->role}}</div></div></div>
        <a href="/deconnexion" class="ni" style="margin-top:1rem;color:#EF4444"><i class="ph ph-sign-out"></i> Déconnexion</a></div>
    </aside>