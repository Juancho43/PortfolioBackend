<?php

namespace Database\Factories;
use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    protected $model = Education::class;
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
            'start_date'=> $this->faker->date(),
            'end_date'=> $this->faker->date(),
        ];
    }
}
