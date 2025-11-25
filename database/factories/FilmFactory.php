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
            'title' => $this->faker->unique()->word(),
            'director_id' => $this->faker->numberBetween(0,100),
            'description'=>$this->faker->text(),
            'type_id'=>$this->faker->numberBetween(0, 100),
            'release_date'=>$this->faker->date(),
            'length' =>$this->faker->numberBetween(15, 1000)

        ];
    }
}
