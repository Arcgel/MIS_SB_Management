<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'time' => 'required|date',
            'category' => 'required|string'
        ]);

        $expense = $this->expenseService->createExpense($validated);

        return response()->json($expense, 201);
    }

    public function destroy($id)
    {
        $this->expenseService->deleteExpense($id);
        return response()->json(['message' => 'Expenses Deleted'], 200);
    }

    public function restore($id)
    {
        $this->expenseService->restoreExpense($id);
        return response()->json(['message' => 'Expenses Restored'], 200);
    }

    public function index()
    {
        $expenses = $this->expenseService->getAllExpenses();
        return response()->json($expenses, 200);
    }
}
