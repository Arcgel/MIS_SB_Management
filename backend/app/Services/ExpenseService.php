<?php

namespace App\Services;

use App\Models\Expense;

class ExpenseService
{
    public function createExpense(array $data)
    {
        return Expense::create($data);
    }
    public function deleteExpense($id)
    {
        $expense = Expense::findOrFail($id);
        return $expense->delete();
    }
    public function restoreExpense($id)
    {
        $expense = Expense::withTrashed()->findOrFail($id);
        return $expense->restore();
    }

    public function getAllExpenses()
    {
        return Expense::all();
    }
}
