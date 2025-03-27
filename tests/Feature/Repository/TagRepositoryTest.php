<?php

namespace Tests\Feature\Repository;
use App\Models\Project;
use App\Models\Work;
use App\Models\Education;
use App\Models\Tag;
use App\Repository\V1\TagRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Exception;
use Mockery;
use Tests\TestCase;

class TagRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected TagRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TagRepository();
    }

    public function testAll(): void
    {
        Tag::factory()->count(3)->create();
        $tags = $this->repository->all();
        $this->assertCount(3, $tags);
    }

    public function testFind(): void
    {
        $tag = Tag::factory()->create();
        $foundTag = $this->repository->find($tag->id);
        $this->assertEquals($tag->id, $foundTag->id);
    }

    public function testCreate(): void
    {
        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn(['name' => 'Test Tag']);
        $data->shouldReceive('name')->andReturn('Test Tag');
        $data->shouldReceive('all')->andReturn(['name' => 'Test Tag']);

        $tag = $this->repository->create($data);

        $this->assertEquals('Test Tag', $tag->name);
        $this->assertDatabaseHas('tags', ['name' => 'Test Tag']);
        $this->assertInstanceOf(Tag::class, $tag);
    }

    public function testUpdate(): void
    {
        $tag = Tag::factory()->create(['name' => 'Original Tag']);

        $data = Mockery::mock('Illuminate\Foundation\Http\FormRequest');
        $data->shouldReceive('validated')->andReturn(['name' => 'Updated Tag']);
        $data->shouldReceive('all')->andReturn(['name' => 'Updated Tag']);

        $updatedTag = $this->repository->update($tag->id, $data);

        $this->assertEquals('Updated Tag', $updatedTag->name);
        $this->assertNotEquals('Original Tag', $updatedTag->name);
        $this->assertEquals($tag->id, $updatedTag->id);
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'Updated Tag'
        ]);
        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
            'name' => 'Original Tag'
        ]);
    }

    public function testDelete(): void
    {
        $tag = Tag::factory()->create();
        $result = $this->repository->delete($tag->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }


    public function testGetAllEducationTagsReturnsNonEmptyCollection(): void
    {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $education = Education::factory()->create();
        $education->tags()->attach([$tag1->id, $tag2->id]);

        $result = $this->repository->allEducationTags();

        $this->assertCount(2, $result);
        $this->assertEquals([$tag1->id, $tag2->id], $result->pluck('id')->toArray());
    }



    public function testGetAllProjectsTagsReturnsNonEmptyCollection(): void
    {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $project = Project::factory()->create();
        $project->tags()->attach([$tag1->id, $tag2->id]);

        $result = $this->repository->allProjectsTags();

        $this->assertCount(2, $result);
        $this->assertEquals([$tag1->id, $tag2->id], $result->pluck('id')->toArray());
    }



    public function testGetAllWorksTagsReturnsNonEmptyCollection(): void
    {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $work = Work::factory()->create();
        $work->tags()->attach([$tag1->id, $tag2->id]);

        $result = $this->repository->allWorksTags();

        $this->assertCount(2, $result);
        $this->assertEquals([$tag1->id, $tag2->id], $result->pluck('id')->toArray());
    }


}
