<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Invoice;
use App\Expense;
use App\Customer;
use App\ExpenseCategory;
use Image;
use Validator;
use Hash;
use Auth;

class AdminDashboardController extends Controller
{
    /* display admin dashboard */
    public function dashboard()
    {
        /* to display chart */
        $current_year = date('Y');
        $invoice = Invoice::whereYear('invoice_date', $current_year)->sum('total');
        $expense = Expense::whereYear('date', $current_year)->sum('amount');

        $data_invoice['label'] = ['Invoice', 'Expense'];
        $data_invoice['data'] = [$invoice, $expense];

        $expense_categories = ExpenseCategory::latest()->limit(10)->get();
        $categories = [];
        $expenses = [];
        $count = 0;
        foreach ($expense_categories as $row) {
            $categories[$count] = $row->name;
            $expenses[$count++] = Expense::where('expense_category_id', $row->id)->sum('amount');
        }
        $data_expense['label'] = $categories;
        $data_expense['data'] = $expenses;
        $data['chart_data_invoice'] = json_encode($data_invoice);
        $data['chart_data_expense'] = json_encode($data_expense);
        return view('admin.dashboard', $data);
    }


    /* email availability verification */
 public function checkEmail(Request $request) {
    $email = $request->user_email;
    $flag = $request->flag;
    $id = $request->id;
    if($flag==1) {
        /* user edit section */
        $status = Customer::where('email',$email)->where('id','!=',$id)->first();
    } else {
        /* user create section */
        $status = Customer::where('email',$email)->first();
    }
    if($status) {
        /* if email already available */
        return response()->json(['Email Already Exist.']);
    } else {
        /* if the email is new one */
        return response()->json(['OK']);
    }
}
}
