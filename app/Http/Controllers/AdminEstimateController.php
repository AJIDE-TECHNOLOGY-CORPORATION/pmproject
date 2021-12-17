<?php
namespace App\Http\Controllers;
use App\Customer;
use App\Estimate;
use App\Item;
use App\EstimateDetails;
use Illuminate\Http\Request;
class AdminEstimateController extends Controller
{
    /* estimate index*/
    public function estimatesIndex(Request $request)
    {
        /* if the url has get method */
        $estimates = Estimate::latest()->paginate(15);
        return view('admin.estimate.index', compact('estimates'));
    }
    /* estimate creation*/
    public function createEstimate(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.estimate.create');
        } else {
            /* if the url has post method */
            $customer = Customer::find($request->customer_id);
            $estimate = new Estimate();
            $estimate->customer_id = $request->customer_id;
            $estimate->shipping_address = ($customer) ? $customer->shipping_address1 : '';
            $estimate->billing_address = ($customer) ? $customer->billing_address1 : '';
            $estimate->sub_total = $request->sub_total;
            $estimate->total = $request->net_total;
            $estimate->tax_amount = $request->tax_rate;
            $estimate->tax_name = ($request->tax_name != "") ? $request->tax_name : 'no tax';
            $estimate->tax_percentage = ($request->tax_percentage != "") ? $request->tax_percentage : 0;
            $estimate->estimate_date = $request->date_estimate;
            $estimate->estimate_due_date = $request->date_estimate_due;
            $estimate->estimate_number = generate_estimatecode();
            $estimate->save();
            for ($i = 0; $i < count($request->input('name')); $i++) {
                $item = new EstimateDetails();
                $item->estimate_id = $estimate->id;
                $item->product_name = $request->name[$i];
                $item->product_quantity = $request->qty[$i];
                $item->product_price = $request->price[$i];
                $item->total = $request->price[$i] * $request->qty[$i];
                $item->save();
            }
            return response()->json("success");
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
    /* destroy estimate information*/
    public function destroyEstimate($id)
    {
        $estimate = Estimate::find($id);
        if (!empty($estimate->estimateItemdetails()) > 0) {
            /* if estimate contains item details */
            $estimate->estimateItemDetails()->delete();
        }
        $estimate->delete();
        return redirect()->back()->with('message', 'Estimate Destroyed Successfully');
    }
    /* show Estimate details */
    public function showEstimate(Request $request, $id)
    {
        $estimate = Estimate::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.estimate.show', compact('estimate'));
        }
    }
    /* show Estimate details */
    public function getEstimateDetails(Request $request, $id)
    {
        $estimate = EstimateDetails::where('estimate_id', $id)->get();
        return response()->json([
            'data' => $estimate
        ]);
    }
    /* update estimate details */
    public function updateEstimate(Request $request, $id)
    {
        $estimate = Estimate::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.estimate.edit', compact('estimate'));
        } else {
            /* if the url has post method */
            (!empty($estimate->estimateItemDetails())) ? $estimate->estimateItemDetails()->delete() : '';
            $estimate->sub_total = $request->sub_total;
            $estimate->total = $request->net_total;
            $estimate->tax_amount = $request->tax_rate;
            $estimate->estimate_date = $request->date;
            $estimate->estimate_due_date = $request->due_date;
            $estimate->tax_name = ($request->tax_name != "") ? $request->tax_name : 'no tax';
            $estimate->tax_percentage = ($request->tax_percentage != "") ? $request->tax_percentage : 0;
            $estimate->save();
            for ($i = 0; $i < count($request->input('name')); $i++) {
                $item = new EstimateDetails();
                $item->estimate_id = $estimate->id;
                $item->product_name = $request->name[$i];
                $item->product_quantity = $request->qty[$i];
                $item->product_price = $request->price[$i];
                $item->total = $request->price[$i] * $request->qty[$i];
                $item->save();
            }
            return redirect()->back()->with('message', 'estimate created Successfully.');
        }
    }
}