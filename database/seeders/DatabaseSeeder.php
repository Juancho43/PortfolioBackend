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
        DB::table('projects_has_tags')->truncate();
        DB::table('projects_has_links')->truncate();
        DB::table('works_has_tags')->truncate();
        DB::table('works_has_links')->truncate();
        DB::table('education_has_projects')->truncate();
        DB::table('projects')->truncate();
        DB::table('education')->truncate();
        DB::table('profiles')->truncate();
        DB::table('links')->truncate();
        DB::table('links')->truncate();
        $profile = Profile::factory()->create([
           'user_id' =>1,
           'name' => 'Bravo, Juan Alé',
            'rol' => 'Profesional IT',
            'description' => 'Analista programador y técnico informatico profesional y personal.',
       ]);

        Education::factory()->count(3)->create();
        Work::factory()->count(3)->create();
        Project::factory()->count(5)->create();
        Link::factory()->count(12)->create();


        Tag::factory()->count(10)->create();
        $links= Link::all();
        $profile = Profile::find(1);
        $works = Work::all();
        $education = Education::all();
        $tags = Tag::all();
        $projects = Project::all();

        $link = Link::create([
             'name' => 'github',
            'link' => 'https://github.com/Juancho43'
        ]);
        $link2 = Link::create([
            'name' => 'mail',
           'link' => 'bravojuan@bravojuan.site'
        ]);
       $link3 = Link::create([
        'name' => 'linkedin',
       'link' => 'https://www.linkedin.com/in/juan-bravo-1995b61a0/'
        ]);
       
        $profile->links()->attach([$link,$link2,$link3]);
        $profile->works()->attach($works);
        $profile->education()->attach($education);

       $works[0]->links()->attach([$links[2],$links[3]]);
       $works[1]->links()->attach($links[4]);
       $works[2]->links()->attach($links[5]);
       $works[0]->tags()->attach([$tags[0],$tags[1]]);
       $works[1]->tags()->attach([$tags[2],$tags[1]]);
       $works[2]->tags()->attach([$tags[1],$tags[4]]);

       $projects[0]->links()->attach($links[6]);
       $projects[1]->links()->attach($links[7]);
       $projects[0]->tags()->attach([$tags[1],$tags[2],$tags[3]]);
       $projects[1]->tags()->attach([$tags[2],$tags[5],$tags[3]]);

       $education[0]->project()->attach([$projects[0],$projects[1]]);
       $education[1]->project()->attach([$projects[2],$projects[3],$projects[4]]);
       $education[0]->tags()->attach([$tags[1],$tags[2],$tags[3]]);
       $education[1]->tags()->attach([$tags[2],$tags[5],$tags[3]]);
    }
}
