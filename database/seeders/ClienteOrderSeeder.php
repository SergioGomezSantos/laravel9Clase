<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Order;

class ClienteOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count(22)->create();

        Cliente::factory()->count(40)->create()->each(function($cliente) {

            $cliente->orders()->sync(

                Order::all()->random(4)
            );
            
        });
    }
}
