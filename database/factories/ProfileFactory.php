<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        return [
            'publicMail' => fake()->unique()->safeEmail(),
            'description'=> $this->faker->text(),
            'github'=> $this->faker->url(),
            'rol'=> $this->faker->word(),
            'photo_url'=> $this->faker->word(),
            'cv'=> $this->faker->word(),
            'linkedin'=> $this->faker->url() ,
            'user_id' => $this->faker->unique()->numberBetween(1, $users->count())
        ];
    }
}
            
    
