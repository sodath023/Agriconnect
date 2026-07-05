<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --g: #1A6B3C;
            --gd: #124d2b;
            --o: #C17F3B;
            --bg: #F9FAFB;
            --t: #1F2937;
            --w: #FFF;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--t); min-height: 100vh; display: flex; flex-direction: column; }
        .h { background: var(--w); padding: 1rem; text-align: center; border-bottom: 1px solid #e5e7eb; position: relative; }
        .logo { font-size: 1.5rem; font-weight: 800; color: var(--g); text-decoration: none; }
        .logo span { color: var(--o); }
        .back { position: absolute; left: 1rem; top: 1rem; color: var(--t); text-decoration: none; font-size: 1.5rem; }
        .c { flex: 1; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        .card { background: var(--w); padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, .05); width: 100%; max-width: 400px; }
        .fg { margin-bottom: 1rem; }
        .lb { display: block; font-size: .85rem; font-weight: 600; margin-bottom: .4rem; }
        .inp { width: 100%; padding: .8rem; border: 1.5px solid #d1d5db; border-radius: 8px; font-size: 1rem; min-height: 48px; }
        .inp:focus { outline: none; border-color: var(--g); }
        .btn { width: 100%; padding: .875rem; background: var(--g); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; min-height: 48px; margin-top: 1rem; }
        .btn:hover { background: var(--gd); }
    </style>
</head>
<body>
    <header class="h">
        <a href="{{ route('home') }}" class="back">←</a>
        <a href="{{ route('home') }}" class="logo">Agri<span>Connect</span></a>
    </header>
    <div class="c">
        <div class="card">
            <h2 style="text-align:center;margin-bottom:1.5rem">Se connecter</h2>
            <form method="POST" action="{{ route('connexion.submit') }}">
                @csrf
                @if (session('success'))
                    <div style="background:#d1fae5;color:#065f46;padding:.8rem;border-radius:8px;margin-bottom:1rem;">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div style="background:#fee2e2;color:#b91c1c;padding:.8rem;border-radius:8px;margin-bottom:1rem;">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="fg">
                    <label class="lb" for="identifier">Téléphone ou E-mail</label>
                    <input type="text" id="identifier" class="inp" name="identifier" value="{{ old('identifier') }}" placeholder="ex: jean@example.com ou 97 00 00 00" required>
                </div>
                <div class="fg">
                    <label class="lb" for="password">Mot de passe</label>
                    <input type="password" id="password" class="inp" name="password" required>
                </div>
                <button type="submit" class="btn">Se connecter</button>
            </form>
            <p style="text-align:center;margin-top:1rem;font-size:.9rem"><a href="#" style="color:var(--o)">Mot de passe oublié ?</a></p>
            <p style="text-align:center;margin-top:.5rem;font-size:.9rem">Pas de compte ? <a href="{{ route('inscription') }}" style="color:var(--g);font-weight:600">S'inscrire</a></p>
        </div>
    </div>
</body>
</html>