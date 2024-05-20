<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'label' => $this->faker->sentence,
            'country_id' => Country::inRandomOrder()->first()->id,
            'location' => $this->faker->word,
            'date' => $this->faker->date,
            'description' => $this->faker->paragraph,
            'image' => 'https://via.placeholder.com/150',
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'shared' => $this->faker->boolean(50),
        ];
    }
}
