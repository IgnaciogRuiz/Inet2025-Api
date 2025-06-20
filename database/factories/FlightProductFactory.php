<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Flight;
use App\Models\FlightProduct;
use App\Models\Product;

class flightProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FlightProduct::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'flight_id' => Flight::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
