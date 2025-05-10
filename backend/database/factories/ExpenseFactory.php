<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;



class ExpenseFactory extends Factory
{

    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'amount' => $this->faker->randomFloat(2, 1, 10000),
            'time' => now(),
            'category' => $this->faker->word(),
        ];
    }
}
