<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('products')->trunctae();
        // DB::table('products')->delete();

        // DB::table('products')->insert([

        //     'nombre' => 'Alicates',
        //     'descripcion' => 'Descripcion Alicates',
        //     'precio' => 3.20
        // ]);

        // DB::table('products')->insert([

        //     'nombre' => 'Martillo',
        //     'descripcion' => 'Descripcion Martillo',
        //     'precio' => 4.15
        // ]);

        Product::factory()->count(23)->create();
    }
}
