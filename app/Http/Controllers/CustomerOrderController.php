<?php
namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Auth;

use App\Customer;
use App\Order;
use App\OrderDetail;
use App\Item;
use Session;

class CustomerOrderController extends Controller
{
    /* order index*/
    public function ordersIndex(Request $request)
    {
        /* if the url has get method */
        $customer_id = (Session::has('id')) ? Session::get('id') : "";
        $orders = Order::where('customer_id',$customer_id )->latest()->paginate(15);
        return view('customer.order.index', compact('orders'));
    }

    /* order creation*/
    public function createOrder(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('customer.order.create');
        } else {
            /* if the url has post method */
            $customer = Customer::find((Session::has('id')) ? Session::get('id') : "");
            $order = new Order();
            $order->customer_id = (Session::has('id')) ? Session::get('id') : "";
            $order->shipping_address = ($customer) ? $customer->shipping_address1 : '';
            $order->billing_address = ($customer) ? $customer->billing_address1 : '';
            $order->sub_total = $request->sub_total;
            $order->total = $request->net_total;
            $order->tax_amount = 0;
            $order->tax_name = ($request->tax_name != "") ? $request->tax_name : 'no tax';
            $order->tax_percentage = ($request->tax_percentage != "") ? $request->tax_percentage : 0;
            $order->order_date = $request->date;
            $order->order_number = $request->generated_order_number;
            $order->save();
            for ($i = 0; $i < count($request->input('name')); $i++) {
                $item = new OrderDetail();
                $item->order_id = $order->id;
                $item->product_name = $request->name[$i];
                $item->product_quantity = $request->qty[$i];
                $item->product_price = $request->price[$i];
                $item->total = $request->price[$i] * $request->qty[$i];
                $item->save();
            }
            return redirect()->back()->with('message', 'Order created Successfully.');
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

    /* destroy order information*/
    public function destroyOrder($id)
    {
        $order = Order::find($id);
        if (!empty($order->orderItemdetails())) {
            /* if order contains item details */
            $order->orderItemdetails()->delete();
        }
        $order->delete();
        return redirect()->back()->with('message', 'Order Destroyed Successfully');
    }
    /* get product details */
    public function getOrderProductDetail(Request $request, $id)
    {
        $order = OrderDetail::where('order_id', $id)->get();
        return response()->json([
            'data' => $order
        ]);
    }
    /* update order details */
    public function updateOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('customer.order.edit', compact('order'));
        } else {
            /* if the url has post method */
            (!empty($order->orderItemDetails())) ? $order->orderItemDetails()->delete() : '';
            $order->sub_total = $request->sub_total;
            $order->total = $request->net_total;
            $order->tax_amount = 0;
            $order->order_date = $request->date;
            $order->tax_name = ($request->tax_name != "") ? $request->tax_name : 'no tax';
            $order->tax_percentage = ($request->tax_percentage != "") ? $request->tax_percentage : 0;
            $order->save();
            for ($i = 0; $i < count($request->input('name')); $i++) {
                $item = new OrderDetail();
                $item->order_id = $order->id;
                $item->product_name = $request->name[$i];
                $item->product_quantity = $request->qty[$i];
                $item->product_price = $request->price[$i];
                $item->total = $request->price[$i] * $request->qty[$i];
                $item->save();
            }
            return redirect()->back()->with('message', 'Order created Successfully.');
        }
    }
    /* show Order details */
    public function showOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('customer.order.show', compact('order'));
        }
    }

}
