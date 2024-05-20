<?php

namespace Database\Factories;

use App\Models\LocalType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocalTypeFactory extends Factory
{
    protected $model = LocalType::class;

    public function definition(): array
    {
        return [
            'label' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }
}
