<?php

namespace Tests\Feature\V1;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cv;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CvTest extends TestCase
{
    use  RefreshDatabase;

    protected string $endpoint = '/api/v1/cvs';
    protected string $tableName = 'cvs';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateCv(): void
    {
        $this->actingAs(User::factory()->create());

        $payload = Cv::factory()->make([])->toArray();

        $this->json('POST', $this->endpoint, $payload)
             ->assertStatus(201)
             ->assertSee($payload['name']);

        $this->assertDatabaseHas($this->tableName, ['id' => 1]);
    }

    public function testViewAllCvsSuccessfully(): void
    {
        $this->actingAs(User::factory()->create());

        Cv::factory(5)->create();

        $this->json('GET', $this->endpoint)
             ->assertStatus(200)
             ->assertJsonCount(5, 'data')
             ->assertSee(Cv::find(rand(1, 5))->name);
    }

    public function testsCreateCvValidation(): void
    {
        $this->actingAs(User::factory()->create());

        $data = [
        ];

        $this->json('post', $this->endpoint, $data)
             ->assertStatus(422);
    }

    public function testViewCvData(): void
    {
        $this->actingAs(User::factory()->create());

        Cv::factory()->create();

        $this->json('GET', $this->endpoint.'/1')
             ->assertSee(Cv::first()->name)
             ->assertStatus(200);
    }

    public function testDeleteCv(): void
    {
        $this->actingAs(User::factory()->create());

        Cv::factory()->create();

        $this->json('DELETE', $this->endpoint.'/1')
             ->assertStatus(204);

        $this->assertEquals(0, Cv::count());
    }
    
}
