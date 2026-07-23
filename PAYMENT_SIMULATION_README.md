# 📱 Système de Paiement Mobile Money Simulé - AgriConnect

## 📋 Vue d'ensemble

Ce système simule un processus de paiement par mobile money (MTN Mobile Money et Moov Money) pour la plateforme AgriConnect. **C'est une simulation complète sans connexion à des API réelles.**

## 🚀 Installation et Configuration

### 1️⃣ Exécuter la migration

Après avoir créé le fichier de migration, exécutez :

```bash
php artisan migrate
```

Cela ajoutera les champs suivants à la table `paiements` :
- `phone_number` - Numéro de téléphone pour le paiement
- `operator` - Opérateur choisi (MTN ou Moov)
- `payment_date` - Date et heure du paiement
- `failure_reason` - Motif d'échec (si applicable)

### 2️⃣ Vérifier les routes

Les routes suivantes sont maintenant disponibles :

```
GET  /payment/{order}              → Afficher la page de paiement
POST /payment/initialize           → Initialiser un paiement
POST /payment/verify               → Vérifier le statut du paiement
GET  /payment/{order}/confirmation → Afficher la confirmation
GET  /payment/{order}/retry        → Réessayer après échec
```

### 3️⃣ Modifier le flux de checkout

Si vous avez une route qui redirige actuellement vers un paiement FedaPay, modifiez-la pour rediriger vers `/payment/{order}` à la place.

Exemple dans votre contrôleur de commande :

```php
// Après avoir créé la commande
return redirect()->route('payment.show', ['order' => $order->id]);
```

## 🎯 Fonctionnalités

### ✅ Page de Paiement

- **Choix d'opérateur** : Boutons pour sélectionner MTN ou Moov
- **Saisie du téléphone** : Validation du format
- **Récapitulatif** : Affichage de la commande et du montant total
- **Conditions** : Checkbox d'acceptation

### ⏳ Simulation du Paiement

1. **Étape 1** : Clic sur "Confirmer le paiement"
2. **Étape 2** : Affichage d'un modal "Traitement du paiement..."
3. **Étape 3** : Attente de 3 secondes (simulation du traitement)
4. **Étape 4** : Résultat aléatoire (90% succès, 10% échec)

### ✅ Succès

- Le paiement passe au statut `SUCCESS`
- La commande passe au statut `confirmed`
- Redirection vers la page de confirmation
- Affichage d'un ticket de paiement imprimable

### ❌ Échec

- Le paiement passe au statut `FAILED`
- Un motif d'échec est généré aléatoirement
- L'utilisateur voit un message d'erreur
- Possibilité de réessayer

## 📁 Fichiers Créés/Modifiés

### Fichiers Créés

```
database/migrations/2026_07_22_000000_add_payment_fields_to_paiements.php
app/Http/Controllers/PaymentController.php
resources/views/payment/payment-page.blade.php
resources/views/payment/confirmation.blade.php
resources/views/layouts/app.blade.php
```

### Fichiers Modifiés

```
app/Models/Paiement.php                    (ajout des fillable et casts)
routes/web.php                             (ajout des routes de paiement)
```

## 🧪 Test du Système

### Test 1 : Accès à la page de paiement

```bash
# Accédez directement à :
/payment/{order_id}

# Exemple :
/payment/1
```

### Test 2 : Simulation du paiement réussi

1. Allez sur la page de paiement
2. Sélectionnez "MTN Mobile Money"
3. Entrez un numéro de téléphone valide (ex: 6 12 34 56 78)
4. Acceptez les conditions
5. Cliquez "Confirmer le paiement"
6. **Résultat** : 90% de chance de succès → Redirection vers confirmation

### Test 3 : Simulation du paiement échoué

- Réessayez plusieurs fois jusqu'à obtenir un échec (10% de chance)
- Vous verrez un message d'erreur et un motif
- Cliquez "Réessayer" pour recommencer

## 🔧 Personnalisation

### Modifier le taux de succès/échec

Dans `PaymentController.php`, à la ligne ~180 :

```php
// Par défaut : 90% succès, 10% échec
$isSuccess = rand(1, 100) <= 90;

// Modifier à :
$isSuccess = rand(1, 100) <= 80;  // 80% succès
```

### Modifier le délai de simulation

Dans la vue `payment-page.blade.php`, ligne ~280 :

```javascript
// Attendre 3 secondes
await new Promise(resolve => setTimeout(resolve, 3000));

// Modifier à :
await new Promise(resolve => setTimeout(resolve, 5000));  // 5 secondes
```

### Modifier les motifs d'échec

Dans `PaymentController.php`, ligne ~190 :

```php
$failureReasons = [
    'Solde insuffisant sur le compte mobile money.',
    'Mauvais code PIN entré.',
    'Délai d\'expiration du paiement dépassé.',
    'Opérateur temporairement indisponible.',
];
```

Ajoutez ou modifiez les messages selon vos besoins.

### Ajouter d'autres opérateurs

1. Dans le contrôleur `PaymentController`, modifiez la liste :

```php
'operators' => [
    'MTN' => ['name' => 'MTN Mobile Money', 'color' => 'warning', 'icon' => '📱'],
    'Moov' => ['name' => 'Moov Money', 'color' => 'info', 'icon' => '💳'],
    'Airtel' => ['name' => 'Airtel Money', 'color' => 'danger', 'icon' => '💰'],
]
```

2. Mettez à jour l'enum dans la migration :

```php
$table->enum('operator', ['MTN', 'Moov', 'Airtel'])->nullable();
```

## 💾 Données Stockées en Base de Données

Chaque paiement simulé crée un enregistrement dans la table `paiements` :

| Champ | Type | Exemple |
|-------|------|---------|
| id | INT | 1 |
| commande_id | INT | 5 |
| montant | DECIMAL | 15000.00 |
| methode | STRING | MTN |
| phone_number | STRING | +237 612345678 |
| operator | ENUM | MTN |
| reference | STRING | SIM-1721663400-507f3a |
| statut | ENUM | SUCCESS/FAILED/PENDING |
| payment_date | TIMESTAMP | 2026-07-22 10:30:45 |
| failure_reason | TEXT | Solde insuffisant... |
| created_at | TIMESTAMP | 2026-07-22 10:30:40 |
| updated_at | TIMESTAMP | 2026-07-22 10:30:50 |

## 🎨 Design et UX

### Couleurs

- **Succès** : Vert (#10B981)
- **Erreur** : Rouge (#EF4444)
- **Attente** : Jaune (#F59E0B)
- **Info** : Bleu (#3B82F6)

### Responsive

- ✅ Mobile-friendly
- ✅ Tablette-friendly
- ✅ Desktop-friendly

### Accessibilité

- ✅ Contraste de couleur adéquat
- ✅ Boutons et inputs de taille convenable (min 48px)
- ✅ Texte explicite et lisible
- ✅ Animations réduites pour les appareils qui les demandent

## 🔒 Sécurité (Note Importante)

**Cette implémentation est une SIMULATION à des fins de développement/test UNIQUEMENT.**

En production, vous devriez :

1. ✅ Implémenter une vraie intégration avec une API de paiement (FedaPay, Stripe, etc.)
2. ✅ Utiliser HTTPS pour toutes les routes de paiement
3. ✅ Valider tous les paiements côté serveur
4. ✅ Utiliser des jetons (tokens) pour les paiements récurrents
5. ✅ Implémenter les webhooks de confirmation du paiement
6. ✅ Chiffrer les données sensibles (numéros de téléphone)
7. ✅ Ajouter des logs d'audit complets
8. ✅ Tester avec des outils de sécurité (OWASP Top 10)

## 🐛 Dépannage

### Problème : "Cette commande ne peut pas être payée"

**Cause** : Le statut de la commande n'est pas `pending`.

**Solution** : Vérifiez que la commande a le statut `pending` en base de données.

### Problème : Erreur "Paiement invalide pour cette commande"

**Cause** : Les IDs de paiement et de commande ne correspondent pas.

**Solution** : Assurez-vous que le formulaire envoie les bons IDs.

### Problème : Le modal de traitement ne s'affiche pas

**Cause** : Erreur JavaScript ou les styles CSS ne chargent pas.

**Solution** : Ouvrez la console du navigateur (F12) et vérifiez les erreurs.

## 📞 Support du Développeur

### Questions Courantes

**Q: Comment changer le pourcentage de succès?**
R: Voir la section "Modifier le taux de succès/échec" ci-dessus.

**Q: Comment ajouter une vraie intégration API?**
R: Créez un nouveau Service (ex: `MobileMoneyPaymentService.php`) et remplacez la logique de simulation dans `PaymentController`.

**Q: Comment supprimer les données de test?**
R: 
```bash
DELETE FROM paiements WHERE created_at > '2026-07-22 00:00:00';
```

## 📝 Logs et Monitoring

Pour surveiller les paiements, ajoutez des logs :

```php
// Dans PaymentController.php
Log::info('Paiement initialisé', [
    'order_id' => $order->id,
    'operator' => $validated['operator'],
    'amount' => $order->total,
]);
```

## 🎓 Exemple de Flux Complet

1. L'acheteur ajoute des produits au panier
2. L'acheteur valide sa commande
3. Redirection vers `/payment/{order_id}`
4. L'acheteur choisit l'opérateur et rentre son numéro
5. Clic sur "Confirmer le paiement"
6. Simulation du traitement (3 secondes)
7. Résultat aléatoire (succès ou échec)
8. **Succès** : Redirection vers la confirmation
9. **Échec** : Message d'erreur et option de réessayer

---

**Développé pour AgriConnect - Simulation de paiement mobile money**
