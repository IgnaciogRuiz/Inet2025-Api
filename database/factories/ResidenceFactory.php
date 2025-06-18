<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Residence;

class ResidenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Residence::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'zip_code' => fake()->word(),
            'locality' => fake()->word(),
            'street' => fake()->streetName(),
            'number' => fake()->word(),
        ];
    }
}
