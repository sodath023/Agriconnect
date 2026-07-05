<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Annonce - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:var(--w);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:.75rem}.logo{font-size:1.25rem;font-weight:800;color:var(--g);text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:var(--tl);text-decoration:none;font-weight:500;transition:all .2s;border-left:3px solid transparent}.ni:hover,.ni.act{background:var(--gl);color:var(--g);border-left-color:var(--g)}
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}.mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}
        .pt{font-size:1.5rem;font-weight:800;margin-bottom:.5rem}.ps{color:var(--tl);margin-bottom:2rem}
        .card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:2rem;max-width:800px}
        .fg{margin-bottom:1.5rem}.lb{display:block;font-size:.9rem;font-weight:600;margin-bottom:.5rem;color:var(--t)}
        .inp,.sel,.txa{width:100%;padding:.875rem 1rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:1rem;font-family:inherit;transition:all .2s}
        .inp:focus,.sel:focus,.txa:focus{outline:none;border-color:var(--g);box-shadow:0 0 0 4px var(--gl)}
        .txa{min-height:120px;resize:vertical}
        .fr{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}
        .fu{border:2px dashed #d1d5db;border-radius:8px;padding:2rem;text-align:center;cursor:pointer;transition:all .2s;background:#fafafa}
        .fu:hover{border-color:var(--g);background:var(--gl)}
        .btn{width:100%;padding:1rem;background:var(--g);color:white;border:none;border-radius:8px;font-weight:700;font-size:1rem;cursor:pointer;transition:all .3s;display:flex;align-items:center;justify-content:center;gap:.5rem;margin-top:1rem}
        .btn:hover{background:var(--gd);transform:translateY(-2px);box-shadow:0 8px 16px rgba(26,107,60,0.3)}
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.fr{grid-template-columns:1fr}}
    </style>
</head>
<body>
    @include('producteur.layout')
    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Nouvelle Annonce</span></header>
        <div class="anim">
            <h1 class="pt">Publier un nouveau produit</h1>
            <p class="ps">Remplissez les informations ci-dessous pour rendre votre produit visible aux acheteurs.</p>
            <div class="card">
                @if(session('success'))
                    <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        {{ session('success') }}
                    </div> 
                @endif
                @if( $errors->all())
                    <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <form method="post" action="{{ route('producteur.publier-annonce') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="producteur_id" value="{{ Auth::user()->id }}">
                    <div class="fg">
                        <label class="lb">Photos du produit *</label>
                        <div class="fu" onclick="document.getElementById('file').click()">
                            <i class="ph ph-camera" style="font-size:2.5rem;color:var(--tl);margin-bottom:.5rem"></i>
                            <p id="fname" style="font-size:.9rem;color:var(--tl)">Appuyez pour ajouter une ou plusieurs photos</p>
                            <input type="file" id="file" style="display:none" name="image" multiple accept="image/*" onchange="document.getElementById('fname').innerText='✅ '+this.files.length+' fichier(s) sélectionné(s)'; document.getElementById('fname').style.color='var(--g)'; document.getElementById('fname').style.fontWeight='600'">
                        </div>
                    </div>
                    <div class="fg">
                        <label class="lb">Nom du produit *</label>
                        <input type="text" class="inp" name="nom" placeholder="ex: Igname Kponan de première qualité" required>
                    </div>
                    <div class="fr">
                        <div class="fg">
                            <label class="lb">Catégorie *</label>
                            <select class="sel" name="category_id" required>
                                <option value="">Sélectionner...</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}">{{$categorie->icon}} {{ $categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fg">
                            <label class="lb">Unité de mesure *</label>
                            <select class="sel" name="unite" required>
                                <option value="">Sélectionner...</option>
                                <option value="kg">le kg</option>
                                <option value="tas">le tas</option>
                                <option value="panier">le panier</option>
                                <option value="100kg">les 100 kg</option>
                                <option value="tonne">la tonne</option>
                            </select>
                        </div>
                    </div>
                    <div class="fr">
                        <div class="fg">
                            <label class="lb">Quantité disponible *</label>
                            <input type="number" class="inp" name="stock" placeholder="ex: 50" min="1" required>
                        </div>
                        <div class="fg">
                            <label class="lb">Prix unitaire (FCFA) *</label>
                            <input type="number" class="inp" name="prix" placeholder="ex: 15000" min="0" required>
                        </div>
                    </div>
                    <div class="fg">
                        <label class="lb">Description et détails (optionnel)</label>
                        <textarea class="txa" name="description" placeholder="Décrivez la qualité, la date de récolte, le mode de culture..."></textarea>
                    </div>
                    <button type="submit" class="btn"><i class="ph ph-check-circle"></i> Publier l'annonce</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>