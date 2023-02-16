<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\es_ES\Person as Person_ES;
use App\Models\Center;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Center>
 */
class CenterFactory extends Factory
{
    protected $model = Center::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->addProvider(new Person_ES($this->faker));

        return [
            "name" => $this->faker->company(),
            "company_reason" => $this->faker->randomElement(["SA","SL"]),
            "address" => $this->faker->address(),
            "phone" => $this->faker->phoneNumber(),
            "email" => $this->faker->email(),
            "nif" => $this->faker->dni(),
            
            "room_number" => $this->faker->numberBetween(5,10),
            "physiotherapy" => $this->faker->boolean()
        ];

        return [
            "name" => $this->faker->company(),
            "company_reason" => $this->faker->randomElement(["SA","SL"]),
            "address" => $this->faker->address(),
            "phone" => $this->faker->phoneNumber(),
            "email" => $this->faker->email(),
            "nif" => $this->faker->dni(),

            "max_capacity" => $this->faker->numberBetween(5,10),
            "unisex" => $this->faker->boolean(),
        ];
    }
}
