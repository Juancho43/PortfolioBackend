<?php

namespace Database\Factories;

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
        return [
            'name'=> $this->faker->name(),
            'description'=> $this->faker->text(),
            'startDate'=> $this->faker->date(),
            'endDate'=> $this->faker->date(),
            'type' => $this->faker->randomElement(['Formal Education','Course'])

        ];
    }
}
