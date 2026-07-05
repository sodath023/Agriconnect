<!DOCTYPE html>
<html lang="fr" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="AgriConnect : Plateforme de mise en relation directe entre producteurs agricoles et acheteurs au Bénin. Produits frais, prix équitables, paiement Mobile Money sécurisé.">
    <title>AgriConnect - Du champ à l'assiette, en toute confiance</title>
    
    <!-- Police Inter (Optimisée pour la lisibilité mobile) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icônes légères -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        
:root {
            --g: #1A6B3C; --gd: #124d2b; --gl: #eef5f1;
            --o: #C17F3B; --ol: #fdf6ed;
            --bg: #F9FAFB; --t: #1F2937; --tl: #6B7280; --w: #FFFFFF;
            --sh: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            --r: 16px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        body { background: var(--bg); color: var(--t); line-height: 1.6; overflow-x: hidden; }

        /* --- ANIMATIONS --- */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .anim { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .d1 { animation-delay: 0.1s; } .d2 { animation-delay: 0.2s; } .d3 { animation-delay: 0.3s; }

        /* --- HEADER --- */
        .header { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); padding: 1rem 0; position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .c { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: 800; color: var(--g); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; }
        .logo span { color: var(--o); }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { text-decoration: none; color: var(--t); font-weight: 500; font-size: 0.95rem; transition: color 0.2s; }
        .nav-links a:hover { color: var(--g); }
        @media(max-width: 768px) { .nav-links { display: none; } }

        .btn { padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; min-height: 48px; cursor: pointer; border: none; font-size: 0.95rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn:active { transform: scale(0.96); }
        .btn-p { background: var(--g); color: var(--w); box-shadow: 0 4px 14px rgba(26, 107, 60, 0.3); }
        .btn-p:hover { background: var(--gd); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(26, 107, 60, 0.4); }
        .btn-o { border: 2px solid var(--g); color: var(--g); background: transparent; }
        .btn-o:hover { background: var(--gl); }

        /* --- HERO --- */
        .hero { background: linear-gradient(135deg, rgba(26, 107, 60, 0.92), rgba(18, 77, 43, 0.88)), url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1200&q=80') center/cover; color: white; padding: 5rem 0 7rem; text-align: center; position: relative; }
        .hero::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 60px; background: var(--bg); border-radius: 50% 50% 0 0 / 100% 100% 0 0; }
        .hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem; line-height: 1.15; letter-spacing: -0.02em; }
        .hero h1 span { color: #FCD34D; }
        .hero p { font-size: 1.15rem; margin-bottom: 2.5rem; opacity: 0.95; max-width: 650px; margin-left: auto; margin-right: auto; }
        .hero-btns { display: flex; flex-direction: column; gap: 1rem; justify-content: center; align-items: center; }
        @media(min-width: 768px) { .hero-btns { flex-direction: row; } .hero h1 { font-size: 3.5rem; } }

        /* --- SECTIONS GÉNÉRALES --- */
        .sec { padding: 5rem 0; }
        .sec-head { text-align: center; margin-bottom: 3rem; max-width: 700px; margin-left: auto; margin-right: auto; }
        .sec-title { font-size: 2rem; font-weight: 800; color: var(--t); margin-bottom: 0.75rem; }
        .sec-sub { color: var(--tl); font-size: 1.05rem; }

        /* --- CATÉGORIES --- */
        .grid-4 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
        @media(min-width: 768px) { .grid-4 { grid-template-columns: repeat(4, 1fr); gap: 1.5rem; } }
        .card-cat { background: var(--w); border-radius: var(--r); padding: 2rem 1rem; text-align: center; box-shadow: var(--sh); border: 1px solid rgba(0,0,0,0.03); text-decoration: none; color: var(--t); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .card-cat:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); border-color: var(--gl); }
        .card-cat .icon { font-size: 3rem; margin-bottom: 1rem; display: inline-block; transition: transform 0.4s ease; }
        .card-cat:hover .icon { transform: scale(1.15) rotate(5deg); }
        .card-cat h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; }
        .card-cat p { font-size: 0.85rem; color: var(--tl); }

        /* --- POURQUOI NOUS CHOISIR --- */
        .bg-light { background: var(--w); }
        .grid-3 { display: grid; grid-template-columns: 1fr; gap: 2rem; }
        @media(min-width: 768px) { .grid-3 { grid-template-columns: repeat(3, 1fr); } }
        .feat-card { text-align: center; padding: 1.5rem; }
        .feat-icon { width: 64px; height: 64px; background: var(--gl); color: var(--g); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin: 0 auto 1.5rem; }
        .feat-card h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 0.75rem; }
        .feat-card p { color: var(--tl); font-size: 0.95rem; }

        /* --- À PROPOS --- */
        .about-grid { display: grid; grid-template-columns: 1fr; gap: 3rem; align-items: center; }
        @media(min-width: 768px) { .about-grid { grid-template-columns: 1fr 1fr; } }
        .about-img { border-radius: var(--r); overflow: hidden; box-shadow: var(--sh); position: relative; }
        .about-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .about-text h2 { font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: var(--g); }
        .about-text p { color: var(--tl); margin-bottom: 1.5rem; font-size: 1.05rem; }
        .stats-row { display: flex; gap: 2rem; margin-top: 2rem; }
        .stat-item h4 { font-size: 1.75rem; font-weight: 800; color: var(--o); }
        .stat-item span { font-size: 0.85rem; color: var(--tl); font-weight: 500; }

        /* --- TÉMOIGNAGES --- */
        .testi-grid { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        @media(min-width: 768px) { .testi-grid { grid-template-columns: repeat(2, 1fr); } }
        .testi-card { background: var(--w); padding: 2rem; border-radius: var(--r); box-shadow: var(--sh); border-left: 4px solid var(--o); position: relative; }
        .testi-card i { position: absolute; top: 1.5rem; right: 1.5rem; font-size: 2rem; color: var(--gl); }
        .testi-text { font-size: 1rem; color: var(--t); font-style: italic; margin-bottom: 1.5rem; line-height: 1.7; }
        .testi-author { display: flex; align-items: center; gap: 1rem; }
        .testi-av { width: 48px; height: 48px; background: var(--g); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; }
        .testi-name { font-weight: 700; font-size: 0.95rem; }
        .testi-role { font-size: 0.8rem; color: var(--tl); }

        /* --- FAQ --- */
        .faq-container { max-width: 800px; margin: 0 auto; }
        .faq-item { background: var(--w); border-radius: var(--r); margin-bottom: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.03); overflow: hidden; border: 1px solid rgba(0,0,0,0.03); }
        .faq-q { padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 600; font-size: 1rem; transition: background 0.2s; }
        .faq-q:hover { background: var(--gl); }
        .faq-q i { transition: transform 0.3s; color: var(--g); }
        .faq-item.active .faq-q i { transform: rotate(180deg); }
        .faq-a { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-out, padding 0.4s ease; padding: 0 1.5rem; color: var(--tl); font-size: 0.95rem; line-height: 1.6; }
        .faq-item.active .faq-a { max-height: 200px; padding: 0 1.5rem 1.25rem 1.5rem; }

        /* --- CTA FINAL --- */
        .cta-sec { background: linear-gradient(135deg, var(--g), var(--gd)); color: white; text-align: center; padding: 5rem 1.5rem; border-radius: var(--r); margin: 0 1.5rem 4rem; }
        .cta-sec h2 { font-size: 2rem; font-weight: 800; margin-bottom: 1rem; }
        .cta-sec p { opacity: 0.9; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto; }
        .cta-sec .btn { background: var(--w); color: var(--g); font-weight: 700; }
        .cta-sec .btn:hover { background: var(--ol); transform: translateY(-2px); }

        /* --- FOOTER --- */
        .footer { background: #111827; color: var(--w); padding: 4rem 0 2rem; }
        .f-grid { display: grid; grid-template-columns: 1fr; gap: 2rem; margin-bottom: 3rem; }
        @media(min-width: 768px) { .f-grid { grid-template-columns: 2fr 1fr 1fr 1fr; } }
        .f-col h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem; color: var(--w); }
        .f-col p { color: #9CA3AF; font-size: 0.9rem; line-height: 1.6; }
        .f-col ul { list-style: none; }
        .f-col ul li { margin-bottom: 0.75rem; }
        .f-col ul li a { color: #9CA3AF; text-decoration: none; font-size: 0.9rem; transition: color 0.2s; }
        .f-col ul li a:hover { color: var(--o); }
        .f-bottom { border-top: 1px solid #374151; padding-top: 2rem; text-align: center; color: #6B7280; font-size: 0.85rem; }

    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
            @include('layouts.nav')
    </header>

    <main>
        <!-- HERO -->
        <section class="hero">
            <div class="c">
                <h1 class="anim">Du champ à l'assiette,<br><span>en toute confiance.</span></h1>
                <p class="anim d1">Achetez des produits agricoles frais, locaux et traçables directement aux producteurs au Bénin, sans intermédiaire abusif.</p>
                <div class="hero-btns anim d2">
                    <a href="{{ route('catalogue') }}" class="btn btn-p" style="background: var(--o); box-shadow: 0 4px 14px rgba(193, 127, 59, 0.4);"><i class="ph ph-shopping-cart"></i> Explorer le catalogue</a>
                    <a href="{{ route('inscription') }}" class="btn btn-p" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(4px);"><i class="ph ph-plant"></i> Je suis producteur</a>
                </div>
            </div>
        </section>

        <!-- CATÉGORIES -->
        <section class="sec c" id="categories">
            <div class="sec-head anim">
                <h2 class="sec-title">Nos Catégories de Produits</h2>
                <p class="sec-sub">Trouvez facilement les produits frais dont vous avez besoin, géolocalisés près de chez vous.</p>
            </div>
            <div class="grid-4">
                @foreach($categories as $index => $category)
                    <a href="{{ url('/catalogue') }}?category={{ $category->slug }}" class="card-cat anim d{{ ($index % 3) + 1 }}">
                        <div class="icon">{{ $category->icon ?? '🏷️' }}</div>
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->description ?? 'Produits de cette catégorie' }}</p>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- POURQUOI NOUS CHOISIR -->
        <section class="sec bg-light">
            <div class="c">
                <div class="sec-head anim">
                    <h2 class="sec-title">Pourquoi choisir AgriConnect ?</h2>
                    <p class="sec-sub">Une plateforme conçue pour répondre aux défis de l'agriculture ouest-africaine.</p>
                </div>
                <div class="grid-3">
                    <div class="feat-card anim d1">
                        <div class="feat-icon"><i class="ph ph-hand-coins"></i></div>
                        <h3>Prix Équitables</h3>
                        <p>Supprimez les intermédiaires. Les producteurs gagnent plus, les acheteurs paient le juste prix.</p>
                    </div>
                    <div class="feat-card anim d2">
                        <div class="feat-icon"><i class="ph ph-shield-check"></i></div>
                        <h3>Paiement 100% Sécurisé</h3>
                        <p>Payez en toute tranquillité via MTN MoMo, Moov Money ou Wave. Fonds sécurisés jusqu'à la livraison.</p>
                    </div>
                    <div class="feat-card anim d3">
                        <div class="feat-icon"><i class="ph ph-map-pin"></i></div>
                        <h3>Produits Frais & Traçables</h3>
                        <p>Sachez exactement d'où viennent vos aliments. Tous nos producteurs sont vérifiés (KYC).</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- À PROPOS -->
        <section class="sec c" id="about">
            <div class="about-grid">
                <div class="about-img anim d1">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&q=80" alt="Agriculteur béninois" loading="lazy">
                </div>
                <div class="about-text anim d2">
                    <h2>Notre Mission : Révolutionner l'agriculture au Bénin</h2>
                    <p>AgriConnect est née d'un constat simple : les agriculteurs qui nourrissent notre pays ne perçoivent qu'une fraction de la valeur de leur travail à cause d'une chaîne de distribution fragmentée.</p>
                    <p>Notre plateforme numérique connecte directement l'offre et la demande, réduisant les pertes post-récolte, garantissant la traçabilité des produits et contribuant activement à la souveraineté alimentaire de l'Afrique de l'Ouest.</p>
                    <div class="stats-row">
                        <div class="stat-item"><h4>50+</h4><span>Producteurs vérifiés</span></div>
                        <div class="stat-item"><h4>1000+</h4><span>Transactions/mois</span></div>
                        <div class="stat-item"><h4>98%</h4><span>Satisfaction</span></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TÉMOIGNAGES / IMPRESSIONS -->
        <section class="sec bg-light">
            <div class="c">
                <div class="sec-head anim">
                    <h2 class="sec-title">Ce qu'ils disent de nous</h2>
                    <p class="sec-sub">La confiance de nos utilisateurs est notre plus grande fierté.</p>
                </div>
                <div class="testi-grid">
                    <div class="testi-card anim d1">
                        <i class="ph-fill ph-quotes"></i>
                        <p class="testi-text">"Grâce à AgriConnect, j'écoule ma production d'igname directement aux restaurateurs de Cotonou sans passer par les grossistes. Mes revenus ont augmenté de 30%."</p>
                        <div class="testi-author">
                            <div class="testi-av">CE</div>
                            <div><div class="testi-name">Coopérative Espoir</div><div class="testi-role">Productrice, Calavi</div></div>
                        </div>
                    </div>
                    <div class="testi-card anim d2">
                        <i class="ph-fill ph-quotes"></i>
                        <p class="testi-text">"En tant que gérant de restaurant, la traçabilité et la fraîcheur sont primordiales. La livraison est ponctuelle et la qualité des tomates est toujours au rendez-vous."</p>
                        <div class="testi-author">
                            <div class="testi-av" style="background:var(--o)">JP</div>
                            <div><div class="testi-name">Jean-Pierre D.</div><div class="testi-role">Restaurateur, Cotonou</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="sec c" id="faq">
            <div class="sec-head anim">
                <h2 class="sec-title">Foire Aux Questions (FAQ)</h2>
                <p class="sec-sub">Trouvez rapidement des réponses à vos interrogations.</p>
            </div>
            <div class="faq-container">
                <div class="faq-item anim d1">
                    <div class="faq-q" onclick="toggleFaq(this)">Comment fonctionne le paiement sur la plateforme ? <i class="ph ph-caret-down"></i></div>
                    <div class="faq-a">Nous acceptons les paiements sécurisés via Mobile Money (MTN MoMo, Moov Money, Wave) ainsi que par carte bancaire. Le paiement à la livraison est également disponible pour certaines zones.</div>
                </div>
                <div class="faq-item anim d2">
                    <div class="faq-q" onclick="toggleFaq(this)">Les producteurs sont-ils vraiment vérifiés ? <i class="ph ph-caret-down"></i></div>
                    <div class="faq-a">Oui, absolument. Chaque producteur doit passer par un processus de vérification d'identité (KYC) simplifié en fournissant une pièce d'identité valide avant de pouvoir publier des annonces.</div>
                </div>
                <div class="faq-item anim d3">
                    <div class="faq-q" onclick="toggleFaq(this)">Quels sont les délais de livraison ? <i class="ph ph-caret-down"></i></div>
                    <div class="faq-a">Une fois la commande confirmée par le producteur (sous 4h max), la livraison est généralement effectuée sous 24 à 48 heures, selon votre localisation et la disponibilité du produit.</div>
                </div>
                <div class="faq-item anim d1">
                    <div class="faq-q" onclick="toggleFaq(this)">Puis-je annuler ma commande après paiement ? <i class="ph ph-caret-down"></i></div>
                    <div class="faq-a">Vous pouvez annuler sans frais tant que le producteur n'a pas confirmé et préparé la commande. Passé ce délai, des frais de traitement peuvent s'appliquer.</div>
                </div>
            </div>
        </section>

        <!-- CTA FINAL -->
        <section class="c">
            <div class="cta-sec anim">
                <h2>Prêt à transformer votre façon d'acheter ou de vendre ?</h2>
                <p>Rejoignez dès aujourd'hui la communauté AgriConnect et participez à une agriculture plus juste et plus transparente au Bénin.</p>
                <a href="{{ route('inscription') }}" class="btn"><i class="ph ph-rocket-launch"></i> Créer mon compte gratuitement</a>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    @include('layouts.footer')

    <script>
        // 1. Animation au scroll (Intersection Observer)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    entry.target.style.opacity = '1';
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.anim').forEach(el => { 
            el.style.opacity = '0'; 
            observer.observe(el); 
        });

        // 2. Gestion de l'accordéon FAQ
        function toggleFaq(element) {
            const item = element.parentElement;
            const isActive = item.classList.contains('active');
            
            // Fermer tous les autres
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
            
            // Ouvrir celui cliqué s'il n'était pas déjà ouvert
            if (!isActive) {
                item.classList.add('active');
            }
        }
    </script>
</body>
</html>