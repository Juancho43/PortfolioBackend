<?php

namespace Tests\Feature\Repository;

use App\Models\Link;
use App\Repository\V1\LinkRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class LinkRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected LinkRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new LinkRepository();
    }

    public function testAll(): void
    {
        Link::factory()->count(3)->create();
        $links = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $links);
        $this->assertCount(3, $links);
    }

    public function testFind(): void
    {
        $link = Link::factory()->create();
        $foundLink = $this->repository->find($link->id);

        $this->assertEquals($link->id, $foundLink->id);
        $this->assertInstanceOf(Link::class, $foundLink);
    }

    public function testCreate(): void
    {
        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn([
            'name' => 'Test Link',
            'link' => 'https://test.com'
        ]);
        $data->shouldReceive('name')->andReturn('Test Link');
        $data->shouldReceive('link')->andReturn('https://test.com');
        $data->shouldReceive('all')->andReturn([
            'name' => 'Test Link',
            'link' => 'https://test.com'
        ]);

        $link = $this->repository->create($data);

        $this->assertEquals('Test Link', $link->name);
        $this->assertEquals('https://test.com', $link->link);
        $this->assertDatabaseHas('links', [
            'name' => 'Test Link',
            'link' => 'https://test.com'
        ]);
    }

    public function testUpdate(): void
    {
        $link = Link::factory()->create([
            'name' => 'Original Link',
            'link' => 'https://original.com'
        ]);

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn([
            'name' => 'Updated Link',
            'link' => 'https://updated.com'
        ]);
        $data->shouldReceive('all')->andReturn([
            'name' => 'Updated Link',
            'link' => 'https://updated.com'
        ]);

        $updatedLink = $this->repository->update($link->id, $data);

        $this->assertEquals('Updated Link', $updatedLink->name);
        $this->assertEquals('https://updated.com', $updatedLink->link);
        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'name' => 'Updated Link',
            'link' => 'https://updated.com'
        ]);
    }

    public function testDelete(): void
    {
        $link = Link::factory()->create();
        $result = $this->repository->delete($link->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('links', ['id' => $link->id]);
    }
}
