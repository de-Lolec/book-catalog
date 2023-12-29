<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'name' => fake()->sentence(2),
          'year' => fake()->year(),
          'description' => fake()->text(),
          'image' => url('images/' . basename(Arr::random(glob(public_path('images').'/*')))),
          'author_id' => \App\Models\Author::factory(),
        ];
    }
}
