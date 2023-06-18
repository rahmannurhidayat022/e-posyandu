<?php

namespace Database\Factories;

use App\Models\Posko;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posko>
 */
class PoskoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Posko::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'jalan' => $this->faker->streetAddress,
            'rw' => $this->faker->unique()->randomNumber(2),
        ];
    }
}
