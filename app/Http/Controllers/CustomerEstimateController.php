<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customer;
use App\Estimate;
use App\EstimateDetails;
use Session;


class CustomerEstimateController extends Controller
{
     /* estimate index*/
     public function estimatesIndex(Request $request)
     {
         /* if the url has get method */
         $customer_id = (Session::has('id')) ? Session::get('id') : "";
         $estimates = Estimate::where('customer_id',$customer_id)->latest()->paginate(15);
         return view('customer.estimate.index', compact('estimates'));
     }

     /* show Estimate details */
    public function showEstimate(Request $request, $id)
    {
        $estimate = Estimate::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('customer.estimate.show', compact('estimate'));
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
}
