<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Détail Commande - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --g: #1A6B3C;
            --o: #C17F3B;
            --bg: #F9FAFB;
            --t: #1F2937;
            --w: #FFF;
            --e: #EF4444
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
            padding-bottom: 2rem
        }

        .h {
            background: var(--w);
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05)
        }

        .bb {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            text-decoration: none;
            color: var(--t)
        }

        .ttl {
            font-weight: 700;
            font-size: 1.1rem;
            flex: 1
        }

        .c {
            max-width: 600px;
            margin: 0 auto;
            padding: 1rem
        }

        .al {
            background: #fdf6ed;
            color: var(--o);
            padding: 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            border: 1px solid var(--o)
        }

        .cd {
            background: var(--w);
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            margin-bottom: 1rem
        }

        .dr {
            display: flex;
            justify-content: space-between;
            margin-bottom: .75rem;
            font-size: .95rem
        }

        .dr.tot {
            border-top: 1px dashed #e5e7eb;
            padding-top: .75rem;
            margin-top: .75rem;
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--g)
        }

        .ab {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem
        }

        .ab h4 {
            font-size: .9rem;
            color: #6B7280;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .ab p {
            font-size: .9rem
        }

        .ag {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1.5rem
        }

        .btn {
            padding: .875rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .br {
            background: var(--e);
            color: white
        }

        .bg {
            background: var(--g);
            color: white
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .4rem .75rem;
            border-radius: 999px;
            background: #fef3c7;
            color: #92400e;
            font-size: .85rem;
            font-weight: 700;
            margin-top: .75rem;
        }

        .toast {
            position: fixed;
            left: 50%;
            bottom: 1rem;
            transform: translateX(-50%) translateY(120%);
            background: #111827;
            color: white;
            padding: .9rem 1.2rem;
            border-radius: 999px;
            font-size: .95rem;
            box-shadow: 0 10px 20px rgba(0,0,0,.15);
            transition: transform 0.3s ease;
            z-index: 200;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
        }
    </style>
</head>

<body>
    @include('producteur.layout')
    <header class="h"><a href="{{ route('producteur.commandes-recues') }}" class="bb"><i class="ph ph-arrow-left"></i></a>
        <div class="ttl">Commande #045</div>
    </header>
    <div class="c">
        <div class="al"><i class="ph-fill ph-clock" style="font-size:1.5rem"></i>
            <div>
                <div>Confirmation requise</div>
                <div style="font-size:.85rem;font-weight:400">Il reste <span id="tm">3h 45min</span> avant annulation
                    auto.</div>
            </div>
        </div>
        <div class="cd">
            <h3 style="margin-bottom:1rem;font-size:1.1rem">Détails</h3>
            <div class="dr"><span>Client</span><span style="font-weight:600">Jean Dupont</span></div>
            <div class="dr"><span>Articles</span><span>2 x Igname Kponan</span></div>
            <div class="dr"><span>Mode de paiement</span><span>Mobile Money</span></div>
            <div class="dr tot"><span>Total à encaisser</span><span>30 000 FCFA</span></div>
            <div class="status-pill"><i class="ph ph-clock-counter-clockwise"></i> En attente de confirmation</div>
            <div class="ab">
                <h4><i class="ph-fill ph-map-pin"></i> Adresse de livraison</h4>
                <p>Quartier Haie Vive, Rue des Palmiers<br>Cotonou, Bénin<br>Tél: 97 00 00 00</p>
            </div>
            <div class="ag">
                <button class="btn br" onclick="handleAction('refuse')"><i class="ph ph-x"></i> Refuser</button>
                <button class="btn bg" onclick="handleAction('accept')"><i class="ph ph-check"></i> Accepter</button>
            </div>
        </div>
    </div>
    <div class="toast" id="toast"></div>
    <script>
        let t = 3 * 3600 + 45 * 60;
        const timer = setInterval(() => {
            t--;
            if (t <= 0) {
                t = 0;
                clearInterval(timer);
            }
            document.getElementById('tm').textContent = Math.floor(t / 3600) + 'h ' + Math.floor((t % 3600) / 60) + 'min';
        }, 60000);

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2200);
        }

        function handleAction(action) {
            const message = action === 'accept'
                ? 'Commande acceptée avec succès.'
                : 'Commande refusée.';

            if (confirm(action === 'accept' ? 'Confirmer cette commande ?' : 'Refuser cette commande ?')) {
                showToast(message);
                setTimeout(() => {
                    window.location.href = "{{ route('producteur.commandes-recues') }}";
                }, 900);
            }
        }
    </script>
</body>

</html>