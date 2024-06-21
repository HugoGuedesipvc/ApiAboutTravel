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
        $initialDate = $this->faker->dateTimeBetween('-1 years', 'now');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'label' => $this->faker->sentence,
            'country_id' => Country::inRandomOrder()->first()->id,
            'location' => $this->faker->word,
            'initial_date' => $initialDate,
            'end_date' => $this->faker->dateTimeBetween($initialDate, '+1 years'),
            'description' => $this->faker->paragraph,
            'image' => 'https://via.placeholder.com/150',
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'shared' => $this->faker->boolean(25),
        ];
    }
}
