<?php

namespace Tests\Feature\Repository;

use App\Models\Link;
use App\Models\Project;
use App\Models\Tag;
use App\Repository\V1\EducationRepository;
use App\Repository\V1\ProjectRepository;
use App\Repository\V1\TagRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ProjectRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProjectRepository $repository;
    protected TagRepository $tagRepository;
    protected EducationRepository $educationRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagRepository = new TagRepository();
        $this->EducationRepository = new EducationRepository($this->tagRepository);
        $this->repository = new ProjectRepository($this->tagRepository,$this->EducationRepository);
    }

    public function testAll(): void
    {
        Project::factory()->count(3)->create();
        $projects = $this->repository->all();
        $this->assertCount(3, $projects);
    }

    public function testFind(): void
    {
        $project = Project::factory()->create();
        $foundProject = $this->repository->find($project->id);
        $this->assertEquals($project->id, $foundProject->id);
    }

    public function testCreate(): void
    {
        $mockData = [
            'name' => 'Test Project',
            'description' => 'Test Description',
        ];

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn($mockData);
        $data->shouldReceive('all')->andReturn($mockData);
        $data->shouldReceive('name')->andReturn('Test Project');
        $data->shouldReceive('description')->andReturn('Test Description');
        $data->shouldReceive('has')->with('links')->andReturn(false);
        $data->shouldReceive('has')->with('tags')->andReturn(false);

        $project = $this->repository->create($data);

        $this->assertEquals('Test Project', $project->name);
        $this->assertEquals('Test Description', $project->description);
        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
            'description' => 'Test Description'
        ]);
    }

    public function testCreateWithRelations(): void
    {
        $links = Link::factory()->count(2)->create();
        $tags = Tag::factory()->count(2)->create();



        $mockData = [
            'name' => 'Test Project',
            'description' => 'Test Description',
            'links' => $links->pluck('id')->toArray(),
            'tags' => $tags->pluck('id')->toArray()
        ];

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn($mockData);
        $data->shouldReceive('all')->andReturn($mockData);
        $data->shouldReceive('has')->with('links')->andReturn(true);
        $data->shouldReceive('has')->with('tags')->andReturn(true);
        $data->shouldReceive('get')->with('links')->andReturn($links->pluck('id')->toArray());
        $data->shouldReceive('get')->with('tags')->andReturn($tags->pluck('id')->toArray());

        $project = $this->repository->create($data);

        $this->assertEquals('Test Project', $project->name);
        $this->assertEquals('Test Description', $project->description);
        $this->assertCount(2, $project->links);
        $this->assertCount(2, $project->tags);
        $this->assertEquals($links->pluck('id')->toArray(), $project->links->pluck('id')->toArray());
        $this->assertEquals($tags->pluck('id')->toArray(), $project->tags->pluck('id')->toArray());
    }

    public function testUpdate(): void
    {
        $project = Project::factory()->create([
            'name' => 'Original Project',
            'description' => 'Original Description'
        ]);

        $mockData = [
            'name' => 'Updated Project',
            'description' => 'Updated Description'
        ];

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn($mockData);
        $data->shouldReceive('all')->andReturn($mockData);
        $data->shouldReceive('has')->with('links')->andReturn(false);
        $data->shouldReceive('has')->with('tags')->andReturn(false);

        $updatedProject = $this->repository->update($project->id, $data);

        $this->assertEquals('Updated Project', $updatedProject->name);
        $this->assertEquals('Updated Description', $updatedProject->description);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Project',
            'description' => 'Updated Description'
        ]);
    }

    public function testDelete(): void
    {
        $project = Project::factory()->create();
        $result = $this->repository->delete($project->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function testGetProjectsByTag(): void
    {
        $tag = Tag::factory()->create();
        $projects = Project::factory()->count(3)->create();
        $tag->projects()->attach($projects->pluck('id'));

        $result = $this->repository->getProjectsByTag($tag->id);

        $this->assertCount(3, $result);
        $this->assertEquals($projects->pluck('id')->toArray(), $result->pluck('id')->toArray());
    }
}
