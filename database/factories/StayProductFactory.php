<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Stay;
use App\Models\StayProduct;

class StayProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StayProduct::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'stay_id' => Stay::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
