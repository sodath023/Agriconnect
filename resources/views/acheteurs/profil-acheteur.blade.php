<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--gd:#124d2b;--gl:#eef5f1;--o:#C17F3B;--ol:#fdf6ed;--bg:#F3F4F6;--t:#1F2937;--tl:#6B7280;--w:#FFF;--sh:0 4px 6px -1px rgba(0,0,0,0.05);--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);display:flex;min-height:100vh}
        .sidebar{width:260px;background:var(--w);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50;transition:transform .3s}
        .sh{padding:1.5rem;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:.75rem}.logo{font-size:1.25rem;font-weight:800;color:var(--g);text-decoration:none}.logo span{color:var(--o)}
        .nav{flex:1;padding:1rem 0}.ni{display:flex;align-items:center;gap:.75rem;padding:.875rem 1.5rem;color:var(--tl);text-decoration:none;font-weight:500;transition:all .2s;border-left:3px solid transparent}.ni:hover,.ni.act{background:var(--gl);color:var(--g);border-left-color:var(--g)}
        .sf{padding:1.5rem;border-top:1px solid #e5e7eb}.ui{display:flex;align-items:center;gap:.75rem}.av{width:40px;height:40px;background:var(--g);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}
        .mc{flex:1;margin-left:260px;padding:2rem;transition:margin .3s}.mh{display:none;padding:1rem;background:var(--w);border-bottom:1px solid #e5e7eb;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeUp .6s ease-out forwards;opacity:0}
        .pt{font-size:1.5rem;font-weight:800;margin-bottom:2rem}
        .card{background:var(--w);border-radius:var(--r);box-shadow:var(--sh);padding:2rem;margin-bottom:2rem}
        .ct{font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem;color:var(--g)}
        .fg{margin-bottom:1.25rem}.lb{display:block;font-size:.85rem;font-weight:600;margin-bottom:.4rem}
        .inp,.sel{width:100%;padding:.875rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:1rem;transition:all .2s}.inp:focus,.sel:focus{outline:none;border-color:var(--g);box-shadow:0 0 0 4px var(--gl)}
        .fr{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}
        .btn{padding:.875rem 1.5rem;background:var(--g);color:white;border:none;border-radius:8px;font-weight:600;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;gap:.5rem}.btn:hover{background:var(--gd)}
        .ai{border:1.5px solid #e5e7eb;border-radius:8px;padding:1.25rem;margin-bottom:1rem;position:relative;transition:all .2s}.ai.def{border-color:var(--g);background:var(--gl)}
        .db{position:absolute;top:-10px;right:1rem;background:var(--g);color:white;font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:4px}
        .an{font-weight:700;font-size:1rem;margin-bottom:.25rem}.ad{font-size:.9rem;color:var(--tl);margin-bottom:1rem;line-height:1.5}
        .ba{display:flex;gap:.75rem}.bs{padding:.5rem 1rem;border-radius:6px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;display:flex;align-items:center;gap:.3rem}.be{background:#e0e7ff;color:#3730a3}.bd{background:#fee2e2;color:#b91c1c}
        @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.mc{margin-left:0;padding:1rem}.mh{display:flex}.fr{grid-template-columns:1fr}}
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:100;align-items:center;justify-content:center}.modal.show{display:flex}.modal-content{background:var(--w);border-radius:var(--r);padding:2rem;max-width:500px;width:90%;max-height:90vh;overflow-y:auto;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1)}.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;font-size:1.25rem;font-weight:700;color:var(--g)}.close-modal{background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--tl)}
    </style>
</head>
<body>
    @include('acheteurs.layout')
    @if(session('success'))
        <div style="position:fixed;top:1rem;right:1rem;background:var(--g);color:white;padding:.75rem 1.25rem;border-radius:8px;box-shadow:var(--sh);z-index:200">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('div[style*="position:fixed"]').remove();
            }, 3000);
        </script>
    @endif
    @if($client)
    @if($errors->any())
        <div style="position:fixed;top:1rem;right:1rem;background:#EF4444;color:white;padding:.75rem 1.25rem;border-radius:8px;box-shadow:var(--sh);z-index:200">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('div[style*="position:fixed"]').remove();
            }, 5000);
        </script>

    @endif
    <main class="mc">
        <header class="mh"><button style="background:none;border:none;font-size:1.5rem;cursor:pointer" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="ph ph-list"></i></button><span style="font-weight:700">Mon Profil</span></header>
        <div class="anim">
            <h1 class="pt">Paramètres du compte</h1>
            <div class="card">
                <div class="ct"><i class="ph ph-user"></i> Informations personnelles</div>
                <form action="{{ route('acheteur.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="fr">
                        <div class="fg"><label class="lb">Nom complet</label><input type="text" name="name" class="inp" value="{{ $client->user->name ?? auth()->user()->name ?? '' }}" required></div>
                        <div class="fg"><label class="lb">Type d'acheteur</label><select class="sel" name="typeacheteur">
                            <option value="particulier" {{ ($client->typeacheteur ?? '') === 'particulier' ? 'selected' : '' }}>Particulier</option>
                            <option value="restaurateur" {{ ($client->typeacheteur ?? '') === 'restaurateur' ? 'selected' : '' }}>Restaurateur</option>
                            <option value="grossiste" {{ ($client->typeacheteur ?? '') === 'grossiste' ? 'selected' : '' }}>Grossiste</option>
                        </select></div>
                    </div>
                    <div class="fr">
                        <div class="fg"><label class="lb">Téléphone</label><input type="tel" name="telephone" class="inp" value="{{ $client->user->telephone ?? auth()->user()->telephone ?? '' }}" required></div>
                        <div class="fg"><label class="lb">Adresse e-mail</label><input type="email" name="email" class="inp" value="{{ $client->user->email ?? auth()->user()->email ?? '' }}" required></div>
                    </div>
                    <button type="submit" class="btn"><i class="ph ph-floppy-disk"></i> Enregistrer les modifications</button>
                </form>
            </div>

            <div class="card">
                <div class="ct"><i class="ph ph-map-pin"></i> Mes adresses de livraison</div>
                @if($client->adressesLivraison->count() > 0)
                    @foreach($client->adressesLivraison as $adresse)
                        <div class="ai {{ $adresse->par_defaut ? 'def' : '' }}">
                            @if($adresse->par_defaut)
                                <div class="db">Par défaut</div>
                            @endif
                            <div class="an">{{ $adresse->type }}</div>
                            <div class="ad">{{ $adresse->adresse }}, {{ $adresse->ville }}<br>Téléphone: {{ $adresse->téléphone }}</div>
                            <div class="ba">
                                <button class="bs be"><i class="ph ph-pencil"></i> Modifier</button>
                                <button class="bs bd" onclick="alert('⚠️ Adresse supprimée !')"><i class="ph ph-trash"></i> Supprimer</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="color:var(--tl);font-size:.9rem; margin-bottom: 1rem;">Aucune adresse de livraison n'est disponible. Veuillez en ajouter une.</p>
                @endif
                <button class="btn" style="background:transparent;border:1.5px dashed var(--g);color:var(--g);width:100%" onclick="openAddressModal()">
                    <i class="ph ph-plus"></i> Ajouter une nouvelle adresse
                </button>
            </div>
        </div>
    </main>
    @else
        <main class="mc">
            <div class="anim">
                <h1 class="pt">Profil non disponible</h1>
                <p style="color:var(--tl);font-size:.95rem">Aucune information de profil n'est disponible pour le moment. Veuillez vous assurer que vous êtes connecté.</p>
            </div>
        </main>
    @endif

    <div id="addressModal" class="modal" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <span>Ajouter une adresse de livraison</span>
                <button type="button" class="close-modal" onclick="closeAddressModal()" aria-label="Fermer">×</button>
            </div>
            <form method="POST" action="{{ route('acheteur.adresse-livraison.store') }}">
                @csrf
                <input type="hidden" name="acheteur_id" value="{{ $client->id ?? '' }}">
                <div class="fg">
                    <label class="lb" for="addressType">Type d'adresse</label>
                    <input id="addressType" type="text" class="inp" placeholder="Domicile, Bureau..." name="type" required>
                </div>
                <div class="fg">
                    <label class="lb" for="addressLine">Adresse complète</label>
                    <input id="addressLine" type="text" class="inp" placeholder="Ex : 12 rue de la Paix" name="adresse" required>
                </div>
                <div class="fr">
                    <div class="fg">
                        <label class="lb" for="addressCity">Ville</label>
                        <input id="addressCity" type="text" name="ville" class="inp" placeholder="Dakar" required>
                    </div>
                    <div class="fg">
                        <label class="lb" for="addressPhone">Téléphone</label>
                        <input id="addressPhone" type="tel" class="inp" placeholder="+221 77 000 00 00" name="téléphone" required>
                    </div>
                </div>
                <div class="fg">
                    <label class="lb" for="addressDefault">Définir comme adresse par défaut</label>
                    <select id="addressDefault" class="sel" name="par_defaut">
                        <option value="0">Non</option>
                        <option value="1">Oui</option>
                    </select>
                </div>
                <div style="display:flex;gap:.75rem;margin-top:1.5rem">
                    <button type="submit" class="btn">Enregistrer l'adresse</button>
                    <button type="button" class="btn" style="background:#6B7280" onclick="closeAddressModal()">Annuler</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        const obs=new IntersectionObserver(e=>{e.forEach(en=>{if(en.isIntersecting)en.target.style.animationPlayState='running'})},{threshold:.1});
        document.querySelectorAll('.anim').forEach(el=>{el.style.opacity='0';obs.observe(el)});

        function openAddressModal(){
            const modal=document.getElementById('addressModal');
            if(modal){
                modal.classList.add('show');
                modal.setAttribute('aria-hidden','false');
            }
        }

        function closeAddressModal(){
            const modal=document.getElementById('addressModal');
            if(modal){
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden','true');
            }
        }

        document.getElementById('addressModal')?.addEventListener('click', function(e){
            if(e.target === this){
                closeAddressModal();
            }
        });

        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape'){
                closeAddressModal();
            }
        });
    </script>
</body>
</html>