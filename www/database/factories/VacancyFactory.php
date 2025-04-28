<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('role_id', 2)->inRandomOrder()->first();
        $faker = \Faker\Factory::create('ru_RU');

        return [
            'user_id' => $user,
            'title' => $faker->jobTitle,
            'published_at' => $faker->dateTimeBetween('-1 month', 'now'),
            'work_date' => $faker->date(),
            'hours' => $faker->numberBetween(1, 8),
            'price' => $faker->randomFloat(2, 50, 500),
        ];
    }
}
