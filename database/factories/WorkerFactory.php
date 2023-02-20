<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\es_ES\Person as Person_ES;
use App\Models\Worker;
use App\Models\Center;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->addProvider(new Person_ES($this->faker));

        return [
            "name" => $this->faker->unique()->firstName,
            "password" => $this->faker->password(),
            "role" => $this->faker->randomElement(["admin","manager"]),
            "center_id" => Center::inRandomOrder()->first()->id
        ];
    }
}
