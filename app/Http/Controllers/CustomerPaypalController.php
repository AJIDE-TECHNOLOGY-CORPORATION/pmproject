<?php

namespace App\Http\Controllers;

use App\CustomerPaymentHistory;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerPaypalController extends Controller
{
     /* show paypal invoice */
    public function showPaypalInvoice(Request $request,$id,$email)
    {
        $invoice = Invoice::find(base64_decode($id));
        return view('paypal.paypal',compact('invoice','email','id'));
    }

    /* payment update section */
    public function showPaypal(Request $request) {
        $customer = (Session::has('customer')) ? Session::get('customer') : "";
        /* if the payment is success */
        $amount =$request->amount;
        $email = base64_decode($request->email);
        $id = base64_decode($request->id);
        /* paypal payment history updation */
        $payment_history = new CustomerPaymentHistory();
        $payment_history->invoice_number=generate_customerinvoicenumber();
        $payment_history->invoice_id=$id;
        $payment_history->payment_id= $request->transaction_id;
        $payment_history->email=$email;
        $payment_history->date=\Carbon\Carbon::today()->toDateString();
        $payment_history->amount_paid= $request->amount;
        $payment_history->invoice_amount= $request->amount;
        $payment_history->payment_status=$request->transaction_status;
        $payment_history->save();
        /*get customer details */
        $invoice = Invoice::find($id);
        /*payment updation*/
        $payment = new \App\Payment();
        $payment->customer_id =$invoice->customer_id;
        $payment->paid_date = \Carbon\Carbon::today()->toDateString();
        $payment->paid =  $request->amount;
        $payment->payment_mode = 'paypal';
        $payment->invoice_number =  $invoice->invoice_number;
        $payment->payment_number = generate_paymentnumber();
        $payment->note = "Payment done by customer";
        $payment->save();
        /* update payment amount to invoice table */
        $invoice->invoice_status = ($invoice->total - ($invoice->paid + $request->amount) == 0) ? '1' : '0';
        $invoice->paid = $invoice->paid + $request->amount;
        $invoice->save();
        $arr = array('msg' => 'Payment successfully credited', 'status' => true);
        return Response()->json($arr);
    }
}
