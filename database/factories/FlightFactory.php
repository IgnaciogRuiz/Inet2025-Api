<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Flight;

class flightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Flight::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'origin' => fake()->word(),
            'destination' => fake()->word(),
            'airline' => fake()->word(),
        ];
    }
}
