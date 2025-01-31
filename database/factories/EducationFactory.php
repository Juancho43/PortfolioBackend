<?php

namespace Database\Factories;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $profiles = Profile::all();
        return [
            'name'=> $this->faker->name(),
            'description'=> $this->faker->text(),
            'startDate'=> $this->faker->date(),
            'endDate'=> $this->faker->date(),
            
            'type' => $this->faker->randomElement(['Academico','Curso']),
            'profile_id' => $this->faker->numberBetween(1, $profiles->count())
        ];
    }
}
