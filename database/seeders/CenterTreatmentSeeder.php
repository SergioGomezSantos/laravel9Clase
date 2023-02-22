<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Treatment;
use App\Models\Center;

class CenterTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $centers = Center::all();

        Treatment::factory()->count(23)->create()->each(function($treatment) use ($centers){
            $treatment->centers()->sync($centers->random(2));
        });
    }
}
