<?php

namespace App\Http\Controllers;

use App\OrderDetail;
use Illuminate\Http\Request;
use App\Order;
use App\Invoice;
use App\InvoiceDetails;

class AdminOrderController extends Controller
{
    /* order index*/
    public function ordersIndex(Request $request)
    {
        /* if the url has get method */
        $orders = Order::latest()->paginate(15);
        return view('admin.order.index', compact('orders'));
    }

    /* show Order details */
    public function showOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.order.show', compact('order'));
        }
    }


    /* get product details */
    public function getOrderProductDetail(Request $request, $id)
    {
        $order = OrderDetail::where('order_id', $id)->get();
        return response()->json([
            'data' => $order
        ]);
    }


    /* change order Status */
    public function changeOrderStatus(Request $request)
    {

        $order = Order::find($request->order_id);
        $order->order_status=$request->order_status;
        $order->save();

        return response()->json("success");

    }

    /* download pdf */
    public function convertToInvoice(Request $request)
    {
        $order = Order::find($request->id);
        $invoice = new Invoice();
        $invoice->customer_id = $order->customer_id;
        $invoice->shipping_address = $order->shipping_address;
        $invoice->billing_address = $order->billing_address;
        $invoice->sub_total = $order->sub_total;
        $invoice->total =$order->total;
        $invoice->tax_amount = $order->tax_amount;
        $invoice->tax_name =$order->tax_name;
        $invoice->tax_percentage =$order->tax_percentage;
        $invoice->invoice_date = \Carbon\Carbon::today();
        $invoice->invoice_number = generate_invoicenumber();
        $invoice->save();
        foreach($order->orderItemDetails as $row) {
            $item = new InvoiceDetails();
            $item->invoice_id = $invoice->id;
            $item->product_name = $row->product_name;
            $item->product_quantity = $row->product_quantity;
            $item->product_price = $row->product_price;
            $item->total = $row->product_quantity * $row->product_price;
            $item->save();
        }

        $order->invoice_id = $invoice->id;
        $order->invoice_status = 1;
        $order->save();
        return redirect('admin/orders/')->with('message', 'Invoice created Successfully.');
    }
}
