<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>OTP - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --g: #1A6B3C;
            --gd: #124d2b;
            --o: #C17F3B;
            --bg: #F9FAFB;
            --t: #1F2937;
            --w: #FFF
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif
        }

        body {
            background: var(--bg);
            color: var(--t);
            min-height: 100vh;
            display: flex;
            flex-direction: column
        }

        .h {
            background: var(--w);
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            position: relative
        }

        .back {
            position: absolute;
            left: 1rem;
            top: 1rem;
            color: var(--t);
            text-decoration: none;
            font-size: 1.5rem
        }

        .c {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem
        }

        .card {
            background: var(--w);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .05);
            width: 100%;
            max-width: 400px;
            text-align: center
        }

        .otp-c {
            display: flex;
            gap: .75rem;
            justify-content: center;
            margin: 1.5rem 0
        }

        .otp-i {
            width: 50px;
            height: 56px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            border: 2px solid #d1d5db;
            border-radius: 8px
        }

        .otp-i:focus {
            border-color: var(--g);
            outline: none
        }

        .btn {
            width: 100%;
            padding: .875rem;
            background: var(--g);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            min-height: 48px
        }
    </style>
</head>

<body>
    <header class="h"><a href="{{ route('inscription') }}" class="back">←</a>
        <h3>Vérification</h3>
    </header>
    <div class="c">
        <div class="card">
            <h2>Code de vérification</h2>
            <p style="color:#6B7280;margin:1rem 0">Un code à 4 chiffres a été envoyé à votre numéro.</p>
            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf
                <div class="otp-c">
                    <input type="text" class="form-control" name="token" maxlength="6" required>
                </div><button type="submit" class="btn">Vérifier le code</button>
            </form>
            <p style="margin-top:1rem;font-size:.9rem"><a href="{{ route('otp.resend') }}" style="color:var(--g)">Renvoyer le code</a></p>
        </div>
    </div>
    <script>document.querySelectorAll('.otp-i').forEach((i, idx) => { i.addEventListener('input', e => { if (e.target.value.length === 1 && idx < 3) document.querySelectorAll('.otp-i')[idx + 1].focus() }) })</script>
</body>

</html>