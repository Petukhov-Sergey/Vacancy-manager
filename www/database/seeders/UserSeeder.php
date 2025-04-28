<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managerRole = Role::find(2);
        $workerRole = Role::find(3);
        $faker = \Faker\Factory::create('ru_RU');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Aa123456'),
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'Иванов Иван Иванович',
            'email' => 'manager@example.com',
            'password' => bcrypt('Aa123456'),
            'role_id' => 2,
        ]);

        User::create([
            'name' => 'Васильев Василий Васильевич',
            'email' => 'worker@example.com',
            'password' => bcrypt('Aa123456'),
            'role_id' => 3,
        ]);

        User::factory(10)->create()->each(function ($user) use ($managerRole, $faker) {
            $user->update([
                'name' => $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->middleName,
                'role_id' => 2,
            ]);
        });

        User::factory(10)->create()->each(function ($user) use ($workerRole, $faker) {
            $user->update([
                'name' => $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->middleName,
                'role_id' => 3,
            ]);
        });
    }
}
