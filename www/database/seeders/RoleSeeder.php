<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'Супер-админ', 'slug' => 'super_admin'],
            ['name' => 'Менеджер вакансий', 'slug' => 'manager'],
            ['name' => 'Исполнитель работ', 'slug' => 'worker'],
        ]);
    }
}
