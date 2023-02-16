<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Partner;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "surnames" => $this->faker->lastName() . " " . $this->faker->lastName(),
            "address" => $this->faker->address(),
            "phone" => $this->faker->phoneNumber(),
            "email" =>$this->faker->email(),
        ];
    }
}
