<?php

namespace Tests\Feature\Controller;

use App\Models\Education;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EducationControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

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


        $startDate = now()->subYears(2)->format('Y-m-d');
        $endDate = now()->subYear()->format('Y-m-d');
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'start_date' => $startDate,
            'end_date' => $endDate,
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
    public function testGetByTag(): void
    {
        // Create a tag and education records associated with it
        $tag = Tag::factory()->create();
        $educations = Education::factory()->count(2)->create();

        // Attach the tag to the education records
        foreach ($educations as $education) {
            $education->tags()->attach($tag->id);
        }

        // Create another education record without the tag
        \App\Models\Education::factory()->create();

        // Make the request
        $response = $this->getJson(route('public.education.byTag', $tag->id));

        // Assert response
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
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
    public function testGetByTagWithInvalidId(): void
    {
        $response = $this->getJson(route('public.education.byTag', 99999));

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->assertJsonStructure([
                'message',
                'success',
                'errors'
            ]);
    }


}
