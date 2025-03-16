<?php

namespace Tests\Feature;

use App\Models\Work;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
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

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'company', 'position', 'start_date', 'end_date','responsibilities','links','tags','created_at','updated_at','deleted_at']
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
            'responsibilities' => 'Test responsibilities',
        ];
        $response = $this->actingAs($this->user)->postJson('/api/v1/work/private', $data);


        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment($data);
    }

    public function testShow()
    {
        $work = Work::factory()->create();

        $response = $this->getJson("/api/v1/work/{$work->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'id' => $work->id,
                'company' => $work->company,
                'position' => $work->position,
                'start_date' =>  $work->start_date->format('Y-m-d'),
            ]);
    }

    public function test_update_work_authorized()
    {
        $work = Work::find(1);
        $data = [
            'company' => 'Test Company',
            'position' => 'Test Position',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'responsibilities' => 'Test responsibilities',
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/v1/work/private/{$work->id}", $data);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($data);
    }

    public function testDestroy()
    {
        $work = Work::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson("/api/v1/work/private/{$work->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
