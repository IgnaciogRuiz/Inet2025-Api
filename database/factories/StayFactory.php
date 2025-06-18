<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Stay;

class StayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stay::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'duration' => fake()->word(),
            'type' => fake()->randomElement(["hotel","hostel","apartment"]),
            'active' => fake()->boolean(),
        ];
    }
}
