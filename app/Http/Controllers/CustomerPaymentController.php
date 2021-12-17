<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Invoice;
use App\Payment;
use App\Currency;
use Stripe;
use App\MasterSetting;
use App\CustomerPaymentHistory;
use Hash;
use Carbon\carbon;
use Illuminate\Support\Facades\Session;

class CustomerPaymentController extends Controller
{
   /* initialize stripe payment */
    public function showStripeInvoice(Request $request,$id,$email) {

        $invoice = Invoice::find(base64_decode($id));
        return view('invoice',compact('invoice','email','id'));
    }

       /* initialize stripe payment */
       public function showStripe(Request $request,$id,$email) {
        $email = base64_decode($email);
        $id = base64_decode($id);
        $invoice = Invoice::find($id);
         return view('stripe',compact('invoice','email'));
    }

 /* stripe payment section (after transaction) */
 public function stripePost(Request $request)
 {
    $settings = new MasterSetting();
    $site = $settings->siteData();
    $site_currency_code = ($site['default_currency_code'] && $site['default_currency_code']) !=""? $site['default_currency_code'] : 'USD';
     $id = $request->id;
     $email = $request->email;
     $settings=new MasterSetting();
     $site=$settings->siteData();
     Stripe\Stripe::setApiKey($site['stripe_secret']);

    try {
          $charge =   Stripe\Charge::create ([
            "amount" => $request->amount*100,
            "currency" => $site_currency_code,
            "source" => $request->stripeToken,
            "description" => "customer payment"

        ]);

        $customer = (Session::has('customer')) ? Session::get('customer') : "";

        if($charge->status=="succeeded") {
          /* if the payment is success */
          $amount =$request->amount;

          /* stripe payment hist ory updation */
          $payment_history = new CustomerPaymentHistory();
          $payment_history->invoice_number=generate_customerinvoicenumber();
          $payment_history->invoice_id=$request->id;
          $payment_history->payment_id=$charge->id;
          $payment_history->email=$request->email;
          $payment_history->date=\Carbon\Carbon::today()->toDateString();
          $payment_history->amount_paid= $request->amount;
          $payment_history->invoice_amount= $request->amount;
          $payment_history->payment_status=$charge->status;
          $payment_history->save();
          /*get customer details */
           $invoice = Invoice::find($request->id);
          /*payment updation*/
          $payment = new Payment();
          $payment->customer_id =$invoice->customer_id;
          $payment->paid_date = \Carbon\Carbon::today()->toDateString();
          $payment->paid =  $request->amount;
          $payment->payment_mode = 'stripe';
          $payment->invoice_number =  $invoice->invoice_number;
          $payment->payment_number = generate_paymentnumber();
          $payment->note = "Payment done by customer";
          $payment->save();

         /* update payment amount to invoice table */
         $invoice->invoice_status = ($invoice->total - ($invoice->paid + $request->amount) == 0) ? '1' : '0';
         $invoice->paid = $invoice->paid + $request->amount;
         $invoice->save();
         if(!empty($customer)) {
           return redirect('/customer/invoices')->with('message', 'Payment Sent Successfully.');
         } else {
           return view('transaction-success');
         }
        } else
        {
          /* if transaction is not successful */
          if(!empty($customer)) {
            return redirect('/customer/invoices')->with('error', 'Something went wrong. Please contact support team.');
          } else {
            return view('transaction-failure');
          }
        }

    } catch ( \Exception $e ) {
          /* if transaction has any issues */
          if(!empty($customer)) {
                  return redirect('/customer/invoices')->with('error', 'Something went wrong. Please contact support team.');
          } else {
                  return view('transaction-failure');
          }
     }

    }
}
