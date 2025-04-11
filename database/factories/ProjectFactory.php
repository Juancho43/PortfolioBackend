<?php

namespace Database\Factories;
use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            $name = $this->faker->sentence(3);
        return [
            'name'=> $name,
            'slug' => Str::slug($name),
            'description'=> $this->faker->text(),

        ];
    }
}
