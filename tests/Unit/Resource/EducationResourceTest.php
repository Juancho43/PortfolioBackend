<?php

namespace Tests\Unit\Resource;

use App\Http\Resources\V1\EducationResource;
use App\Models\Education;
use App\Models\Link;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class EducationResourceTest extends TestCase
{
    use DatabaseTransactions;

    private Education $education;
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->education = Education::factory()->create([
            'name' => 'Test Education',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31'
        ]);
        $this->request = Request::create('/api/v1/education', 'GET');
    }

    public function test_education_resource_without_relationships(): void
    {
        $resource = new EducationResource($this->education);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('description', $array);
        $this->assertArrayHasKey('start_date', $array);
        $this->assertArrayHasKey('end_date', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('deleted_at', $array);

        $this->assertEquals($this->education->id, $array['id']);
        $this->assertEquals($this->education->name, $array['name']);
        $this->assertEquals($this->education->description, $array['description']);
        $this->assertEquals($this->education->start_date, $array['start_date']);
        $this->assertEquals($this->education->end_date, $array['end_date']);
        $this->assertNull($array['created_at']);
        $this->assertNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_education_resource_with_relationships(): void
    {
        // Attach relationships
        $this->education->projects()->saveMany(Project::factory(2)->create());
        $this->education->tags()->saveMany(Tag::factory(2)->create());
        $this->education->links()->saveMany(Link::factory(2)->create());

        $resource = new EducationResource($this->education);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('projects', $array);
        $this->assertArrayHasKey('tags', $array);
        $this->assertArrayHasKey('links', $array);
        $this->assertCount(2, $array['projects']);
        $this->assertCount(2, $array['tags']);
        $this->assertCount(2, $array['links']);
    }

    public function test_education_resource_with_bearer_token(): void
    {
        $this->request->headers->set('Authorization', 'Bearer test-token');

        $resource = new EducationResource($this->education);
        $array = $resource->toArray($this->request);

        $this->assertNotNull($array['created_at']);
        $this->assertNotNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_education_resource_wrap_attribute(): void
    {
        $this->assertEquals('education', EducationResource::$wrap);
    }
}
