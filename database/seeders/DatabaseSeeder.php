<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Education;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Link;
use App\Models\Work;
use App\Models\Profile;
use DB;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        User::factory()->create([
            'email' => 'bravojuan43@gmail.com',
            'password' => 'cody',
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=0'); // Desactivar restricciones
    DB::table('education_has_projects')->truncate();
        DB::table('projects')->truncate();
        DB::table('education')->truncate();
        DB::table('profiles')->truncate();
        $profile = Profile::factory()->create([
           'user_id' =>1,
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
        Work::factory()->count(3)->create();
        Project::factory()->count(5)->create();
        Link::factory()->count(12)->create();

        // Crear 10 tags
        Tag::factory()->count(10)->create();
       $links= Link::all();
        $profile = Profile::find(1);


        $profile->links()->attach([$links[0],$links[1]]);

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
