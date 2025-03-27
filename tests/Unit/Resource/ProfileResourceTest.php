<?php

namespace Tests\Unit\Resource;

use App\Http\Resources\V1\ProfileResource;
use App\Models\Profile;
use App\Models\Link;
use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProfileResourceTest extends TestCase
{
    use DatabaseTransactions;

    private Profile $profile;
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->profile = Profile::factory()->create([
            'name' => 'Test Profile',
            'rol' => 'Test rol',
            'description' => 'Test Description',
            'user_id' => $user->id
        ]);

        $this->request = Request::create('/api/v1/profile', 'GET');
    }

    public function test_profile_resource_without_relationships(): void
    {
        $resource = new ProfileResource($this->profile);
        $array = $resource->toArray($this->request);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('rol', $array);
        $this->assertArrayHasKey('description', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('deleted_at', $array);

        $this->assertSame($this->profile->id, $array['id']);
        $this->assertSame($this->profile->name, $array['name']);
        $this->assertSame($this->profile->rol, $array['rol']);
        $this->assertSame($this->profile->description, $array['description']);
        $this->assertNull($array['created_at']);
        $this->assertNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_profile_resource_with_relationships(): void
    {
        $this->profile->links()->saveMany(Link::factory(2)->create());

        $resource = new ProfileResource($this->profile);
        $array = $resource->toArray($this->request);
        $this->assertArrayHasKey('links', $array);
        $this->assertCount(2, $array['links']);
    }

    public function test_profile_resource_with_bearer_token(): void
    {
        $this->request->headers->set('Authorization', 'Bearer test-token');

        $resource = new ProfileResource($this->profile);
        $array = $resource->toArray($this->request);

        $this->assertNotNull($array['created_at']);
        $this->assertNotNull($array['updated_at']);
        $this->assertNull($array['deleted_at']);
    }

    public function test_profile_resource_wrap_attribute(): void
    {
        $this->assertEquals('profile', ProfileResource::$wrap);
    }
}
