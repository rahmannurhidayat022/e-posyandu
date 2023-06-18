<?php

namespace Database\Factories;

use App\Models\Kader;
use App\Models\Posko;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kader>
 */
class KaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Kader::class;
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'posko_id' => function () {
                return Posko::factory()->create()->id;
            },
            'nama' => $this->faker->name,
            'nik' => $this->faker->unique()->randomNumber(8),
            'telp' => $this->faker->phoneNumber,
            'jalan' => $this->faker->streetAddress,
            'rt' => $this->faker->randomNumber(2),
            'rw' => $this->faker->randomNumber(2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
