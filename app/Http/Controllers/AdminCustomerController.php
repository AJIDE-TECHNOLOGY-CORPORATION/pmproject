<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customer;
use App\Estimate;
use App\Invoice;
use Hash;
use Validator;
use Auth;
use Image;
class AdminCustomerController extends Controller
{
    /* customer index */
    public function customersIndex(Request $request)
    {
        $customers = Customer::latest()->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }
    /* create customer details */
    public function createCustomer(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.customers.create');
        } else {
            /* if the url has post method */
            $rules = [
                'billing_address1' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return redirect('admin/customers/create')->with('error', 'Address field required.');
            }
            $customer = new Customer();
            $customer->display_name = $request->display_name;
            $customer->contact_name = $request->contact_name;
            $customer->website = $request->website;
            $customer->email = $request->email;

             /* if the request has password */
             if ($request->password != "") {
                $customer->password = Hash::make($request->password);
            }

             /* if the requst has avatar */
             if ($request->hasFile('avatar')) {
                /* if file has image */
                $image = $request->file('avatar');
                $ImageName = uniqid() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('uploads/customer')) {
                    /* if user profile folder is exits */
                    mkdir('uploads/customer', 0777, true);
                }
                Image::make($image)->resize(400, 400)->save('uploads/customer/' . $ImageName);
                $customer->avatar = $ImageName;
            }


            $customer->phone = $request->phone;
            $customer->currency = $request->currency;
            $customer->billing_address1 = $request->billing_address1;
            $customer->billing_address2 = $request->billing_address2;
            $customer->billing_address_city = $request->billing_address_city;
            $customer->billing_address_state = $request->billing_address_state;
            $customer->billing_address_zip = $request->billing_address_zip;
            $customer->billing_address_phone = $request->billing_address_phone;
            $customer->billing_address_name = $request->billing_address_name;
            $customer->billing_address_country = $request->billing_address_country;
            $customer->shipping_address1 = ($request->shipping_address1 == "") ? $request->billing_address1 : $request->shipping_address1;
            $customer->shipping_address2 = ($request->shipping_address2 == "") ? $request->billing_address2 : $request->shipping_address2;
            $customer->shipping_address_city = ($request->shipping_address_city == "") ? $request->billing_address_city : $request->shipping_address_city;
            $customer->shipping_address_state = ($request->shipping_address_state == "") ? $request->billing_address_state : $request->shipping_address_state;
            $customer->shipping_address_name = ($request->shipping_address_name == "") ? $request->billing_address_name : $request->shipping_address_name;
            $customer->shipping_address_country = ($request->shipping_address_country == "") ? $request->billing_address_country : $request->shipping_address_country;
            $customer->shipping_address_zip = ($request->shipping_address_zip == "") ? $request->billing_address_zip : $request->shipping_address_zip;
            $customer->shipping_address_phone = ($request->shipping_address_phone == "") ? $request->billing_address_phone : $request->shipping_address_phone;
            $customer->save();
            return redirect('/admin/customers')->with('message', 'Customer Created Successfully.');
        }
    }

    /* destroy customer information*/
    public function destroyCustomer($id)
    {
        $customer = Customer::find($id);
        $estimate = Estimate::where('customer_id', $id)->first();
        $invoice = Invoice::where('customer_id', $id)->first();
        $order = Order::where('customer_id', $id)->first();
        if (!empty($estimate) || (!empty($invoice)) || (!empty($order))) {
            return redirect()->back()->with('error', 'Customer Deletion Restricted.');
        }
        $customer->delete();
        return redirect()->back()->with('message', 'Customer Destroyed Successfully');
    }

    /* update customer details */
    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.customers.create', compact('customer'));
        } else {
            /* if the url has post method */
            $rules = [
                'billing_address1' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return redirect('admin/customers/create')->with('error', 'Address field required.');
            }
            $customer->display_name = $request->display_name;
            $customer->email = $request->email;
            $customer->contact_name = $request->contact_name;
            $customer->website = $request->website;
            $customer->phone = $request->phone;

             /* if the request has password */
             if ($request->password != "") {
                $customer->password = Hash::make($request->password);
            }

             /* if the requst has avatar */
             if ($request->hasFile('avatar')) {
                /* if file has image */
                $image = $request->file('avatar');
                $ImageName = uniqid() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('uploads/customer')) {
                    /* if user profile folder is exits */
                    mkdir('uploads/customer', 0777, true);
                }
                Image::make($image)->resize(400, 400)->save('uploads/customer/' . $ImageName);
                $customer->avatar = $ImageName;
            }


            $customer->currency = $request->currency;
            $customer->billing_address1 = $request->billing_address1;
            $customer->billing_address2 = $request->billing_address2;
            $customer->billing_address_city = $request->billing_address_city;
            $customer->billing_address_state = $request->billing_address_state;
            $customer->billing_address_zip = $request->billing_address_zip;
            $customer->billing_address_phone = $request->billing_address_phone;
            $customer->billing_address_name = $request->billing_address_name;
            $customer->billing_address_country = $request->billing_address_country;
            $customer->shipping_address1 = ($request->shipping_address1 == "") ? $request->billing_address1 : $request->shipping_address1;
            $customer->shipping_address2 = ($request->shipping_address2 == "") ? $request->billing_address2 : $request->shipping_address2;
            $customer->shipping_address_city = ($request->shipping_address_city == "") ? $request->billing_address_city : $request->shipping_address_city;
            $customer->shipping_address_state = ($request->shipping_address_state == "") ? $request->billing_address_state : $request->shipping_address_state;
            $customer->shipping_address_name = ($request->shipping_address_name == "") ? $request->billing_address_name : $request->shipping_address_name;
            $customer->shipping_address_country = ($request->shipping_address_country == "") ? $request->billing_address_country : $request->shipping_address_country;
            $customer->shipping_address_zip = ($request->shipping_address_zip == "") ? $request->billing_address_zip : $request->shipping_address_zip;
            $customer->shipping_address_phone = ($request->shipping_address_phone == "") ? $request->billing_address_phone : $request->shipping_address_phone;
            $customer->save();
            return redirect('/admin/customers')->with('message', 'Customer Updated Successfully.');
        }
    }
}
