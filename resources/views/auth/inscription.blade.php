<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --g: #1A6B3C; --gd: #124d2b; --gl: #eef5f1; --o: #C17F3B; --bg: #F9FAFB; --t: #1F2937; --tl: #6B7280; --w: #FFF; --r: 16px; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--t); min-height: 100vh; display: flex; flex-direction: column; }
        .h { background: var(--w); padding: 1rem; text-align: center; border-bottom: 1px solid #e5e7eb; position: relative; }
        .logo { font-size: 1.5rem; font-weight: 800; color: var(--g); text-decoration: none; } .logo span { color: var(--o); }
        .back { position: absolute; left: 1rem; top: 1rem; color: var(--t); text-decoration: none; font-size: 1.5rem; transition: transform 0.2s; }
        .back:hover { transform: translateX(-3px); }
        
        .c { flex: 1; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        .card { background: var(--w); padding: 2.5rem; border-radius: var(--r); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); width: 100%; max-width: 480px; animation: fadeUp 0.6s ease-out; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .role-select { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
        .role { padding: 1.5rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; text-align: center; cursor: pointer; transition: all 0.3s ease; }
        .role:hover { border-color: var(--o); background: var(--bg); }
        .role.sel { border-color: var(--g); background: var(--gl); box-shadow: 0 0 0 3px rgba(26, 107, 60, 0.1); }
        .role i { font-size: 2rem; color: var(--g); margin-bottom: 0.5rem; display: block; }
        .role h4 { font-size: 1rem; font-weight: 700; }
        .role p { font-size: 0.8rem; color: var(--tl); margin-top: 0.25rem; }

        .fg { margin-bottom: 1.25rem; }
        .lb { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--t); }
        .inp { width: 100%; padding: 0.875rem 1rem; border: 1.5px solid #d1d5db; border-radius: 10px; font-size: 1rem; transition: all 0.2s; min-height: 52px; }
        .inp:focus { outline: none; border-color: var(--g); box-shadow: 0 0 0 4px var(--gl); }
        
        .btn { width: 100%; padding: 1rem; background: var(--g); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; min-height: 52px; margin-top: 1rem; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .btn:hover { background: var(--gd); transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(26, 107, 60, 0.3); }
        .btn:active { transform: scale(0.98); }
        
        .hidden { display: none; opacity: 0; transition: opacity 0.3s; }
        .visible { display: block; opacity: 1; animation: fadeUp 0.4s ease-out; }
        
        .file-up { border: 2px dashed #d1d5db; border-radius: 10px; padding: 1.5rem; text-align: center; cursor: pointer; transition: all 0.2s; background: #fafafa; }
        .file-up:hover { border-color: var(--g); background: var(--gl); }
    </style>
</head>
<body>
    <header class="h">
        <a href="{{ route('home') }}" class="back"><i class="ph ph-arrow-left"></i></a>
        <a href="{{ route('home') }}" class="logo">Agri<span>Connect</span></a>
    </header>
    <div class="c">
        <div class="card">
            <h2 style="text-align:center; margin-bottom:0.5rem; font-size:1.5rem;">Créer votre compte</h2>
            <p style="text-align:center; color:var(--tl); margin-bottom:2rem; font-size:0.95rem;">Rejoignez la première plateforme agricole du Bénin.</p>
            
            <div class="role-select">
                <div class="role sel" onclick="selRole('acheteur', this)">
                    <i class="ph ph-shopping-cart"></i><h4>Acheteur</h4><p>Particulier, Resto, Grossiste</p>
                </div>
                <div class="role" onclick="selRole('producteur', this)">
                    <i class="ph ph-plant"></i><h4>Producteur</h4><p>Agriculteur, Coopérative</p>
                </div>
            </div>

            <form method="POST" action="{{ route('inscription.submit') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <ul style="list-style-type: none; padding-left: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="hidden" name="role" value="acheteur" id="roleInput">
                <div class="fg">
                    <label class="lb">Nom complet / Raison sociale</label>
                    <input type="text" name="name" class="inp" placeholder="ex: Jean Dupont ou Coop. Espoir" required>
                </div>
                <div class="fg">
                    <label class="lb">Numéro de téléphone</label>
                    <input type="tel" name="telephone" class="inp" placeholder="ex: 97 00 00 00" required>
                </div>
                <div class="fg">
                    <label class="lb">Adresse e-mail</label>
                    <input type="email" name="email" class="inp" placeholder="ex: jean.dupont@email.com" required>
                </div>
                <div class="fg">
                    <label class="lb">Mot de passe</label>
                    <input type="password" name="password" class="inp" placeholder="Min. 8 caractères" minlength="8" required>
                </div>
                <div class="fg">
                    <label class="lb">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="inp" placeholder="Min. 8 caractères" minlength="8" required>
                </div>
                <!-- KYC Dynamique -->
                    <div id="kyc-field" class="fg hidden">
                    <label class="lb">Pièce d'identité (KYC Obligatoire)</label>
                    <div class="file-up" onclick="document.getElementById('file').click()">
                        <i class="ph ph-identification-card" style="font-size:2rem; color:var(--tl); margin-bottom:0.5rem;"></i>
                        <p id="file-name" style="font-size:0.9rem; color:var(--tl);">Appuyez pour uploader (CNI, Passeport)</p>
                        <input type="file" name="piece" id="file" style="display:none" accept="image/*,.pdf" onchange="document.getElementById('file-name').innerText = '✅ ' + this.files[0].name; document.getElementById('file-name').style.color = 'var(--g)'; document.getElementById('file-name').style.fontWeight = '600';">
                    </div>
                </div>

                <button type="submit" class="btn" id="submitBtn">
                    <span>S'inscrire et recevoir le code OTP</span>
                    <i class="ph ph-arrow-right"></i>
                </button>
            </form>
            <p style="text-align:center; margin-top:1.5rem; font-size:0.9rem;">Déjà un compte ? <a href="{{ route('connexion') }}" style="color:var(--g); font-weight:700; text-decoration:none;">Se connecter</a></p>
        </div>
    </div>

    <script>
        let role = 'acheteur';
        function selRole(r, el) {
            role = r;
            document.getElementById('roleInput').value = r;
            document.querySelectorAll('.role').forEach(x => x.classList.remove('sel'));
            el.classList.add('sel');
            const kyc = document.getElementById('kyc-field');
            if(r === 'producteur') { kyc.classList.remove('hidden'); kyc.classList.add('visible'); }
            else { kyc.classList.add('hidden'); kyc.classList.remove('visible'); }
        }
        function simulateOTP() {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = '<div style="width:24px;height:24px;border:3px solid rgba(255,255,255,0.3);border-top-color:white;border-radius:50%;animation:spin 1s linear infinite"></div> Traitement...';
            setTimeout(() => { window.location.href = '{{ route('otp.form')}}'; }, 1500);
        }
    </script>
    <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
</body>
</html>