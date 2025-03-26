<?php

namespace Tests\Unit\Request;

use App\Http\Exceptions\AuthenticationException;
use App\Http\Requests\V1\LinkRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LinkRequestTest extends TestCase
{
    use DatabaseTransactions;

    private LinkRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new LinkRequest();
    }

    public function test_rules_has_correct_validation(): void
    {
        $rules = $this->request->rules();

        $this->assertEquals([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:45',
            'link' => 'required|string|max:255',
            'delete_at' => 'nullable|date',
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
