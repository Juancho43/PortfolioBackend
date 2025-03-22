<?php

namespace Tests\Feature;

use App\Models\Education;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EducationControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    protected string $endpoint = '/api/v1/education';

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

        $response = $this->getJson(route('public.education.show', 1));

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
                ]
            ]);
    }
}
