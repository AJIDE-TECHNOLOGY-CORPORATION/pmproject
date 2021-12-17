<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Payment;
use App\Invoice;
use App\Customer;
use App\CustomerPaymentHistory;

class AdminTransactionController extends Controller
{
    /* payments index*/
    public function paymentsIndex(Request $request)
    {
        /* if the url has get method */
        $payments = Payment::latest()->paginate(15);
        return view('admin.payment.index', compact('payments'));
    }
    /* payment creation*/
    public function createPayment(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.payment.create');
        } else {
            /* if the url has post method */
            $invoice = Invoice::where('invoice_number', $request->invoice_number)->first();
            /* invoice total tally validation */ 
            if (($invoice->paid + $request->paid_amount) > $invoice->total) {
                return redirect()->back()->with('error', 'Amount Exceeds payment Amount.');
            }
            $payment = new Payment();
            $payment->customer_id = Customer::find($invoice->customer_id)->id;
            $payment->paid_date = $request->paid_date;
            $payment->paid = $request->paid_amount;
            $payment->payment_mode = $request->payment_mode;
            $payment->invoice_number = $request->invoice_number;
            $payment->payment_number = $request->payment_number;
            $payment->note = $request->note;
            $payment->save();
            /* update payment amount to invoice table */
            $invoice->invoice_status = ($invoice->total - ($invoice->paid + $request->paid_amount) == 0) ? '1' : '0';
            $invoice->paid = $invoice->paid + $request->paid_amount;
            $invoice->save();
            return redirect('/admin/payments')->with('message', 'Payment Added Successfully');
        }
    }
    /* get invoice details */
    public function getInvoiceDetail(Request $request, $invoice_number)
    {
        $invoice = Invoice::where('invoice_number', $invoice_number)->first();
        if ($invoice) {
            /* if opening balance is present */
            return response()->json([
                'invoice' => $invoice,
            ]);
        } else {
            /* if opening balance is not present */
            return response()->json([
                'data' => "error"
            ]);
        }
    }
    /* destroy payment information and amount updated to invoice*/
    public function destroyPayment($id)
    {
        $payment = Payment::find($id);
        $invoice = Invoice::where('invoice_number', $payment->invoice_number)->first();
        $invoice->paid = $invoice->paid - $payment->paid;
        $invoice->save();
        if ($invoice->total > ($invoice->paid - $payment->paid)) {
            $invoice->invoice_status = 0;
        }
        $invoice->save();
        $payment->delete();
        return redirect()->back()->with('message', 'Payment Destroyed and Amount Updated to Invoice.');
    }
    /* payment updation */
    public function updatePayment(Request $request, $id)
    {
        $payment = Payment::find($id);
        $old_amount = $payment->paid;
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.payment.create', compact('payment'));
        } else {
            /* if the url has post method */
            $invoice = Invoice::where('invoice_number', $payment->invoice_number)->first();
            $invoice->paid = $invoice->paid - $old_amount;
            $invoice->invoice_status = ($invoice->total >= ($invoice->paid - $old_amount)) ? '1' : '0';
            $invoice->save();
            $payment->paid = 0;
            $payment->save();
            $payment = Payment::find($id);
            $invoice = Invoice::where('invoice_number', $payment->invoice_number)->first();
            /* invoice total tally validation */
            if (($invoice->paid + $request->paid_amount) > $invoice->total) {
                /* revert the decrement of old amount */
                $invoice->paid = $invoice->paid + $old_amount;
                $invoice->invoice_status = ($invoice->total >= ($invoice->paid + $old_amount)) ? '1' : '0';
                $payment->paid = $old_amount;
                $payment->note = $request->note;
                $payment->save();
                $invoice->save();
                return redirect()->back()->with('error', 'Amount Exceeds payment Amount.');
            }
            $payment = Payment::find($id);
            $payment->paid_date = $request->paid_date;
            $payment->paid = $request->paid_amount;
            $payment->save();
            /* update payment amount to invoice table */
            $invoice = Invoice::where('invoice_number', $payment->invoice_number)->first();
            $invoice->invoice_status = ($invoice->total - ($invoice->paid + $request->paid_amount) == 0) ? '1' : '0';
            $invoice->paid = $invoice->paid + $request->paid_amount;
            $invoice->save();
            return redirect('/admin/payments')->with('message', 'Payment Updated Successfully');
        }
    }

       /* online transaction index*/
       public function onlineTransactionsIndex(Request $request)
       {
           $transactions = CustomerPaymentHistory::latest()->paginate(15);
           return view('admin.online-transaction.index', compact('transactions'));
       }
}