<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriConnect - Authentification</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --green: #1A6B3C; --green-dark: #124d2b; --ocre: #C17F3B; --bg: #F9FAFB; --text: #1F2937; --white: #FFFFFF; --radius: 12px; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--text); min-height: 100vh; display: flex; flex-direction: column; }
        .header { background: var(--white); padding: 1rem; text-align: center; border-bottom: 1px solid #e5e7eb; position: relative; }
        .logo { font-size: 1.5rem; font-weight: 800; color: var(--green); text-decoration: none; }
        .logo span { color: var(--ocre); }
        .back { position: absolute; left: 1rem; top: 1rem; color: var(--text); text-decoration: none; font-size: 1.5rem; }
        
        .container { flex: 1; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        .card { background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: 0 4px 6px rgba(0,0,0,0.05); width: 100%; max-width: 400px; }
        .tabs { display: flex; margin-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb; }
        .tab { flex: 1; padding: 0.75rem; text-align: center; font-weight: 600; color: #6B7280; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; }
        .tab.active { color: var(--green); border-bottom-color: var(--green); }
        
        .form-group { margin-bottom: 1rem; }
        .label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; }
        .input { width: 100%; padding: 0.8rem; border: 1.5px solid #d1d5db; border-radius: 8px; font-size: 1rem; min-height: 48px; }
        .input:focus { outline: none; border-color: var(--green); }
        
        .btn { width: 100%; padding: 0.875rem; background: var(--green); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; min-height: 48px; margin-top: 1rem; }
        .btn:hover { background: var(--green-dark); }
        .role-select { display: flex; gap: 1rem; margin-bottom: 1rem; }
        .role { flex: 1; padding: 1rem; border: 2px solid #e5e7eb; border-radius: 8px; text-align: center; cursor: pointer; }
        .role.selected { border-color: var(--green); background: #eef5f1; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('home') }}" class="back"><i class="ph ph-arrow-left"></i></a>
        <a href="{{ route('home') }}" class="logo">Agri<span>Connect</span></a>
    </header>

    <div class="container">
        <div class="card">
            <div class="tabs">
                <div class="tab active" onclick="switchTab('login')">Connexion</div>
            </div>

            <!-- CONNEXION -->
            <div id="login">
                <form method="POST" action="{{ route('connexion.submit') }}">
                    @csrf
                    @if (session('success'))
                        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            {{ session('success') }}
                        </div>
                        @elseif (session('email'))
                        <div style="background: #d1fae5; color: #aa0a47; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            {{ session('email') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="label">Téléphone ou E-mail</label>
                        <input type="text" class="input" name="email" required placeholder="ex: 97 00 00 00">
                    </div>
                    <div class="form-group">
                        <label class="label">Mot de passe</label>
                        <input type="password" class="input" name="password" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn">Se connecter</button>
                    <p style="text-align:center; margin-top:1rem; font-size:0.9rem;">
                        <a href="#" style="color:var(--ocre);">Mot de passe oublié ?</a>
                    </p>
                    <p style="text-align:center; margin-top:1rem; font-size:0.9rem;">
                        Vous n'avez pas encore un compte ? <a href="{{ route('inscription') }}" style="color:var(--green);">S'inscrire</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentRole = 'acheteur';
        function switchTab(tab) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');
            document.getElementById('login').classList.toggle('hidden', tab !== 'login');
            document.getElementById('register').classList.toggle('hidden', tab !== 'register');
        }
        function selectRole(role, el) {
            currentRole = role;
            document.querySelectorAll('.role').forEach(r => r.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('kyc-field').classList.toggle('hidden', role !== 'producteur');
        }
        function handleRegister() {
            alert("Code OTP simulé : 1234. Validation réussie !");
            window.location.href = '{{ route('home') }}';
        }
    </script>
</body>
</html>