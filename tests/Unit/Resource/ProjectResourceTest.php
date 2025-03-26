<?php

namespace Tests\Unit\Resource;

use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProjectResourceTest extends TestCase
{
    use DatabaseTransactions;

    private Project $project;
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create([
            'name' => 'Test Project',
            'description' => 'Test Project',
        ]);

        $this->request = Request::create('/api/v1/project', 'GET');
    }

    public function test_project_resource_without_relationships(): void
    {
        $resource = new ProjectResource($this->project);
        $array = $resource->toArray($this->request);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('description', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('deleted_at', $array);

        $this->assertEquals($this->project->id, $array['id']);
        $this->assertEquals($this->project->name, $array['name']);
        $this->assertEquals($this->project->description, $array['description']);

        $this->assertNull($array['created_at']);
        $this->assertNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_project_resource_with_relationships(): void
    {
        $this->project->links()->saveMany(Link::factory(2)->create());
        $this->project->tags()->saveMany(Tag::factory(2)->create());

        $resource = new ProjectResource($this->project);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('links', $array);
        $this->assertArrayHasKey('tags', $array);
        $this->assertCount(2, $array['links']);
        $this->assertCount(2, $array['tags']);
    }

    public function test_project_resource_with_bearer_token(): void
    {
        $this->request->headers->set('Authorization', 'Bearer test-token');

        $resource = new ProjectResource($this->project);
        $array = $resource->toArray($this->request);

        $this->assertNotNull($array['created_at']);
        $this->assertNotNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_project_resource_wrap_attribute(): void
    {
        $this->assertEquals('project', ProjectResource::$wrap);
    }
}
