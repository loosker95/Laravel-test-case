<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::InRandomOrder()->first()->id,
            'title' => $this->faker->sentence(),
            'summary' => $this->faker->realText(),
            'body' => $this->faker->realText($minNbChars = 1000, $indexSize = 2),
        ];
    }
}
