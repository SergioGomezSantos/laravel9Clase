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
        $treatments = Treatment::all();

        foreach ($treatments as $treatment) {

            $id = $treatment->centers()->first()->id;

            $treatment->partners()->syncWithPivotValues(
                Partner::whereHas('centers', function($center) use ($id) {
                    $center->where('center_id', '=', $id);
                })->get()->random(5)->pluck('id')->toArray(),
                ["date" => new DateTime()]
            );
        }
    }
}
