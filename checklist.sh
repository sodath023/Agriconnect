#!/bin/bash

# 📋 CHECKLIST D'IMPLÉMENTATION - Système de Paiement Mobile Money Simulé
# Utilisez ce script pour vérifier que tout est en place

echo "🔍 Vérification de l'installation du système de paiement..."
echo ""

# Couleurs
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Compteurs
PASSED=0
FAILED=0

# Fonction pour vérifier un fichier
check_file() {
    local filepath=$1
    local description=$2
    
    if [ -f "$filepath" ]; then
        echo -e "${GREEN}✓${NC} $description"
        PASSED=$((PASSED+1))
    else
        echo -e "${RED}✗${NC} $description (fichier manquant: $filepath)"
        FAILED=$((FAILED+1))
    fi
}

# Fonction pour vérifier un répertoire
check_dir() {
    local filepath=$1
    local description=$2
    
    if [ -d "$filepath" ]; then
        echo -e "${GREEN}✓${NC} $description"
        PASSED=$((PASSED+1))
    else
        echo -e "${RED}✗${NC} $description (dossier manquant: $filepath)"
        FAILED=$((FAILED+1))
    fi
}

# Fonction pour vérifier le contenu d'un fichier
check_content() {
    local filepath=$1
    local pattern=$2
    local description=$3
    
    if grep -q "$pattern" "$filepath" 2>/dev/null; then
        echo -e "${GREEN}✓${NC} $description"
        PASSED=$((PASSED+1))
    else
        echo -e "${RED}✗${NC} $description"
        FAILED=$((FAILED+1))
    fi
}

echo "📁 VÉRIFICATION DES FICHIERS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_file "database/migrations/2026_07_22_000000_add_payment_fields_to_paiements.php" "Migration des champs de paiement"
check_file "app/Http/Controllers/PaymentController.php" "Contrôleur de paiement"
check_file "app/Services/MobileMoneySimulationService.php" "Service de simulation"
check_file "resources/views/payment/payment-page.blade.php" "Vue de page de paiement"
check_file "resources/views/payment/confirmation.blade.php" "Vue de confirmation"
check_file "resources/views/layouts/app.blade.php" "Layout d'application"
check_file "config/payment.php" "Configuration de paiement"
check_file "tests/Feature/PaymentSimulationTest.php" "Tests du paiement"

echo ""
echo "🔗 VÉRIFICATION DES ROUTES"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_content "routes/web.php" "payment.show" "Route GET /payment/{order}"
check_content "routes/web.php" "payment.initialize" "Route POST /payment/initialize"
check_content "routes/web.php" "payment.verify" "Route POST /payment/verify"
check_content "routes/web.php" "payment.confirmation" "Route GET /payment/{order}/confirmation"
check_content "routes/web.php" "payment.retry" "Route GET /payment/{order}/retry"
check_content "routes/web.php" "PaymentController" "Import du contrôleur PaymentController"

echo ""
echo "📊 VÉRIFICATION DES MODÈLES"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_content "app/Models/Paiement.php" "phone_number" "Champ phone_number dans le modèle"
check_content "app/Models/Paiement.php" "operator" "Champ operator dans le modèle"
check_content "app/Models/Paiement.php" "payment_date" "Champ payment_date dans le modèle"
check_content "app/Models/Paiement.php" "failure_reason" "Champ failure_reason dans le modèle"
check_content "app/Models/Paiement.php" "casts" "Casts pour datetime"

echo ""
echo "🧪 VÉRIFICATION DES TESTS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_content "tests/Feature/PaymentSimulationTest.php" "test_access_payment_page" "Test d'accès à la page"
check_content "tests/Feature/PaymentSimulationTest.php" "test_initialize_payment_with_valid_data" "Test d'initialisation"
check_content "tests/Feature/PaymentSimulationTest.php" "test_verify_payment_result" "Test de vérification"

echo ""
echo "📚 VÉRIFICATION DE LA DOCUMENTATION"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_file "PAYMENT_SIMULATION_README.md" "Documentation principale"
check_file "INSTALLATION_GUIDE.md" "Guide d'installation"
check_file "PAYMENT_CONTROLLER_ALTERNATIVE.php" "Exemple de contrôleur avec Service"

echo ""
echo "📋 RÉSUMÉ"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

TOTAL=$((PASSED + FAILED))
echo -e "${GREEN}✓ Réussis: $PASSED${NC}"
echo -e "${RED}✗ Échoués: $FAILED${NC}"
echo "Total: $TOTAL"

echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}🎉 TOUS LES FICHIERS SONT EN PLACE!${NC}"
    echo ""
    echo "⚙️ Prochaines étapes:"
    echo "1. Exécuter la migration: php artisan migrate"
    echo "2. Modifier CommandeController pour rediriger vers /payment/{order}"
    echo "3. Tester la page de paiement"
    echo "4. Exécuter les tests: php artisan test"
    exit 0
else
    echo -e "${YELLOW}⚠️  CERTAINS FICHIERS SONT MANQUANTS${NC}"
    echo ""
    echo "Assurez-vous d'avoir créé tous les fichiers listés ci-dessus."
    exit 1
fi
