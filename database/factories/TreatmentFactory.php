<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Treatment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Treatment>
 */
class TreatmentFactory extends Factory
{
    protected $model = Treatment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $treatments = ['Botox capilar', 'Tratamiento con queratina', 'Lifting capilar', 'Nanoplastia', 'Velaterapia', 'Microneedling', 'Depilación laser', 'Tratamiento Kaula', 'Radiofrecuencia facial', 'Terapia fotobiológica', 'Skin Poetry', 'Masaje facial', 'Mesoterapia antioxidante', 'Tratamiento exfoliante purificante',' Pedicura médica Deluxe', 'Tratamiento Pramasama', 'Tratamiento de lumilidad Exprés', 'Tratamientos con caña de azúcar', 'Pépticos', 'Lifting Japonés', 'Lifting', 'Exfoliación con punta de diamante', 'Masaje contra el insomnio', 'Presoterapia', 'Tratamientos reductores combinados', 'Hidrolipoclasia', 'Cavitación', 'Tratamientos contra el acné', 'Reforzar y aportar firmeza', 'Tratamiento con oro', 'Redensificación cutánea', 'Carbon Peel Flash', 'Toxina butolínica', 'Rellenos de ácido hialurónico', 'Tratamiento Definitive con Olaplex', 'Top Cure con bótox', 'Tratamiento repair and glow', 'Tratamiento post-Queratina', 'Hidratación de Balmain', 'Hidratación con proteína de seda', 'Hidratación de elixir de argán', 'Drenaje linfático', 'Cupping', 'Carboxiterapia', 'Permanente de pestañas', 'Pedicura', 'Manicura', 'Maquillaje'];
        
        return [
            "name" => $this->faker->randomElement($treatments),
            "price" => $this->faker->randomFloat(2,2,40)
        ];
    }
}
