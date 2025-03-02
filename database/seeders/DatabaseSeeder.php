<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Education;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Link;
use App\Models\Work;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

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
        DB::table('profiles_has_education')->truncate();
        DB::table('profiles_has_works')->truncate();
        DB::table('profiles_has_links')->truncate();
        DB::table('education_has_projects')->truncate();
        DB::table('projects')->truncate();
        DB::table('education')->truncate();
        DB::table('profiles')->truncate();
        DB::table('link')->truncate();
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
        Work::factory()->count(3)->create();
        Project::factory()->count(5)->create();
        Link::factory()->count(12)->create();


        Tag::factory()->count(10)->create();
        $links= Link::all();
        $profile = Profile::find(1);
        $works = Work::all();
        $education = Education::all();

        $profile->links()->attach([$links[0],$links[1]]);
        $profile->works()->attach($works);
        $profile->education()->attach($education);





    }
}
