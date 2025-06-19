<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Capacity;
use App\Models\Company;
use App\Models\Cart;
use App\Models\Cars;
use App\Models\Flights;
use App\Models\HistoricalOrderDetails;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Residence;
use App\Models\Stay;
use App\Models\Payment;
use App\Models\HistoricalOrders;
use App\Models\HistoricalOrderDetailsFactory;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Company::factory(10)->create();
        Capacity::factory(10)->create();
        Order::factory(10)->create();
        OrderDetail::factory(10)->create();
        Cart::factory(10)->create();
        Cars::factory(10)->create();
        Flights::factory(10)->create();
        HistoricalOrderDetails::factory(10)->create();
        HistoricalOrders::factory(10)->create();
        Product::factory(10)->create();
        Residence::factory(10)->create();
        Stay::factory(10)->create();
        Payment::factory(10)->create();

    }
}
