<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\CarsProduct;
use App\Models\Product;

class CarsProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarsProduct::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cars_id' => Car::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
