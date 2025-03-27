<?php

namespace Tests\Feature\Repository;

use App\Models\Education;
use App\Models\Link;
use App\Models\Profile;
use App\Models\User;
use App\Models\Work;
use App\Repository\V1\ProfileRepository;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProfileRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    protected ProfileRepository $repository;
    protected User $user;
    protected Profile $profile;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProfileRepository();
        $user = User::factory()->create();
        $this->user = $user;
        $this->profile = Profile::factory()->create([
            'user_id' => $user->id
        ]);
    }

   public function test_get_all() : void
   {
       $profiles = $this->repository->all();
       $this->assertCount(1, $profiles);
   }

   public function test_get_one() : void
   {
         $profile = Profile::first();
         $foundProfile = $this->repository->find($profile->id);
         $this->assertEquals($profile->id, $foundProfile->id);
   }

    public function testUpdateProfileSuccessfully()
    {
        // Create test relationships
        $links = Link::factory()->count(2)->create();
        $education = Education::factory()->count(2)->create();
        $works = Work::factory()->count(2)->create();

        // Mock FormRequest
        $mockRequest = Mockery::mock(FormRequest::class);
        // Add missing route expectation
        $mockRequest->shouldReceive('route')->andReturn(null);
        $mockRequest->shouldReceive('validated')->once()->andReturn([
            'name' => 'Updated Name',
            'rol' => 'Updated Bio',
            'description' => 'Updated Bio'
        ]);

        $mockRequest->shouldReceive('has')->with('links')->andReturn(true);
        $mockRequest->shouldReceive('__get')->with('links')->andReturn($links->pluck('id')->toArray());

        $mockRequest->shouldReceive('has')->with('education')->andReturn(true);
        $mockRequest->shouldReceive('__get')->with('education')->andReturn($education->pluck('id')->toArray());

        $mockRequest->shouldReceive('has')->with('works')->andReturn(true);
        $mockRequest->shouldReceive('__get')->with('works')->andReturn($works->pluck('id')->toArray());

        // Set request data that will be used for update()
        $mockRequest->shouldReceive('all')->andReturn([
            'name' => 'Updated Name',
            'rol' => 'Updated Bio',
            'description' => 'Updated Bio'
        ]);

        // Execute the update
        $result = $this->repository->update($this->profile->id, $mockRequest);

        // Assert results
        $this->assertInstanceOf(Profile::class, $result);
        $this->assertEquals('Updated Name', $result->name);
        $this->assertEquals('Updated Bio', $result->rol);
        $this->assertEquals('Updated Bio', $result->description);



    }

    public function testUpdateProfileNoRelationships() : void
    {

        // Mock FormRequest
        $mockRequest = Mockery::mock(FormRequest::class);
        $mockRequest->shouldReceive('validated')->once()->andReturn([
            'name' => 'Updated Name',
            'rol' => 'Updated Bio'
        ]);

        $mockRequest->shouldReceive('has')->with('links')->andReturn(false);
        $mockRequest->shouldReceive('has')->with('education')->andReturn(false);
        $mockRequest->shouldReceive('has')->with('works')->andReturn(false);

        // Set request data that will be used for update()
        $mockRequest->shouldReceive('all')->andReturn([
            'name' => 'Updated Name',
            'rol' => 'Updated Bio'
        ]);

        // Execute the update
        $result = $this->repository->update($this->profile->id, $mockRequest);

        // Assert results
        $this->assertInstanceOf(Profile::class, $result);
        $this->assertEquals('Updated Name', $result->name);
        $this->assertEquals('Updated Bio', $result->rol);
    }

    public function testUpdateProfileError() : void
    {
        // Mock FormRequest
        $mockRequest = Mockery::mock(FormRequest::class);
        $mockRequest->shouldReceive('validated')->once()->andThrow(new Exception('Validation error'));

        // Execute the update with invalid ID
        $result = $this->repository->update(999, $mockRequest);

        // Assert error response
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $result->getStatusCode());
        $this->assertStringContainsString('Error al actualizar el recurso', $result->getContent());
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

}
