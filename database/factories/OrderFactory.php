<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{

    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "solicitante" => $this->faker->word(),
            "fecha" => $this->faker->dateTime(),
            "descripcion" => $this->faker->paragraph(),
            "cliente_id" => Cliente::inRandomOrder()->first()->id,
            // "cliente_id" => $this->faker->unique()->numberBetween(1, Cliente::all()->count())
        ];
    }
}
