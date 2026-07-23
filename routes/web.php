<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProducteurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\otpcontroller;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdresseLivraisonController;

Route::get('/', [PanierController::class, 'index'])->name('home');

Route::get('/login', function () {
    return redirect()->route('connexion');
})->name('login');

//route pour afficher la page de détail du produit
Route::get('/produit/{id?}', [PanierController::class, 'detailProduit'])->name('produit');

//route pour afficher la page de catalogue
Route::get('/catalogue', [PanierController::class, 'catalogue'])->name('catalogue');


//route pour afficher toute les  pages de l'acheteur

//route pour afficher la page de le dashboard du client
Route::get('/dashboard-acheteur', [ClientController::class, 'index'])->name('acheteur.dashboard');

//route pour afficher la page de mes commandes du client
Route::get('/mes-commandes', [ClientController::class, 'indexCommandes'])->name('acheteur.commandes');

//route pour afficher la page  de transversal du client
Route::get('/transversal', [ClientController::class, 'indexTransversal'])->name('acheteur.transversal');

//route pour afficher la page de detail de mes commandes du client
Route::get('/detail-commandes/{id}', [ClientController::class, 'indexdetailCommandes'])->name('acheteur.detail-commandes');

//route pour afficher la page de profil du client
Route::get('/profil-acheteur', [ClientController::class, 'profile'])->name('acheteur.profil');

//route pour mettre à jour le profil du client
Route::post('/profil-acheteur', [ClientController::class, 'updateProfile'])->name('acheteur.profil.update');
//route pour ajouter une adresse de livraison
Route::post('/adresse-livraison', [AdresseLivraisonController::class, 'store'])->name('acheteur.adresse-livraison.store');
//route pour mettre à jour une adresse de livraison
Route::put('/adresse-livraison/{id}', [AdresseLivraisonController::class, 'update'])->name('acheteur.adresse-livraison.update');
//route pour supprimer une adresse de livraison
Route::delete('/adresse-livraison/{id}', [AdresseLivraisonController::class, 'destroy'])->name('acheteur.adresse-livraison.destroy');


// route page producteur publique
Route::view('/producteur', 'profil-producteur-public')->name('producteur.public');

// route OTP simple
Route::get('/otp', [AuthController::class, 'showVerifyForm'])->name('otp.form');
Route::post('/otp', [AuthController::class, 'verifyPhone'])->name('otp.verify');
Route::get('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');

//Route de gestion de l'authentification
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthController::class, 'getconnexion'])->name('connexion');
    Route::post('/connexion', [AuthController::class, 'login'])->name('connexion.submit');

    Route::get('/inscription', [AuthController::class, 'getinscription'])->name('inscription');
    Route::post('/inscription', [AuthController::class, 'inscription'])->name('inscription.submit');
});


Route::get('/deconnexion', [AuthController::class, 'logout'])->name('deconnexion');

Route::get('/admin-dashboard.html', function () {
    return redirect()->route('admin.dashboard');
});
Route::get('/admin-moderation.html', function () {
    return redirect()->route('admin.moderation');
});
Route::get('/admin-parametres.html', function () {
    return redirect()->route('admin.parametres');
});
Route::get('/admin-utilisateurs.html', function () {
    return redirect()->route('admin.utilisateurs');
});

//
Route::middleware('auth')->group(function () {
    // Routes du panier client
    Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::get('/panier', [PanierController::class, 'panier'])->name('panier');
    Route::put('/panier/{item}', [PanierController::class, 'mettreAJour'])->name('panier.mettreAJour');
    Route::delete('/panier/{item}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
    Route::get('/checkout', [PanierController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CommandeController::class, 'store'])->name('checkout.process');
    
    // Routes de paiement (simulation mobile money)
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/initialize', [PaymentController::class, 'initializePayment'])->name('payment.initialize');
    Route::post('/payment/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
    Route::get('/payment/{order}/confirmation', [PaymentController::class, 'confirmation'])->name('payment.confirmation');
    Route::get('/payment/{order}/retry', [PaymentController::class, 'retryPayment'])->name('payment.retry');

    // Routes pour les produits
    Route::get('/admin/produits', [ProductController::class, 'index'])->name('admin.produits');
    Route::get('/admin/produits/create', [ProductController::class, 'create'])->name('admin.produits.create');
    Route::post('/admin/produits', [ProductController::class, 'store'])->name('admin.produits.store');
    Route::get('/admin/produits/{id}/edit', [ProductController::class, 'edit'])->name('admin.produits.edit');
    Route::put('/admin/produits/{id}', [ProductController::class, 'update'])->name('admin.produits.update');
    Route::delete('/admin/produits/{id}', [ProductController::class, 'destroy'])->name('admin.produits.destroy');

    // Routes pour les catégories
    Route::prefix('admin')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
        
    });

    //route pour afficher toute les pages de l'admin

        //route pour afficher la page de dashboard de l'admin
        Route::get('/dashboard-admin', [AdminController::class, 'indexdashboardadmin'])->name('admin.dashboard');
        
        //route pour afficher la page de moderation de l'admin
        Route::get('/moderation-admin', [AdminController::class, 'indexmoderationadmin'])->name('admin.moderation');

        //route pour afficher la page de paramètres de l'admin
        Route::get('/parametres-admin', [AdminController::class, 'indexparametresadmin'])->name('admin.parametres');

        //route pour afficher la page de gestion des utilisateurs de l'admin
        Route::get('/utilisateurs-admin', [AdminController::class, 'indexutilisateursadmin'])->name('admin.utilisateurs');
        Route::get('/utilisateurs-admin/export-pdf', [AdminController::class, 'exportUsersPdf'])->name('admin.utilisateurs.export-pdf');

        //route pour valider un produit par l'admin
        Route::post('/moderation-admin/valider-produit/{id}', [AdminController::class, 'validerProduit'])->name('admin.moderation.valider-produit');

        //route pour rejeter un produit par l'admin
        Route::post('/moderation-admin/rejeter-produit/{id}', [AdminController::class, 'rejeterProduit'])->name('admin.moderation.rejeter-produit');
    //route pour afficher toute les pages de producteur

    //route pour afficher la page de commandes reçues du producteur
    Route::get('/commandes-recues', [ProducteurController::class, 'indexcommandesRecues'])->name('producteur.commandes-recues');
    Route::post('/commandes-recues/{commande}/statut', [ProducteurController::class, 'updateOrderStatus'])->name('producteur.commandes-statut');

    //route pour afficher la page de confirmation du producteur
    Route::get('/confirmation', [ProducteurController::class, 'indexconfirmation'])->name('producteur.confirmation');

    //route pour afficher la page de dashboard du producteur
    Route::get('/dashboard-producteur', [ProducteurController::class, 'indexdashboardproducteur'])->name('producteur.dashboard');

    //route pour afficher la page de creer annonce du producteur
    Route::get('/creer-annonce', [ProducteurController::class, 'indexcreerAnnonce'])->name('producteur.creer-annonce');
    //route pour publier une annonce du producteur
    Route::post('/publier-annonce', [ProductController::class, 'store'])->name('producteur.publier-annonce');
    Route::get('/editer-annonce/{id}', [ProductController::class, 'edit'])->name('editer-annonce');
    Route::put('/editer-annonce/{id}', [ProductController::class, 'update'])->name('update-annonce');
    Route::delete('/supprimer-annonce/{id}', [ProductController::class, 'destroy'])->name('supprimer-annonce');
    //route pour afficher la page de detail des commandes reçues du producteur
    Route::get('/detail-commandes-recues', [ProducteurController::class, 'indexdetailCommandesRecues'])->name('producteur.detail-commandes-recues');

    //route pour afficher la page de mes produits du producteur

    Route::get('/mes-products', [ProducteurController::class, 'indexmesProducts'])->name('producteur.mes-produits');

    //route pour afficher la page de mes revenus du producteur
    Route::get('/mes-revenus', [ProducteurController::class, 'indexmesRevenus'])->name('producteur.mes-revenus');

});

