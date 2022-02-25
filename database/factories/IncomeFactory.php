<?php

namespace Database\Factories;

use App\Models\Income;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2, 100, 2000),
            'entry_date' => $this->faker->dateTimeBetween('-2 months'),
            // 'user_id' => 1,
            // 'category_id' => Category::inRandomOrder()->first()->id,
            // 'category_id' => Category::all()->random()->id,
        ];
    }
}
