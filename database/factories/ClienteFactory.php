<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\es_ES\Person as Person_ES;
use Faker\Provider\es_ES\PhoneNumber as Phone_ES;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClienteFactory extends Factory
{

    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->addProvider(new Person_ES($this->faker));
        $this->faker->addProvider(new Phone_ES($this->faker));

        $random = rand(0,1);
        
        if ($random == 0){

            $phone = $this->faker->tollFreeNumber();
        }
        else{

            $phone = $this->faker->mobileNumber();
        }

        return [
            "DNI" => $this->faker->dni(),
            "Nombre" => $this->faker->firstName(),
            "Apellidos" => $this->faker->lastName() . " " . $this->faker->lastName(),
            "Telefono" => $phone,
            "Email" => $this->faker->email()
        ];
    }
}
