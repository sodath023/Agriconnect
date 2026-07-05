<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations & Support - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--g:#1A6B3C;--o:#C17F3B;--bg:#F9FAFB;--t:#1F2937;--tl:#6B7280;--w:#FFF;--r:12px}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
        body{background:var(--bg);color:var(--t)}
        .dn{background:#111827;color:white;padding:1rem;position:sticky;top:0;z-index:100;display:flex;gap:.5rem;overflow-x:auto}
        .dn button{background:rgba(255,255,255,.1);border:none;color:white;padding:.5rem 1rem;border-radius:8px;cursor:pointer;white-space:nowrap;font-family:inherit;font-size:.85rem;transition:all .2s}.dn button.act{background:var(--g)}
        .c{max-width:800px;margin:0 auto;padding:2rem 1rem}
        .ps{display:none;animation:fi .4s ease}.ps.act{display:block}@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        h1{font-size:1.5rem;font-weight:800;color:var(--g);margin-bottom:1rem}h2{font-size:1.1rem;font-weight:700;margin:1.5rem 0 .5rem}p{margin-bottom:1rem;color:var(--tl);font-size:.95rem;line-height:1.7}
        .cd{background:var(--w);padding:1.5rem;border-radius:var(--r);box-shadow:0 4px 6px rgba(0,0,0,.05);margin-bottom:1.5rem}
        .fg{margin-bottom:1rem}.lb{display:block;font-size:.85rem;font-weight:600;margin-bottom:.4rem}.inp{width:100%;padding:.8rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:1rem;min-height:48px}.inp:focus{outline:none;border-color:var(--g)}
        .btn{width:100%;padding:.875rem;background:var(--g);color:white;border:none;border-radius:8px;font-weight:600;cursor:pointer;min-height:48px;transition:all .3s}.btn:hover{background:#124d2b}
        .e4{text-align:center;padding:4rem 1rem}.e4 i{font-size:4rem;color:var(--o);margin-bottom:1rem}.e4 h1{color:var(--t);font-size:2rem}
        .bo{background:transparent;border:1.5px solid var(--g);color:var(--g);margin-top:1rem;display:inline-block;width:auto;padding:.875rem 2rem;text-decoration:none;font-weight:600}.bo:hover{background:var(--g);color:white}
    </style>
</head>
<body>
    <nav class="dn">
        <button class="act" onclick="sp('pwd',this)">Mot de passe</button>
        <button onclick="sp('about',this)">À propos</button>
        <button onclick="sp('cgu',this)">CGU & Confidentialité</button>
        <button onclick="sp('404',this)">Erreur 404</button>
    </nav>
    <main class="c">
        <div id="pwd" class="ps act"><div class="cd" style="max-width:400px;margin:2rem auto"><h1 style="text-align:center"><i class="ph ph-lock-key"></i> Réinitialisation</h1><p style="text-align:center">Entrez votre e-mail ou téléphone. Nous vous enverrons un code sécurisé pour créer un nouveau mot de passe.</p>
        <form onsubmit="event.preventDefault();alert('Code de réinitialisation envoyé par SMS !')"><div class="fg"><label class="lb">E-mail ou Téléphone</label><input type="text" class="inp" placeholder="ex: 97 00 00 00 ou jean@email.com" required></div><button type="submit" class="btn">Envoyer le code</button></form>
        <p style="text-align:center;margin-top:1rem"><a href="connexion.html" style="color:var(--g);text-decoration:none;font-weight:600">← Retour à la connexion</a></p></div></div>
        <div id="about" class="ps"><div class="cd"><h1>À propos d'AgriConnect</h1><p><strong>Notre Mission :</strong> AgriConnect est une plateforme numérique qui connecte directement les producteurs agricoles aux acheteurs potentiels. Nous visons à améliorer les revenus des agriculteurs, sécuriser l'approvisionnement des acheteurs et contribuer à la souveraineté alimentaire en Afrique de l'Ouest.</p><h2>Nos Valeurs</h2><ul style="margin-left:1.5rem;color:var(--tl);margin-bottom:1rem"><li><strong>Équité :</strong> Supprimer les intermédiaires abusifs pour une rémunération juste.</li><li><strong>Transparence :</strong> Des prix clairs et une traçabilité complète des produits.</li><li><strong>Innovation :</strong> Utiliser la technologie mobile pour servir les zones rurales et urbaines.</li></ul><h2>Zone de déploiement</h2><p>Déploiement pilote au <strong>Bénin</strong>, avec une architecture cloud extensible à toute la zone UEMOA.</p></div></div>
        <div id="cgu" class="ps"><div class="cd"><h1>Mentions Légales & Confidentialité</h1><h2>1. Conditions Générales d'Utilisation (CGU)</h2><p>En utilisant AgriConnect, vous acceptez les présentes conditions. La plateforme agit comme un intermédiaire technique de mise en relation. Les transactions sont soumises à une <strong>commission de 3 à 5%</strong> prélevée automatiquement. Les producteurs s'engagent à fournir des produits conformes aux descriptions. Les acheteurs s'engagent à honorer les commandes validées. Tout litige sera traité par notre service support sous 72h.</p><h2>2. Politique de Confidentialité</h2><p><strong>Conformité réglementaire :</strong> AgriConnect respecte le <strong>RGPD</strong> et la <strong>Loi n°2009-09 du Bénin</strong> relative à la protection des données à caractère personnel. <strong>Données collectées :</strong> Nom, téléphone, e-mail, localisation GPS (pour la livraison), et pièce d'identité (KYC producteur). Ces données ne sont jamais vendues à des tiers. <strong>Paiements :</strong> Les données de paiement sont traitées par des passerelles sécurisées (CinetPay, FedaPay) conformes aux normes <strong>PCI-DSS</strong> et aux réglementations de la <strong>BCEAO</strong>. <strong>Vos droits :</strong> Accès, rectification, suppression via dpo@agriconnect.bj.</p></div></div>
        <div id="404" class="ps"><div class="e4"><i class="ph ph-warning-circle"></i><h1>Page introuvable (404)</h1><p>Oups ! Le produit ou la page que vous cherchez a peut-être été récolté... ou déplacé.</p><a href="index.html" class="bo">Retour à l'accueil</a></div></div>
    </main>
    <script>function sp(id,btn){document.querySelectorAll('.ps').forEach(e=>e.classList.remove('act'));document.querySelectorAll('.dn button').forEach(e=>e.classList.remove('act'));document.getElementById(id).classList.add('act');btn.classList.add('act')}</script>
</body>
</html>