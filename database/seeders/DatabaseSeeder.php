<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()
            ->hasCategories(1, ['name' => 'Food'])
            ->hasCategories(1, ['name' => 'Salary'])
            ->hasCategories(1, ['name' => 'Shopping'])
            ->create([
                'name' => 'Mohsin Shaikh',
                'email' => 'admin@gmail.com',
            ]);
    }
}
