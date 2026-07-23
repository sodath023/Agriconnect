<?php

namespace Tests\Feature;

use App\Models\commande as Commande;
use App\Models\paiement as Paiement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests pour le système de paiement simulé
 * 
 * Utilisation: php artisan test tests/Feature/PaymentSimulationTest.php
 */
class PaymentSimulationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Commande $order;

    /**
     * Setup : créer un utilisateur et une commande de test
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Créer un utilisateur
        $this->user = User::factory()->create();

        // Créer une commande de test
        $this->order = Commande::create([
            'reference' => 'TEST-' . time(),
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'phone' => '+237612345678',
            'address' => '123 Rue de Test',
            'city' => 'Yaoundé',
            'notes' => 'Test order',
            'subtotal' => 10000,
            'shipping_fee' => 1000,
            'total' => 11000,
            'status' => 'pending',
        ]);
    }

    /**
     * Test 1 : Accès à la page de paiement
     */
    public function test_access_payment_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('payment.show', ['order' => $this->order->id]));

        $response->assertStatus(200);
        $response->assertViewIs('payment.payment-page');
        $response->assertViewHas('order', $this->order);
    }

    /**
     * Test 2 : Initialiser un paiement avec données valides
     */
    public function test_initialize_payment_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('payment.initialize'), [
                'order_id' => $this->order->id,
                'operator' => 'MTN',
                'phone_number' => '612345678',
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message', 'payment_id', 'order_id']);
        $response->assertJson(['success' => true]);

        // Vérifier que le paiement a été créé en base
        $this->assertDatabaseHas('paiements', [
            'commande_id' => $this->order->id,
            'operator' => 'MTN',
            'statut' => 'PENDING',
        ]);
    }

    /**
     * Test 3 : Initialiser un paiement avec numéro invalide
     */
    public function test_initialize_payment_with_invalid_phone(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('payment.initialize'), [
                'order_id' => $this->order->id,
                'operator' => 'MTN',
                'phone_number' => '123', // Trop court
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('phone_number');
    }

    /**
     * Test 4 : Initialiser un paiement avec opérateur invalide
     */
    public function test_initialize_payment_with_invalid_operator(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('payment.initialize'), [
                'order_id' => $this->order->id,
                'operator' => 'INVALID',
                'phone_number' => '612345678',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('operator');
    }

    /**
     * Test 5 : Vérifier le résultat d'un paiement
     */
    public function test_verify_payment_result(): void
    {
        // Créer un paiement en PENDING
        $payment = Paiement::create([
            'commande_id' => $this->order->id,
            'montant' => $this->order->total,
            'methode' => 'MTN',
            'phone_number' => '+237612345678',
            'operator' => 'MTN',
            'reference' => 'TEST-REF-' . time(),
            'statut' => 'PENDING',
        ]);

        $response = $this->actingAs($this->user)
            ->postJson(route('payment.verify'), [
                'payment_id' => $payment->id,
                'order_id' => $this->order->id,
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'status', 'message']);

        // Vérifier que le statut a changé
        $payment->refresh();
        $this->assertIn($payment->statut, ['SUCCESS', 'FAILED']);
        $this->assertNotNull($payment->payment_date);
    }

    /**
     * Test 6 : Vérifier la confirmation après succès
     */
    public function test_access_confirmation_page_after_success(): void
    {
        // Créer un paiement réussi
        $payment = Paiement::create([
            'commande_id' => $this->order->id,
            'montant' => $this->order->total,
            'methode' => 'MTN',
            'phone_number' => '+237612345678',
            'operator' => 'MTN',
            'reference' => 'TEST-SUCCESS-' . time(),
            'statut' => 'SUCCESS',
            'payment_date' => now(),
        ]);

        // Mettre à jour la commande
        $this->order->update(['status' => 'confirmed']);

        $response = $this->actingAs($this->user)
            ->get(route('payment.confirmation', ['order' => $this->order->id]));

        $response->assertStatus(200);
        $response->assertViewIs('payment.confirmation');
        $response->assertViewHas('payment', $payment);
    }

    /**
     * Test 7 : Refuser l'accès à la page de confirmation si non payée
     */
    public function test_deny_confirmation_access_if_not_paid(): void
    {
        // La commande est toujours en 'pending'
        $response = $this->actingAs($this->user)
            ->get(route('payment.confirmation', ['order' => $this->order->id]));

        $response->assertRedirect(route('acheteur.commandes'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test 8 : Réessayer après échec
     */
    public function test_retry_payment_after_failure(): void
    {
        // Créer un paiement échoué
        $payment = Paiement::create([
            'commande_id' => $this->order->id,
            'montant' => $this->order->total,
            'methode' => 'MTN',
            'phone_number' => '+237612345678',
            'operator' => 'MTN',
            'reference' => 'TEST-FAILED-' . time(),
            'statut' => 'FAILED',
            'payment_date' => now(),
            'failure_reason' => 'Test failure',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('payment.retry', ['order' => $this->order->id]));

        $response->assertRedirect(route('payment.show', ['order' => $this->order->id]));
        $response->assertSessionHas('info');

        // Vérifier que le paiement échoué a été supprimé
        $this->assertDatabaseMissing('paiements', [
            'id' => $payment->id,
            'statut' => 'FAILED',
        ]);
    }

    /**
     * Test 9 : Valider la structure de données du paiement
     */
    public function test_payment_structure(): void
    {
        $payment = Paiement::create([
            'commande_id' => $this->order->id,
            'montant' => 15000,
            'methode' => 'Moov',
            'phone_number' => '+237712345678',
            'operator' => 'Moov',
            'reference' => 'TEST-STRUCT-' . time(),
            'statut' => 'SUCCESS',
            'payment_date' => now(),
        ]);

        $this->assertEquals($this->order->id, $payment->commande_id);
        $this->assertEquals(15000, $payment->montant);
        $this->assertEquals('Moov', $payment->operator);
        $this->assertEquals('SUCCESS', $payment->statut);
        $this->assertNotNull($payment->payment_date);
    }

    /**
     * Test 10 : Impossible de payer une commande déjà payée
     */
    public function test_cannot_pay_already_paid_order(): void
    {
        // Mettre à jour la commande au statut 'confirmed'
        $this->order->update(['status' => 'confirmed']);

        $response = $this->actingAs($this->user)
            ->postJson(route('payment.initialize'), [
                'order_id' => $this->order->id,
                'operator' => 'MTN',
                'phone_number' => '612345678',
            ]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }
}
