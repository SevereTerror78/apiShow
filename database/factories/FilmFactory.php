<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    use RefreshDatabase;

    protected $films = Film::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     * 'title' => 'Avatar', 'director_id' =>'1', 'description' =>'alma', 'type_id' => '1'
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(2),
            'release_date' => $this->faker->date(),
            'description' => $this->faker->paragraph(),
            'image' => null,
            'length' => $this->faker->numberBetween(60, 180),
            'type_id' => 1,
            'director_id' => null,
        ];
    }
}
