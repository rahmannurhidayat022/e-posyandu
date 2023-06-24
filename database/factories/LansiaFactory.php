<?php

namespace Database\Factories;

use App\Models\Posko;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lansia>
 */
class LansiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'posko_id' => function () {
                return Posko::factory()->create()->id;
            },
            'nama' => $this->faker->name,
            'nik' => $this->faker->unique()->randomNumber(8),
            'darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'tanggal_lahir' => $this->faker->date(),
            'jalan' => $this->faker->streetAddress,
            'rt' => $this->faker->randomNumber(2),
            'rw' => $this->faker->randomNumber(2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
