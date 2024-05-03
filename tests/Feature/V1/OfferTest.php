<?php

namespace Tests\Feature\V1;

use Tests\TestCase;
use App\Models\User;
use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferTest extends TestCase
{
    use  RefreshDatabase;

    protected string $endpoint = '/api/v1/offers';
    protected string $tableName = 'offers';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateOffer(): void
    {
        $this->actingAs(User::factory()->create());

        $payload = Offer::factory()->make([])->toArray();

        $this->json('POST', $this->endpoint, $payload)
             ->assertStatus(201)
             ->assertSee($payload['name']);

        $this->assertDatabaseHas($this->tableName, ['id' => 1]);
    }

    public function testViewAllOffersSuccessfully(): void
    {
        $this->actingAs(User::factory()->create());

        Offer::factory(5)->create();

        $this->json('GET', $this->endpoint)
             ->assertStatus(200)
             ->assertJsonCount(5, 'data')
             ->assertSee(Offer::find(rand(1, 5))->name);
    }

    public function testsCreateOfferValidation(): void
    {
        $this->actingAs(User::factory()->create());

        $data = [
        ];

        $this->json('post', $this->endpoint, $data)
             ->assertStatus(422);
    }

    public function testViewOfferData(): void
    {
        $this->actingAs(User::factory()->create());

        Offer::factory()->create();

        $this->json('GET', $this->endpoint.'/1')
             ->assertSee(Offer::first()->name)
             ->assertStatus(200);
    }

    public function testDeleteOffer(): void
    {
        $this->actingAs(User::factory()->create());

        Offer::factory()->create();

        $this->json('DELETE', $this->endpoint.'/1')
             ->assertStatus(204);

        $this->assertEquals(0, Offer::count());
    }
    
}
