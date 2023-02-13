<?php

namespace Database\Factories;

use App\Models\Study;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Study>
 */
class StudyFactory extends Factory
{

    protected $model = Study::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "code" => strtoupper($this->faker->bothify('???###')),
            "name" => $this->faker->sentence(3),
            "family" => "IFC301",
            "level" => $this->faker->randomElement(['GM', 'GS'])
        ];
    }
}
