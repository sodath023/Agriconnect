<?php

use App\Models\Category;
use App\Models\commande;
use App\Models\ElementPanier;
use App\Models\Lignecommande;
use App\Models\Panier;
use App\Models\Product;
use App\Models\User;
use App\Services\FedaPayService;
use Illuminate\Support\Facades\Hash;

it('renders the main producteur pages for an authenticated producer', function () {
    $user = User::factory()->create([
        'name' => 'Producteur Test',
        'email' => 'producteur-pages@example.com',
        'telephone' => '97000001',
        'role' => 'producteur',
        'password' => Hash::make('password123'),
    ]);

    $this->actingAs($user);

    $this->get('/dashboard-producteur')->assertOk();
    $this->get('/commandes-recues')->assertOk();
    $this->get('/creer-annonce')->assertOk();
    $this->get('/mes-products')->assertOk();
    $this->get('/mes-revenus')->assertOk();
    $this->get('/detail-commandes-recues')->assertOk();
    $this->get('/confirmation')->assertOk();
});

it('shows real orders for the authenticated producer', function () {
    $user = User::factory()->create([
        'name' => 'Producteur Orders',
        'email' => 'producteur-orders@example.com',
        'telephone' => '97000002',
        'role' => 'producteur',
        'password' => Hash::make('password123'),
    ]);

    $category = Category::create([
        'name' => 'Légumes',
        'slug' => 'legumes',
        'icon' => 'leaf',
        'description' => 'Légumes',
    ]);

    $product = Product::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'nom' => 'Igname',
        'description' => 'Igname locale',
        'prix' => 1200,
        'stock' => 20,
        'unite' => 'kg',
        'statut' => 'valide',
    ]);

    $commande = commande::create([
        'reference' => 'CMD-TEST-001',
        'firstname' => 'Alice',
        'lastname' => 'Dossou',
        'email' => 'alice@example.com',
        'phone' => '97000003',
        'address' => 'Abomey',
        'city' => 'Cotonou',
        'subtotal' => 2400,
        'total' => 2400,
        'status' => 'pending',
    ]);

    Lignecommande::create([
        'commande_id' => $commande->id,
        'product_id' => $product->id,
        'name' => 'Igname',
        'unit_price' => 1200,
        'quantity' => 2,
    ]);

    $this->actingAs($user);

    $this->get('/commandes-recues')
        ->assertOk()
        ->assertSee('CMD-TEST-001')
        ->assertSee('Alice Dossou')
        ->assertSee('Igname');
});

it('allows a producer to accept an order', function () {
    $user = User::factory()->create([
        'name' => 'Producteur Orders',
        'email' => 'producteur-orders-accept@example.com',
        'telephone' => '97000004',
        'role' => 'producteur',
        'password' => Hash::make('password123'),
    ]);

    $category = Category::create([
        'name' => 'Fruits',
        'slug' => 'fruits',
        'icon' => 'fruit',
        'description' => 'Fruits',
    ]);

    $product = Product::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'nom' => 'Mangue',
        'description' => 'Mangue locale',
        'prix' => 1500,
        'stock' => 10,
        'unite' => 'kg',
        'statut' => 'valide',
    ]);

    $commande = commande::create([
        'reference' => 'CMD-TEST-002',
        'firstname' => 'Bob',
        'lastname' => 'Kouassi',
        'email' => 'bob@example.com',
        'phone' => '97000005',
        'address' => 'Porto-Novo',
        'city' => 'Porto-Novo',
        'subtotal' => 3000,
        'total' => 3000,
        'status' => 'pending',
    ]);

    Lignecommande::create([
        'commande_id' => $commande->id,
        'product_id' => $product->id,
        'name' => 'Mangue',
        'unit_price' => 1500,
        'quantity' => 2,
    ]);

    $this->actingAs($user);

    $this->post('/commandes-recues/' . $commande->id . '/statut', ['action' => 'accept'])
        ->assertRedirect('/commandes-recues');

    $commande->refresh();
    expect($commande->status)->toBe('confirmed');
});

it('redirects to the catalogue when the product detail route is opened without an id', function () {
    $this->get('/produit')
        ->assertRedirect('/catalogue');
});

it('shows orders created during checkout in the producer inbox', function () {
    $producer = User::factory()->create([
        'name' => 'Producteur Checkout',
        'email' => 'producteur-checkout@example.com',
        'telephone' => '97000006',
        'role' => 'producteur',
        'password' => Hash::make('password123'),
    ]);

    $category = Category::create([
        'name' => 'Racines',
        'slug' => 'racines',
        'icon' => 'root',
        'description' => 'Racines',
    ]);

    $product = Product::create([
        'user_id' => $producer->id,
        'category_id' => $category->id,
        'nom' => 'Patate',
        'description' => 'Patate locale',
        'prix' => 1800,
        'stock' => 15,
        'unite' => 'kg',
        'statut' => 'valide',
    ]);

    $buyer = User::factory()->create([
        'name' => 'Acheteur Checkout',
        'email' => 'acheteur-checkout@example.com',
        'telephone' => '97000007',
        'role' => 'acheteur',
        'password' => Hash::make('password123'),
    ]);

    $cart = Panier::create(['user_id' => $buyer->id]);
    ElementPanier::create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'quantite' => 3,
    ]);

    app()->instance(FedaPayService::class, new class extends FedaPayService {
        public function __construct()
        {
        }

        public function createTransaction(array $data): \FedaPay\Transaction
        {
            return new \FedaPay\Transaction();
        }

        public function generatePaymentUrl(\FedaPay\Transaction $transaction): string
        {
            return 'https://example.com/pay';
        }
    });

    $this->actingAs($buyer);

    $this->post('/checkout', [
        'firstname' => 'Jean',
        'lastname' => 'Dupont',
        'email' => 'jean@example.com',
        'phone' => '97000008',
        'address' => 'Abomey',
        'city' => 'Cotonou',
        'notes' => 'Livraison rapide',
        'adresse_livraison' => 'Abomey',
        'mode_livraison' => 'livraison',
        'mode_paiement' => 'cash',
    ])->assertRedirectContains('http');

    $this->actingAs($producer);

    $this->get('/commandes-recues')
        ->assertOk()
        ->assertSee('Patate');
});
