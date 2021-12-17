<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Session;

class CustomerTransactionController extends Controller
{
    /* payments index*/
    public function paymentsIndex(Request $request)
    {
        /* if the url has get method */
        $customer_id = (Session::has('id')) ? Session::get('id') : "";
        $payments = Payment::where('customer_id',$customer_id)->latest()->paginate(15);
        return view('customer.payment.index', compact('payments'));
    }
}
