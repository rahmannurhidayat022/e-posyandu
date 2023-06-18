<?php

namespace Database\Factories;

use App\Models\LingkupPosko;
use App\Models\Posko;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LingkupPosko>
 */
class LingkupPoskoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LingkupPosko::class;
    public function definition(): array
    {
        return [
            'posko_id' => function () {
                return Posko::factory()->create()->id;
            },
            'rt' => $this->faker->randomNumber(2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
