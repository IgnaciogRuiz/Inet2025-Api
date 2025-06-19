<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\HistoricalOrderDetails;
use App\Models\HistoricalOrders;
use App\Models\Product;

class HistoricalOrderDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HistoricalOrderDetails::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(-10000, 10000),
            'subtotal_price' => fake()->randomFloat(2, 0, 999999.99),
            'historical_orders_id' => HistoricalOrders::factory(),
        ];
    }
}
