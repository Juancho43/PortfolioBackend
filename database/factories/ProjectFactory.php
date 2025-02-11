<?php

namespace Database\Factories;
use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyect>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $education = Education::all();
        return [
            'name'=> $this->faker->name(),
            'description'=> $this->faker->text(),
            'repository'=> $this->faker->text(),
            'education_id' => $this->faker->numberBetween(1, $education->count())
            
        ];
    }
}
