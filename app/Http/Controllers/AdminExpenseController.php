<?php
namespace App\Http\Controllers;
use App\Expense;
use Illuminate\Http\Request;
class AdminExpenseController extends Controller
{
    /* expense index*/
    public function expensesIndex(Request $request)
    {
        /* if the url has get method */
        $expenses = Expense::latest()->paginate(15);
        return view('admin.expense.index', compact('expenses'));
    }
    /* expense creation*/
    public function createExpense(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.expense.create');
        } else {
            /* if the url has post method */
            $expense = new Expense();
            $expense->customer_id = $request->customer_id;
            $expense->expense_category_id = $request->expense_category_id;
            $expense->date = $request->date;
            $expense->amount = $request->amount;
            $expense->note = $request->note;
            $expense->save();
            return redirect('/admin/expenses')->with('message', 'Expense created Successfully.');
        }
    }
    /* destroy expense information*/
    public function destroyExpense($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        return redirect()->back()->with('message', 'Expense Destroyed Successfully');
    }
    /* Expense updation */
    public function updateExpense(Request $request, $id)
    {
        $expense = Expense::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.expense.create', compact('expense'));
        } else {
            /* if the url has post method */
            $expense->customer_id = $request->customer_id;
            $expense->expense_category_id = $request->expense_category_id;
            $expense->date = $request->date;
            $expense->amount = $request->amount;
            $expense->note = $request->note;
            $expense->save();
            return redirect('/admin/expenses')->with('message', 'Expense Updated Successfully');
        }
    }
}