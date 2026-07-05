<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Confirmée - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--o:#C17F3B;--bg:#F9FAFB;--t:#1F2937;--tl:#6B7280;--w:#FFF;--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t);min-height:100vh;display:flex;flex-direction:column}
        .c{max-width:600px;margin:0 auto;padding:3rem 1rem;flex:1;display:flex;flex-direction:column;align-items:center;text-align:center}
        .ic{width:80px;height:80px;background:#eef5f1;color:var(--g);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin-bottom:1.5rem;animation:pop .5s cubic-bezier(.175,.885,.32,1.275)}
        @keyframes pop{from{transform:scale(0) rotate(-45deg)}to{transform:scale(1) rotate(0)}}
        h1{font-size:1.5rem;font-weight:800;color:var(--g);margin-bottom:.5rem}.sub{color:var(--tl);margin-bottom:2rem}
        .on{background:var(--w);padding:.75rem 1.5rem;border-radius:var(--r);font-weight:700;font-size:1.1rem;border:1px dashed var(--g);margin-bottom:2rem;box-shadow:0 4px 6px rgba(0,0,0,.05)}
        .sum{background:var(--w);border-radius:var(--r);padding:1.5rem;width:100%;box-shadow:0 4px 6px rgba(0,0,0,.05);text-align:left;margin-bottom:2rem}
        .row{display:flex;justify-content:space-between;margin-bottom:.75rem;font-size:.9rem;color:var(--tl)}.row.t{border-top:1px dashed #e5e7eb;padding-top:.75rem;margin-top:.75rem;font-weight:800;font-size:1.1rem;color:var(--t)}.row.t span:last-child{color:var(--g);font-size:1.25rem}
        .btn{width:100%;max-width:400px;padding:.875rem;border-radius:var(--r);font-weight:600;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.5rem;margin-bottom:.75rem;min-height:48px;transition:all .3s}
        .bp{background:var(--g);color:white}.bp:hover{background:#124d2b;transform:translateY(-2px)}.bo{background:transparent;border:1.5px solid #d1d5db;color:var(--t)}.bo:hover{background:#f9fafb}
        .steps{width:100%;text-align:left;margin-bottom:2rem}.st{display:flex;gap:1rem;margin-bottom:1rem;align-items:flex-start}.sn{width:28px;height:28px;background:var(--g);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0}.st h4{font-size:.95rem;font-weight:600}.st p{font-size:.85rem;color:var(--tl)}
    </style>
</head>
<body>
    @include('producteur.layout')
    <div class="c">
        <div class="ic"><i class="ph-fill ph-check-circle"></i></div>
        <h1>Commande confirmée !</h1>
        <p class="sub">Merci pour votre achat. Le producteur a été notifié et prépare votre commande en temps réel.</p>
        <div class="on">N° CMD-2026-045</div>
        <div class="sum">
            <div class="row"><span>2 x Igname Kponan</span><span>30 000 FCFA</span></div>
            <div class="row"><span>Frais de livraison</span><span>1 500 FCFA</span></div>
            <div class="row t"><span>Total payé (MTN MoMo)</span><span>31 500 FCFA</span></div>
        </div>
        <div class="steps">
            <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem">Prochaines étapes :</h3>
            <div class="st"><div class="sn">1</div><div><h4>Confirmation du producteur</h4><p>Vous recevrez un SMS sous 4h maximum.</p></div></div>
            <div class="st"><div class="sn">2</div><div><h4>Expédition & Traçabilité</h4><p>Un livreur partenaire prendra en charge votre colis.</p></div></div>
            <div class="st"><div class="sn">3</div><div><h4>Livraison à domicile</h4><p>Quartier Haie Vive, Cotonou. Paiement sécurisé garanti.</p></div></div>
        </div>
        <a href="{{ route('acheteur.dashboard') }}" class="btn bp"><i class="ph ph-package"></i> Suivre ma commande</a>
        <a href="{{ route('home') }}" class="btn bo"><i class="ph ph-house"></i> Retour à l'accueil</a>
    </div>
</body>
</html>