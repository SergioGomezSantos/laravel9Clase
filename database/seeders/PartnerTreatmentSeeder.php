<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Treatment;
use App\Models\Partner;
use DateTime;

class PartnerTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Treatment::factory()->count(23)->create()->each(function($treatment){
            
            $treatment->partners()->syncWithPivotValues(
                Partner::all()->random(10)->pluck('id')->toArray(),
                ["date" => new DateTime()]
            );
        });
    }
}
