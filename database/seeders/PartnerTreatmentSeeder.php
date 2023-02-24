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

            // Se busca un centro en el que se aplica el tratamiento
            // Solo se usa el primero porque al ser datos de ejemplo, da igual que solo rellene una empresa
            $id = $treatment->centers()->first()->id;

            // Se añade el tratamiento a 5 usuarios que pertenezcan al centro donde se aplica el tratamiento
            $treatment->partners()->syncWithPivotValues(
                Partner::whereHas('centers', function($center) use ($id) {
                    $center->where('center_id', '=', $id);
                })->get()->random(5)->pluck('id')->toArray(),
                ["date" => new DateTime()]
            );
        }
    }
}
