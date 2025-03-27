<?php

namespace Tests\Unit\Resource;

use App\Http\Resources\V1\TagResource;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class TagResourceTest extends TestCase
{
    use DatabaseTransactions;

    private Tag $tag;
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tag = Tag::factory()->create([
            'name' => 'Test Tag',

        ]);

        $this->request = Request::create('/api/v1/tag', 'GET');
    }

    public function test_tag_resource_structure(): void
    {
        $resource = new TagResource($this->tag);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('deleted_at', $array);

        $this->assertEquals($this->tag->id, $array['id']);
        $this->assertEquals($this->tag->name, $array['name']);
        $this->assertNull($array['created_at']);
        $this->assertNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_tag_resource_with_bearer_token(): void
    {
        $this->request->headers->set('Authorization', 'Bearer test-token');

        $resource = new TagResource($this->tag);
        $array = $resource->toArray($this->request);

        $this->assertNotNull($array['created_at']);
        $this->assertNotNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_tag_resource_wrap_attribute(): void
    {
        $this->assertEquals('tag', TagResource::$wrap);
    }
}
