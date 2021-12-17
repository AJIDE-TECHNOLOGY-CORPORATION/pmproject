<?php
namespace App\Http\Controllers;
use App\Customer;
use App\Invoice;
use App\InvoiceDetails;
use App\Item;
use App\MasterSetting;
use Illuminate\Http\Request;
use Mail;
use PDF;

class AdminInvoiceController extends Controller
{
   /* invoice index*/
    public function invoicesIndex(Request $request)
    {
        /* if the url has get method */
        $invoices = Invoice::latest()->paginate(15);
        return view('admin.invoice.index', compact('invoices'));
    }
    /* invoice creation*/
    public function createInvoice(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.invoice.create');
        } else {
            /* if the url has post method */
            $customer = Customer::find($request->customer_id);
            $invoice = new Invoice();
            $invoice->customer_id = $request->customer_id;
            $invoice->shipping_address = ($customer) ? $customer->shipping_address1 : '';
            $invoice->billing_address = ($customer) ? $customer->billing_address1 : '';
            $invoice->sub_total = $request->sub_total;
            $invoice->total = $request->net_total;
            $invoice->tax_amount = $request->tax_rate;
            $invoice->tax_name = ($request->tax_name != "") ? $request->tax_name : 'no tax';
            $invoice->tax_percentage = ($request->tax_percentage != "") ? $request->tax_percentage : 0;
            $invoice->invoice_date = $request->date;
            $invoice->due_date = $request->due_date;
            $invoice->invoice_number = $request->generated_invoice_number;
            $invoice->save();
            for ($i = 0; $i < count($request->input('name')); $i++) {
                $item = new InvoiceDetails();
                $item->invoice_id = $invoice->id;
                $item->product_name = $request->name[$i];
                $item->product_quantity = $request->qty[$i];
                $item->product_price = $request->price[$i];
                $item->total = $request->price[$i] * $request->qty[$i];
                $item->save();
            }
            return redirect()->back()->with('message', 'Invoice created Successfully.');
        }
    }

    /* get product details */
    public function getProductDetail(Request $request, $id)
    {
        $product = Item::find($id);
        return response()->json([
            'data' => $product
        ]);
    }

    /* get customer details */
    public function getCustomerDetail(Request $request, $id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            /* if opening balance is present */
            return response()->json([
                'customer' => $customer,
            ]);
        } else {
            /* if opening balance is not present */
            return response()->json([
                'data' => "error"
            ]);
        }
    }
    /* destroy invoice information*/
    public function destroyInvoice($id)
    {
        $invoice = Invoice::find($id);
        if (!empty($invoice->invoiceItemdetails())) {
            /* if invoice contains item details */
            $invoice->invoiceItemdetails()->delete();
        }
        $invoice->delete();
        return redirect()->back()->with('message', 'Invoice Destroyed Successfully');
    }
    /* get product details */
    public function getInvoiceProductDetail(Request $request, $id)
    {
        $invoice = InvoiceDetails::where('invoice_id', $id)->get();
        return response()->json([
            'data' => $invoice
        ]);
    }
    /* update invoice details */
    public function updateInvoice(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.invoice.edit', compact('invoice'));
        } else {
            /* if the url has post method */
            (!empty($invoice->invoiceItemDetails())) ? $invoice->invoiceItemDetails()->delete() : '';
            $invoice->sub_total = $request->sub_total;
            $invoice->total = $request->net_total;
            $invoice->tax_amount = $request->tax_rate;
            $invoice->invoice_date = $request->date;
            $invoice->due_date = $request->due_date;
            $invoice->tax_name = ($request->tax_name != "") ? $request->tax_name : 'no tax';
            $invoice->tax_percentage = ($request->tax_percentage != "") ? $request->tax_percentage : 0;
            $invoice->save();
            for ($i = 0; $i < count($request->input('name')); $i++) {
                $item = new InvoiceDetails();
                $item->invoice_id = $invoice->id;
                $item->product_name = $request->name[$i];
                $item->product_quantity = $request->qty[$i];
                $item->product_price = $request->price[$i];
                $item->total = $request->price[$i] * $request->qty[$i];
                $item->save();
            }
            return redirect()->back()->with('message', 'Invoice created Successfully.');
        }
    }
    /* show Invoice details */
    public function showInvoice(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.invoice.show', compact('invoice'));
        }
    }

      /* send payment Link*/
      public function sendPaymentLink(Request $request)
      {
        $stripe=0;
        $paypal=0;
        $razorpay=0;
        /*payment method availability checking */
           if($request->has('stripe')) {
               $stripe=1;
           }
          if($request->has('paypal')) {
              $paypal=1;
          }
          if($request->has('razorpay')) {
              $razorpay=1;
          }
        try {
            /* send payment link mail */
            $this->sendPaymentLinkMail($request->email,$request->customer_name,$request->id,$stripe,$paypal,$razorpay);
         } catch ( \Exception $e ) {
             /* if send payment link mail has any issues */
                 return response()->json("error");
        }

      return response()->json("success");
      }


      /* send Payment Link */
      public function sendPaymentLinkMail($email,$name,$id,$stripe,$paypal,$razorpay)
      {
        $data = array(
            'name' => $name,
            'id' => base64_encode($id),
            'email' => base64_encode($email),
            'stripe' => $stripe,
            'paypal' => $paypal,
            'razorpay' => $razorpay,
        );
        $mailData = array(
            'toEmail' => $email,
            'toSubject' => 'Welcome To Invoxi Family',
            'fromEmail' => 'hi@Invoxi.in',
            'fromName' => 'Invoxi'
        );
        Mail::send('customer-payment-link-mail', $data, function($message) use($mailData) {
            $message->to($mailData['toEmail']);
            $message->subject($mailData['toSubject']);
            $message->from($mailData['fromEmail'],$mailData['fromName']);
        });

  }


/* download pdf */
    public function downloadPdf(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $pdf = PDF::loadView('downloadPdf',compact('invoice'));
        $pdf->setPaper('A4','portrait');
        return $pdf->download('sales.pdf');
    }
}
