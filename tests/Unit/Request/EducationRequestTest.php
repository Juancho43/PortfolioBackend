<?php

namespace Tests\Unit\Request;

use App\Http\Requests\V1\EducationRequest;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EducationRequestTest extends TestCase
{
    use DatabaseTransactions;

    private EducationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new EducationRequest();
    }

    public function test_rules_has_correct_validation(): void
    {
        $rules = $this->request->rules();

        $this->assertEquals([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:<?php

namespace Tests\Unit\Request;

use PHPUnit\Framework\TestCase;

class LinkRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}
start_date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
            'links' => 'nullable|array',
            'links.*' => 'exists:links,id',
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
        $this->expectException(Exception::class);
        $this->request->authorize();
    }
    public function test_messages_returns_array(): void
    {
        $messages = $this->request->messages();
        $this->assertIsArray($messages);
    }
}
