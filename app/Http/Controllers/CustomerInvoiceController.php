<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Invoice;
use App\InvoiceDetails;
use Session;
use PDF;

class CustomerInvoiceController extends Controller
{

    /* invoice index*/
    public function invoicesIndex(Request $request)
    {
        /* if the url has get method */
        $customer_id = (Session::has('id')) ? Session::get('id') : "";
        $invoices = Invoice::where('customer_id',$customer_id)->latest()->paginate(15);
        return view('customer.invoice.index', compact('invoices'));
    }


    /* show Invoice details */
    public function showInvoice(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('customer.invoice.show', compact('invoice'));
        }
    }


    /* get product details */
    public function getInvoiceProductDetail(Request $request, $id)
    {
        $invoice = InvoiceDetails::where('invoice_id', $id)->get();
        return response()->json([
            'data' => $invoice
        ]);
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
