<?php

namespace App\Http\Controllers;

use App\Checkout;
use App\CustomerPaymentHistory;
use App\Invoice;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use App\MasterSetting;

class CustomerRazorpayController extends Controller
{
    public function showRazorpay(Request $request,$id,$email)
    {
        $invoice = Invoice::find(base64_decode($id));
        return view('razorpay.razorpay',compact('invoice','email','id'));
    }

    public function razorPaySuccess(Request $request){
        $settings = new MasterSetting();
        $site = $settings->siteData();
        $razorpay_key = ($site['razorpay_key'] && $site['razorpay_key']) != '' ? $site['razorpay_key'] : '';
        $razorpay_secret = ($site['razorpay_secret'] && $site['razorpay_secret']) != '' ? $site['razorpay_secret'] : '';

        $razorpay_payment_id = $request->razorpay_payment_id;
        $api = new Api($razorpay_key,$razorpay_secret);
        $payment = $api->payment->fetch($razorpay_payment_id);
        if(count($request->all())  && !empty($razorpay_payment_id)) {
            try {
                $response = $api->payment->fetch($razorpay_payment_id)->capture(array('amount' => $payment['amount']));
            } catch (\Exception $e) {
                return $e->getMessage();
                \Session::put('error', $e->getMessage());
                return redirect()->back();
            }
            $customer = (Session::has('customer')) ? Session::get('customer') : "";
            /* if the payment is success */
            $amount =$request->amount;
            $email = base64_decode($request->email);
            $id = base64_decode($request->id);
            /* stripe payment hist ory updation */
            $payment_history = new CustomerPaymentHistory();
            $payment_history->invoice_number=generate_customerinvoicenumber();
            $payment_history->invoice_id=$id;
            $payment_history->payment_id= $request->razorpay_payment_id;
            $payment_history->email=$email;
            $payment_history->date=\Carbon\Carbon::today()->toDateString();
            $payment_history->amount_paid= $request->amount;
            $payment_history->invoice_amount= $request->amount;
            $payment_history->payment_status='test';
            $payment_history->save();
            /*get customer details */
            $invoice = Invoice::find($id);
            /*payment updation*/
            $payment = new Payment();
            $payment->customer_id =$invoice->customer_id;
            $payment->paid_date = \Carbon\Carbon::today()->toDateString();
            $payment->paid =  $request->amount;
            $payment->payment_mode = 'razorpay';
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

}
