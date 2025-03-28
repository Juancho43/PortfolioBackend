<?php

namespace Tests\Feature\V1;

use App\Models\Tag;
use App\Repository\V1\TagRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    private TagRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(TagRepository::class);
    }

    public function testShouldReturnAllProjectTagsSuccessfully()
    {
        // Create project tags
        $projectTag = Tag::factory()->create();
        $projectTag->projects()->create(['name' => 'Test Project']);
        echo $this->repository->allProjectsTags();

        $response = $this->getJson(route('public.tag.projects'));

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'data' => [
                            '*' => ['id', 'name']
                        ]
                    ]
                ]);
    }

    public function testShouldReturnAllWorkTagsSuccessfully()
    {
        $workTag = Tag::factory()->create();
        $workTag->works()->create();

        $response = $this->getJson(route('public.tag.works'));

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'data' => [
                            '*' => ['id']
                        ]
                    ]
                ]);
    }

    public function shouldReturnAllEducationTagsSuccessfully()
    {
        $educationTag = Tag::factory()->create();
        $educationTag->education()->create(['name' => 'Test Education']);

        $response = $this->getJson(route('public.tag.education'));

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'data' => [
                            '*' => ['id', 'name']
                        ]
                    ]
                ]);
    }

    public function shouldReturnEmptyArrayWhenNoProjectTagsExist()
    {
        $response = $this->getJson(route('public.tag.projects'));

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'success' => true,
                    'message' => null,
                    'data' => ['data' => []]
                ]);
    }

    public function shouldHandleErrorWhenDatabaseFailsToRetrieveTags()
    {
        $this->mock(TagRepository::class)
             ->shouldReceive('allProjectsTags')
             ->andThrow(new \Exception('Database connection failed'));

        $response = $this->getJson(route('public.tag.projects'));

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->assertJson([
                    'success' => false,
                    'message' => 'Error retrieving data.',
                    'errors' => 'Database connection failed'
                ]);
    }

    public function shouldCreateNewTagSuccessfully()
    {
        $tagData = ['name' => 'New Tag'];

        $response = $this->postJson(route('private.tag.store'), $tagData);

        $response->assertStatus(Response::HTTP_CREATED)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => ['id', 'name']
                ]);
    }

    public function shouldFailToCreateTagWithInvalidData()
    {
        $response = $this->postJson(route('private.tag.store'), ['name' => '']);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['name']);
    }

    public function shouldUpdateExistingTagSuccessfully()
    {
        $tag = Tag::factory()->create();
        $updateData = ['name' => 'Updated Tag Name'];

        $response = $this->putJson(route('private.tag.update', $tag->id), $updateData);

        $response->assertStatus(Response::HTTP_CREATED)
                ->assertJson([
                    'success' => true,
                    'data' => ['name' => 'Updated Tag Name']
                ]);
    }

    public function shouldDeleteTagSuccessfully()
    {
        $tag = Tag::factory()->create();

        $response = $this->deleteJson(route('private.tag.destroy', $tag->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
