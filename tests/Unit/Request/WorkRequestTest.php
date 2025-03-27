<?php

namespace Tests\Unit\Request;

use App\Http\Exceptions\AuthenticationException;
use App\Http\Requests\V1\WorkRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WorkRequestTest extends TestCase
{
    use DatabaseTransactions;

    private WorkRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new WorkRequest();
    }

    public function test_rules_has_correct_validation(): void
    {
        $rules = $this->request->rules();

        $this->assertEquals([
            'company' => 'required|string|max:45',
            'position' => 'required|string|max:45',
            'responsibilities' => 'nullable|string|max:65535',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'delete_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
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
