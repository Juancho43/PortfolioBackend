<?php

namespace Tests\Feature\Controller;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;
    protected User $user;
    protected Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->profile = Profile::factory()->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->user);

        Storage::fake('public');
    }

    public function test_get_user(): void
    {
        $response = $this->get(route('public.profile.show', $this->profile->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $this->profile->id,
                'name' => $this->profile->name,
                'rol' => $this->profile->rol,
                'description' => $this->profile->description,
                'links' => [],
            ],
        ]);
    }

    public function test_upload_photo(): void
    {
        $response = $this->post(route('private.profile.saveImage', $this->profile->id), [
            'photo_url' => UploadedFile::fake()->image('photo.jpg')
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "message" => 'Post successfully',
        ]);
    }

    public function test_upload_cv(): void
    {
        $response = $this->post(route('private.profile.saveCV', $this->profile->id), [
            'cv' => UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf')
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "message" => 'Post successfully',
        ]);
    }

}
