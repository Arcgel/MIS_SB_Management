<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Expense;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;



    public function test_expense_can_be_created(): void
    {
    $response = $this->post(route('add.expense'), [
        'name' => 'Rent',
        'amount' => 4000.00,
        'time' => now(),
        'category' => 'Essentials'
    ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('expenses', ['name' => 'Rent']);
    }

    public function test_expense_can_be_deleted_and_can_be_restored()
    {
        $expense = Expense::factory()->create([
            'name' => 'Electricity',
            'amount' => 600.00,
            'time' => now(),
            'category' => 'Essentials'
        ]);
        dump(Expense::count());

        $response = $this->delete(route('delete.expense', ['id' => $expense->id]));
        $response->assertStatus(200);
        $this->assertSoftDeleted('expenses', ['id' => $expense->id]);

        dump(Expense::withTrashed()->find($expense->id));

        $response = $this->post(route('restore.expense', ['id' => $expense->id]));

        $response->assertStatus(200);

        $restoredExpense = Expense::find($expense->id);
        dump($restoredExpense);

        $this->assertDatabaseHas('expenses', [
        'id' => $expense->id,
        'name' => 'Electricity',
        'amount' => 600.00,
        'category' => 'Essentials',
        'deleted_at' => null
    ]);
    }

    public function test_expences_can_be_listed()
    {
        $expenses = [
        ['name' => 'Electricity', 'amount' => 600.00, 'time' => now(), 'category' => 'Essentials'],
        ['name' => 'Rent', 'amount' => 4000.00, 'time' => now(), 'category' => 'Essentials'],
        ['name' => 'Cups', 'amount' => 195.00, 'time' => now(), 'category' => 'Materials']
        ];

        foreach ($expenses as $expense) {
        Expense::factory()->create($expense);
        }


        $response = $this->get(route('list.expenses'));
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}
