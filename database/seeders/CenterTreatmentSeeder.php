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
        $treatments = Treatment::all();
        $centers = Center::all();

        foreach ($treatments as $treatment) {
            $treatment->centers()->sync($centers->random(2));
        }
    }
}
