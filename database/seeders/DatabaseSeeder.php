<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;

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

        // User::factory()
        //     ->hasCategories(1, ['name' => 'Food'])
        //     ->hasCategories(1, ['name' => 'Salary'])
        //     ->hasCategories(1, ['name' => 'Shopping'])
        //     ->create([
        //         'name' => 'Mohsin Shaikh',
        //         'email' => 'admin@gmail.com',
        //     ]);
        // Income::factory(100)->create();
        // Expense::factory(100)->create();
        // Category::factory(100)->create();

        // User::factory()
        //     ->has(Category::factory()->count(10))
        //     ->has(
        //         Income::factory()->count(10)
        //         // ->for(Category::factory()->count(1))
        //     )
        //     ->has(Expense::factory()->count(10))
        //     ->create([
        //         'name' => 'Mohsin Shaikh',
        //         'email' => 'admin@gmail.com',
        //     ]);

        $user = User::factory()->create([
            'name' => 'Mohsin Shaikh',
            'email' => 'admin@gmail.com',
        ]);

        $categories = Category::factory(10)->create([
            'user_id' => $user->id,
        ]);

        Income::factory(100)->create([
            'user_id' => $user->id,
            'category_id' => $categories->random()->id,
        ]);

        Expense::factory(100)->create([
            'user_id' => $user->id,
            'category_id' => $categories->random()->id,
        ]);
    }
}
