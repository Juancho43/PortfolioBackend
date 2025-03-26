<?php

namespace Tests\Unit\Request;

use App\Http\Exceptions\AuthenticationException;
use App\Http\Requests\V1\ProfileRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProfileRequestTest extends TestCase
{
    use DatabaseTransactions;

    private ProfileRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ProfileRequest();
    }

    public function test_rules_has_correct_validation(): void
    {
        $rules = $this->request->rules();

        $this->assertEquals([
            'name' => 'required|string|max:255',
            'rol' => 'required|string|max:100',
            'description' => 'nullable|string|max:65535',
            'education' => 'nullable|array',
            'education.*' => 'integer|exists:education,id',
            'works' => 'nullable|array',
            'works.*' => 'integer|exists:works,id',
            'links' => 'nullable|array',
            'links.*' => 'integer|exists:links,id'
        ], $rules);
    }

    public function test_authorize_returns_true_when_user_authenticated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue($this->request->authorize());
    }

    public function test_authorize_throws_exception_when_user_not_authenticated(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->request->authorize();
    }

    public function test_messages_returns_array(): void
    {
        $messages = $this->request->messages();
        $this->assertIsArray($messages);
    }
}
