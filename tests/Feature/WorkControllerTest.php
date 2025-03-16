<?php

namespace Tests\Feature;

use App\Models\Work;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;


class WorkControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        Work::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/work');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'company', 'position', 'start_date', 'end_date','responsabilities','links','tags','created_at','updated_at','deleted_at']
                ]
            ]);
    }

    public function testStore()
    {

        $data = [
            'company' => 'Test Company',
            'position' => 'Test Position',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'responsabilities' => 'Test responsabilities',
        ];
        $response = $this->actingAs($this->user)->postJson('/api/v1/work/private', $data);


        $response->assertStatus(201)
            ->assertJsonFragment($data);
    }

    public function testShow()
    {
        $work = Work::factory()->create();

        $response = $this->getJson("/api/v1/works/{$work->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $work->id,
                'name' => $work->name,
                'description' => $work->description
            ]);
    }

    public function testUpdate()
    {
        $work = Work::factory()->create();

        $data = [
            'name' => 'Updated Work',
            'description' => 'Updated Description'
        ];

        $response = $this->putJson("/api/v1/works/{$work->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);
    }

    public function testDestroy()
    {
        $work = Work::factory()->create();

        $response = $this->deleteJson("/api/v1/works/{$work->id}");

        $response->assertStatus(204);
    }
}
