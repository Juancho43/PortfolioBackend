<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;


class WorkControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndex() : void
    {
        Work::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/work');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'company', 'position', 'start_date', 'end_date','responsibilities','links','tags','created_at','updated_at','deleted_at']
                ]
            ]);
    }

    public function testStore() : void
    {

        $data = [
            'company' => 'Test Company',
            'position' => 'Test Position',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'responsibilities' => 'Test responsibilities',
        ];
        $response = $this->actingAs($this->user)->postJson('/api/v1/work/private', $data);


        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment($data);
    }

    public function testShow() : void
    {
        $work = Work::factory()->create();

        $response = $this->getJson("/api/v1/work/{$work->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'id' => $work->id,
                'company' => $work->company,
                'position' => $work->position,
                'start_date' =>  $work->start_date->format('Y-m-d'),
            ]);
    }

    public function test_update_work() : void
    {


        // 2. Crear un trabajo para actualizar
        $work = Work::factory()->create();

        // 3. Datos para actualizar
        $updateData = [
            'id' => $work->id, // Importante incluir el ID según tu método
            'company' => 'Título Actualizado',
            'position' => 'Descripción Actualizada',
            'start_date' => '2020-02-01',
            // Otros campos que necesites actualizar
        ];

        // 4. Hacer la petición PUT
        $response = $this->actingAs($this->user) // Si necesitas autenticación
        ->putJson(route('private.work.update', $work->id), $updateData);

        // 5. Verificar la respuesta
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('data.company', 'Título Actualizado')
            ->assertJsonPath('data.position', 'Descripción Actualizada')
            ->assertJsonPath('message', 'Resource updated successfully');

        // 6. Verificar que se actualizó en la base de datos
        $this->assertDatabaseHas('works', [
            'id' => $work->id,
            'company' => 'Título Actualizado',
            'position' => 'Descripción Actualizada',
        ]);
    }

    public function testDestroy() : void
    {
        $work = Work::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson("/api/v1/work/private/{$work->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGetByTag() : void
    {
        // Create a tag and works associated with it
        $tag = \App\Models\Tag::factory()->create();
        $works = Work::factory()->count(2)->create();

        // Attach the tag to the works
        foreach ($works as $work) {
            $work->tags()->attach($tag->id);
        }

        // Create another work without the tag
        Work::factory()->create();

        // Make the request
        $response = $this->getJson("/api/v1/work/tag/{$tag->id}");

        // Assert response
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'company',
                        'position',
                        'start_date',
                        'end_date',
                        'responsibilities',
                        'links',
                        'tags',
                        'created_at',
                        'updated_at',
                        'deleted_at'
                    ]
                ]
            ]);
    }

    public function testGetByTagWithInvalidId() : void
    {
        // Test with non-existent tag ID
        $response = $this->getJson('/api/v1/work/tag/99999');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->assertJsonStructure([
                'message',
                'success',
                'errors'

            ]);
    }
}
