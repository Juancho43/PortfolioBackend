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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory(10)->create();
        Profile::factory(10)->create();
        Education::factory()->count(5)->create();

        Proyect::factory()->count(5)->create();

        // Crear 10 tags
        Tags::factory()->count(10)->create();

        // Asociar aleatoriamente proyectos con tags
        $proyectos = Proyect::all();
        $tags = Tags::all();

       
    }
}
