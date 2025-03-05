<?php

namespace Tests\Feature;
use App\Models\Education;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EducationControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_educations(): void
    {
        Education::factory()->count(3)->create();

        $response = $this->get('/api/v1/education');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'start_date',
                        'end_date',
                    ],
                ],
            ]);
    }
}
