<?php

namespace Tests\Feature\Controller;

use App\Models\Education;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EducationControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    protected string $endpoint = '/api/v1/education';

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    public function test_index_returns_education_list(): void
    {
        Education::factory()->count(3)->create();

        $response = $this->getJson(route('public.education.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'start_date',
                        'end_date',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }
    public function test_show_returns_education(): void
    {
        $education = Education::factory()->create();

        $response = $this->getJson(route('public.education.show', $education->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'start_date',
                    'end_date',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]
            ]);
    }
    public function test_store_saves_education(): void
    {

        $startDate = $this->faker->date();
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'start_date' => $startDate,
            'end_date' => $this->faker->date('Y-m-d', $this->faker->dateTimeBetween($startDate, '+5 years')),
        ];

        $response = $this->actingAs($this->user)->postJson(route('private.education.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'start_date',
                    'end_date',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]
            ]);
    }


}
