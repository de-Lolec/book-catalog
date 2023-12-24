<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = [
            'Россия',
            'Казахстан',
            'Финляндия',
            'Греция',
            'Бельгия',
        ];

        return [
          'name' => fake()->name(),
          'country' => fake()->randomElement($countries),
          'comment' => fake()->text(),
        ];
    }
}
