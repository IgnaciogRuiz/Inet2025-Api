<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Cart;
use App\Models\car;
use App\Models\Flight;
use App\Models\HistoricalOrderDetails;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Residence;
use App\Models\Stay;
use App\Models\Payment;
use App\Models\HistoricalOrders;



// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'email' => env('ADMIN_EMAIL'),
            'firstname' => env('ADMIN_FIRSTNAME'),
            'lastname' => env('ADMIN_LASTNAME'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'admin' => true,
        ]);



        User::factory(10)->create();
        Company::factory(1)->create();
        Order::factory(10)->create();
        OrderDetail::factory(10)->create();
        Cart::factory(10)->create();
        //car::factory(10)->create();
        //Flight::factory(10)->create();
        HistoricalOrders::factory(10)->create();
        HistoricalOrderDetails::factory(10)->create();
        Product::factory(10)->create();
        Residence::factory(10)->create();
        Stay::factory(10)->create();
        Payment::factory(10)->create();
    }
}
