<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Education;
use App\Models\Project;
use App\Models\Tags;
use App\Models\Link;
use App\Models\Works;
use App\Models\Profile;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'email' => 'bravojuan43@gmail.com',
            'password' => 'cody',
        ]);


        $profile = Profile::factory()->create([
           'Users_idUsers' =>1,
           'name' => 'Bravo, Juan Alé',
        //    'publicMail' =>'bravojuan@bravojuan.site',
            'rol' => 'Profesional IT',
            'description' => 'Analista programador y técnico informatico profesional y personal.',
        //    'linkedin' => 'https://www.linkedin.com/in/juan-bravo-1995b61a0/',
        //    'github' => 'https://github.com/Juancho43',
        //    'publicMail' =>'bravojuan@bravojuan.site',
        //    'cv' =>'...',
        //    'photo_url' =>'...',
       ]);

       Education::factory()->count(5)->create();
       $educations = Education::inRandomOrder()->take(rand(1, 3))->get();
    //    $profile->education()->attach($educations);
        Works::factory()->count(3)->create();
        Project::factory()->count(5)->create();
        Link::factory()->count(12)->create();

        // Crear 10 tags
        Tags::factory()->count(10)->create();



        // // Asociar aleatoriamente proyectos con tags
        // $proyectos = Project::all();
        // $tags = Tags::all();
        // $tagIds = $tags->pluck('id')->toArray(); // Obtener solo los IDs de las etiquetas

        // foreach ($proyectos as $proyecto) {
        //     // Determinar el número aleatorio de etiquetas a asignar (entre 1 y 5)
        //     $numEtiquetas = rand(1, 5);

        //     // Seleccionar aleatoriamente IDs de etiquetas sin repetición (optimizado)
        //     $etiquetasAleatorias = array_rand($tagIds, $numEtiquetas);
        //     if (!is_array($etiquetasAleatorias)) {
        //         $etiquetasAleatorias = [$etiquetasAleatorias]; // Convertir a array si solo se seleccionó una etiqueta
        //     }
        //     $etiquetasSeleccionadas = array_intersect_key($tagIds, array_flip($etiquetasAleatorias));


        //     // Sincronizar etiquetas del proyecto (evita duplicados y elimina etiquetas antiguas)
        //     $proyecto->tags()->sync($etiquetasSeleccionadas);
        // }
    }
}
