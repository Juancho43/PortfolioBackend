<?php

namespace Tests\Unit;
use App\Models\Education;
use App\Models\Tag;
use App\Repository\V1\EducationRepository;
use App\Repository\V1\TagRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class EducationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected EducationRepository $repository;
    protected TagRepository $tagRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagRepository = new TagRepository();
        $this->repository = new EducationRepository($this->tagRepository);
    }

    public function testCreate(): void
    {
        $mockData = [
            'name' => 'Test University',
            'start_date' => '2020-01-01',
            'end_date' => '2024-01-01',
            'description' => 'Test Description'
        ];

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn($mockData);
        $data->shouldReceive('all')->andReturn($mockData);
        $data->shouldReceive('name')->andReturn('Test University');
        $data->shouldReceive('start_date')->andReturn('2020-01-01');
        $data->shouldReceive('end_date')->andReturn('2024-01-01');
        $data->shouldReceive('description')->andReturn('Test Description');
        $data->shouldReceive('has')->with('links')->andReturn(false);
        $data->shouldReceive('has')->with('tags')->andReturn(false);
        $data->shouldReceive('has')->with('projects')->andReturn(false);

        $education = $this->repository->create($data);

        $this->assertEquals('Test University', $education->name);
        $this->assertEquals('Test Description', $education->description);
        $this->assertDatabaseHas('education', [
            'name' => 'Test University',
            'description' => 'Test Description'
        ]);
    }


    public function testUpdate(): void
    {
        $education = Education::factory()->create([
            'name' => 'Original University',
            'description' => 'Original Degree'
        ]);

        $mockData = [
            'name' => 'Updated University',
            'description' => 'Updated Degree'
        ];

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn($mockData);
        $data->shouldReceive('all')->andReturn($mockData);
        $data->shouldReceive('has')->with('links')->andReturn(false);
        $data->shouldReceive('has')->with('tags')->andReturn(false);
        $data->shouldReceive('has')->with('projects')->andReturn(false);

        $updatedEducation = $this->repository->update($education->id, $data);

        $this->assertInstanceOf(Education::class, $updatedEducation);
        $this->assertEquals('Updated University', $updatedEducation->name);
        $this->assertEquals('Updated Degree', $updatedEducation->description);
        $this->assertDatabaseHas('education', [
            'id' => $education->id,
            'name' => 'Updated University',
            'description' => 'Updated Degree'
        ]);
    }

    public function testAll(): void
    {
        Education::factory()->count(3)->create();
        $educations = $this->repository->all();
        $this->assertCount(3, $educations);
    }
    public function testFind(): void
    {
        $education = Education::factory()->create();
        $foundEducation = $this->repository->find($education->id);
        $this->assertEquals($education->id, $foundEducation->id);
    }



    public function testDelete(): void
    {
        $education = Education::factory()->create();
        $result = $this->repository->delete($education->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('education', ['id' => $education->id]);
    }
    public function testGetEducationByTag(): void
    {
        $tag = Tag::factory()->create();
        $educations = Education::factory()->count(3)->create();
        $tag->education()->attach($educations->pluck('id'));

        $result = $this->repository->getEducationByTag($tag->id);

        $this->assertCount(3, $result);
        $this->assertEquals($educations->pluck('id')->toArray(), $result->pluck('id')->toArray());
    }
}
