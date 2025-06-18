<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Flights;

class FlightsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Flights::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'origin' => fake()->word(),
            'destination' => fake()->word(),
            'airline' => fake()->word(),
            'active' => fake()->boolean(),
        ];
    }
}
