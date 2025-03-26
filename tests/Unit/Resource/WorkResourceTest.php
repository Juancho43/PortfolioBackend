<?php

namespace Tests\Unit\Resource;

use App\Http\Resources\V1\WorkResource;
use App\Models\Work;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class WorkResourceTest extends TestCase
{
    use DatabaseTransactions;

    private Work $work;
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->work = Work::factory()->create([
            'company' => 'Test Company',
            'position' => 'Test Position',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
            'responsibilities' => 'Test Responsibilities'
        ]);

        $this->request = Request::create('/api/v1/work', 'GET');
    }

    public function test_work_resource_without_relationships(): void
    {
        $resource = new WorkResource($this->work);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('company', $array);
        $this->assertArrayHasKey('position', $array);
        $this->assertArrayHasKey('start_date', $array);
        $this->assertArrayHasKey('end_date', $array);
        $this->assertArrayHasKey('responsibilities', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('deleted_at', $array);

        $this->assertEquals($this->work->id, $array['id']);
        $this->assertEquals($this->work->company, $array['company']);
        $this->assertEquals($this->work->position, $array['position']);
        $this->assertEquals($this->work->start_date, $array['start_date']);
        $this->assertEquals($this->work->end_date, $array['end_date']);
        $this->assertEquals($this->work->responsibilities, $array['responsibilities']);
        $this->assertNull($array['created_at']);
        $this->assertNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_work_resource_with_relationships(): void
    {
        $this->work->links()->saveMany(Link::factory(2)->create());
        $this->work->tags()->saveMany(Tag::factory(2)->create());

        $resource = new WorkResource($this->work);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('links', $array);
        $this->assertArrayHasKey('tags', $array);
        $this->assertCount(2, $array['links']);
        $this->assertCount(2, $array['tags']);
    }

    public function test_work_resource_with_bearer_token(): void
    {
        $this->request->headers->set('Authorization', 'Bearer test-token');

        $resource = new WorkResource($this->work);
        $array = $resource->toArray($this->request);

        $this->assertNotNull($array['created_at']);
        $this->assertNotNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_work_resource_wrap_attribute(): void
    {
        $this->assertEquals('work', WorkResource::$wrap);
    }
}
