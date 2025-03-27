<?php

namespace Tests\Unit\Resource;

use App\Http\Resources\V1\LinkResource;
use App\Models\Link;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class LinkResourceTest extends TestCase
{
    use DatabaseTransactions;

    private Link $link;
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->link = Link::factory()->create([
            'name' => 'Test Link',
            'link' => 'https://test.com',
        ]);

        $this->request = Request::create('/api/v1/link', 'GET');
    }

    public function test_link_resource_structure(): void
    {
        $resource = new LinkResource($this->link);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('link', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('deleted_at', $array);

        $this->assertEquals($this->link->id, $array['id']);
        $this->assertEquals($this->link->name, $array['name']);
        $this->assertEquals($this->link->link, $array['link']);
        $this->assertNull($array['created_at']);
        $this->assertNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_link_resource_with_bearer_token(): void
    {
        $this->request->headers->set('Authorization', 'Bearer test-token');

        $resource = new LinkResource($this->link);
        $array = $resource->toArray($this->request);

        $this->assertNotNull($array['created_at']);
        $this->assertNotNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_link_resource_wrap_attribute(): void
    {
        $this->assertEquals('link', LinkResource::$wrap);
    }
}
