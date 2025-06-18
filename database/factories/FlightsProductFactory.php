<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Flight;
use App\Models\FlightsProduct;
use App\Models\Product;

class FlightsProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FlightsProduct::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'flights_id' => Flight::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
