<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\User;
use App\Http\Requests\StoreExpensesRequest;
use App\Http\Requests\UpdateExpensesRequest;
use App\Http\Resources\ExpensesResource;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ExpenseCreated;

class ExpensesController extends Controller
{
    /**
     * Create a new ExpensesController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExpensesResource::collection(Auth::user()->expenses);
    }

    /**
     * Store a newly created expense.
     *
     * @param StoreExpensesRequest $request The request object.
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpensesRequest $request)
    {
        $auth = Auth::user();
        $expense = $auth->expenses()->create($request->validated());
        
        $auth->notify(new ExpenseCreated($expense));
    
        return new ExpensesResource($expense);
    }

    /**
     * Display the specified expense.
     *
     * @param Expenses $expense The expense to be displayed.
     * @return \Illuminate\Http\Response
     */
    public function show(Expenses $expense)
    {
        $this->authorize('view', $expense);
        return new ExpensesResource($expense);
    }

    /**
     * Update an expense.
     *
     * @param UpdateExpensesRequest $request The request object.
     * @param Expenses $expense The expense to be updated.
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpensesRequest $request, Expenses $expense)
    {
        $this->authorize('update', $expense);
        $expense->update($request->validated());
        return new ExpensesResource($expense);
    }

    /**
     * Delete an expense.
     *
     * @param Expenses $expense The expense to be deleted.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenses $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();
        return response()->json(['message' => 'Expense deleted successfully'], 200);
    }
}
