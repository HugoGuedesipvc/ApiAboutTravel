<?php

namespace Database\Factories;

use App\Models\Local;
use App\Models\LocalType;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocalFactory extends Factory
{
    protected $model = Local::class;

    public function definition(): array
    {
        return [
            'trip_id' => Trip::inRandomOrder()->first()->id,
            'local_type_id' => LocalType::inRandomOrder()->first()->id,
            'label' => $this->faker->sentence,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->date(),
        ];
    }
}
