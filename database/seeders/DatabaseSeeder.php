<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Education;
use App\Models\Proyect; 
use App\Models\Tags; 
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
        

        Profile::factory()->create([
           'user_id' =>1,
           'name' => 'Bravo, Juan Alé',
           'publicMail' =>'bravojuan@bravojuan.site',
           'rol' => 'Profesional IT',
           'description' => 'Analista programador y técnico informatico profesional y personal.',
           'linkedin' => 'https://www.linkedin.com/in/juan-bravo-1995b61a0/',
           'github' => 'https://github.com/Juancho43',
           'publicMail' =>'bravojuan@bravojuan.site'

        ]);
        
        Education::factory()->count(5)->create();

        Proyect::factory()->count(5)->create();

        // Crear 10 tags
        Tags::factory()->count(10)->create();

        // Asociar aleatoriamente proyectos con tags
        $proyectos = Proyect::all();
        $tags = Tags::all();
        foreach ($proyectos as $proyect) {
            $proyect->tags()->attach(
                $tags->random(rand(1, 5)) // Asignar de 1 a 3 etiquetas aleatorias a cada proyecto
            );
        }
       
    }
}
