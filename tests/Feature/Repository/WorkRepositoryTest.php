<?php

namespace Tests\Feature\Repository;

use App\Models\Link;
use App\Models\Tag;
use App\Models\Work;
use App\Repository\V1\TagRepository;
use App\Repository\V1\WorkRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class WorkRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected WorkRepository $repository;
    protected TagRepository $tagRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagRepository = new TagRepository();
        $this->repository = new WorkRepository($this->tagRepository);
    }

    public function testAll(): void
    {
        Work::factory()->count(3)->create();
        $works = $this->repository->all();
        $this->assertCount(3, $works);
    }

    public function testFind(): void
    {
        $work = Work::factory()->create();
        $foundWork = $this->repository->find($work->id);
        $this->assertEquals($work->id, $foundWork->id);
    }

    public function testCreate(): void
    {
        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $mockData = [
            'company' => 'Test Company',
            'position' => 'Test Position',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'responsibilities' => 'Test responsibilities'
        ];

        $data->shouldReceive('validated')->andReturn($mockData);
        $data->shouldReceive('all')->andReturn($mockData); // Add this line
        $data->shouldReceive('company')->andReturn('Test Company');
        $data->shouldReceive('position')->andReturn('Test Position');
        $data->shouldReceive('start_date')->andReturn('2024-01-01');
        $data->shouldReceive('end_date')->andReturn('2024-12-31');
        $data->shouldReceive('responsibilities')->andReturn('Test responsibilities');
        $data->shouldReceive('has')->with('links')->andReturn(false);
        $data->shouldReceive('has')->with('tags')->andReturn(false);

        $work = $this->repository->create($data);

        $this->assertEquals('Test Company', $work->company);
        $this->assertEquals('Test Position', $work->position);
        $this->assertDatabaseHas('works', [
            'company' => 'Test Company',
            'position' => 'Test Position'
        ]);
    }

    public function testCreateWithRelations(): void
    {
        $links = Link::factory()->count(2)->create();
        $tags = Tag::factory()->count(2)->create();

        $mockData = [
            'company' => 'Test Company',
            'position' => 'Test Position',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'responsibilities' => 'Test responsibilities',
            'links' => $links->pluck('id')->toArray(),
            'tags' => $tags->pluck('id')->toArray()
        ];

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn($mockData);
        $data->shouldReceive('all')->andReturn($mockData); // Add this line
        $data->shouldReceive('company')->andReturn('Test Company');
        $data->shouldReceive('position')->andReturn('Test Position');
        $data->shouldReceive('start_date')->andReturn('2024-01-01');
        $data->shouldReceive('end_date')->andReturn('2024-12-31');
        $data->shouldReceive('responsibilities')->andReturn('Test responsibilities');
        $data->shouldReceive('has')->with('links')->andReturn(true);
        $data->shouldReceive('has')->with('tags')->andReturn(true);
        $data->shouldReceive('links')->andReturn($links->pluck('id')->toArray());
        $data->shouldReceive('tags')->andReturn($tags->pluck('id')->toArray());

        $work = $this->repository->create($data);

        $this->assertEquals('Test Company', $work->company);
        $this->assertCount(2, $work->links);
        $this->assertCount(2, $work->tags);
    }//        $data->shouldReceive('get')->with('links')->andReturn($links->pluck('id')->toArray());
//        $data->shouldReceive('get')->with('tags')->andReturn($tags->pluck('id')->toArray());

    public function testUpdate(): void
    {
        $work = Work::factory()->create([
            'company' => 'Original Company',
            'position' => 'Original Position'
        ]);

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('all')->andReturn([
            'company' => 'Updated Company',
            'position' => 'Updated Position'
        ]);
        $data->shouldReceive('has')->with('links')->andReturn(false);
        $data->shouldReceive('has')->with('tags')->andReturn(false);

        $updatedWork = $this->repository->update($work->id, $data);

        $this->assertEquals('Updated Company', $updatedWork->company);
        $this->assertEquals('Updated Position', $updatedWork->position);
        $this->assertDatabaseHas('works', [
            'id' => $work->id,
            'company' => 'Updated Company',
            'position' => 'Updated Position'
        ]);
    }

    public function testDelete(): void
    {
        $work = Work::factory()->create();
        $result = $this->repository->delete($work->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('works', ['id' => $work->id]);
    }

    public function testGetWorksByTag(): void
    {
        $tag = Tag::factory()->create();
        $works = Work::factory()->count(3)->create();
        $tag->works()->attach($works->pluck('id'));

        $result = $this->repository->getWorksByTag($tag->id);

        $this->assertCount(3, $result);
        $this->assertEquals($works->pluck('id')->toArray(), $result->pluck('id')->toArray());
    }
}
