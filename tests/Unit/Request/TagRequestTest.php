<?php

namespace Tests\Unit\Request;

use App\Http\Requests\V1\TagRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Exception;
use Tests\TestCase;

class TagRequestTest extends TestCase
{
    use DatabaseTransactions;

    private TagRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new TagRequest();
    }

    public function test_rules_has_correct_validation(): void
    {
        $rules = $this->request->rules();

        $this->assertEquals([
            'id' => 'nullable|integer',
            'name' => 'required|max:50',
            'delete_at' => 'nullable|date'
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
        $this->expectException(Exception::class);
        $this->request->authorize();
    }
    public function test_messages_returns_array(): void
    {
        $messages = $this->request->messages();
        $this->assertIsArray($messages);
    }
}
