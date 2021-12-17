<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use Illuminate\Http\Request;
use Image;
use Validator;
use Hash;
use Auth;
use App\Invoice;
use App\Expense;
use App\Customer;
use Session;

class CustomerDashboardController extends Controller
{
        /* display customer dashboard */
        public function dashboard()
        {
            /* to display chart */
            $customer_id = (Session::has('id')) ? Session::get('id') : "";

            $current_year = date('Y');
              $invoice = Invoice::whereYear('invoice_date', $current_year)->where('customer_id',$customer_id)->sum('total');
        $expense = Expense::whereYear('date', $current_year)->where('customer_id',$customer_id)->sum('amount');

        $data_invoice['label'] = ['Invoice', 'Expense'];
        $data_invoice['data'] = [$invoice, $expense];

        $expense_categories = ExpenseCategory::latest()->limit(10)->get();
        $categories = [];
        $expenses = [];
        $count = 0;
        foreach ($expense_categories as $row) {
            $categories[$count] = $row->name;
            $expenses[$count++] = Expense::where('expense_category_id', $row->id)->sum('amount');
        }
        $data_expense['label'] = $categories;
        $data_expense['data'] = $expenses;
        $data['chart_data_invoice'] = json_encode($data_invoice);
        $data['chart_data_expense'] = json_encode($data_expense);
        return view('customer.dashboard', $data);
        }


        /* email availability verification */
     public function checkEmail(Request $request) {
        $email = $request->user_email;
        $flag = $request->flag;
        $id = $request->id;
        if($flag==1) {
            /* user edit section */
            $status = Customer::where('email',$email)->where('id','!=',$id)->first();
        } else {
            /* user create section */
            $status = Customer::where('email',$email)->first();
        }
        if($status) {
            /* if email already available */
            return response()->json(['Email Already Exist.']);
        } else {
            /* if the email is new one */
            return response()->json(['OK']);
        }
    }


     /* update customer details */
     public function editProfile(Request $request,$id)
     {
         $base_id = base64_decode($id);
         $customer = Customer::find($base_id);
         if ($request->isMethod('get')) {
             /* if the url has get method */
             return view('customer.edit-profile', compact('customer'));
         } else {
             /* if the url has post method */
             $rules = [
                 'billing_address1' => 'required',
             ];
             $validator = Validator::make($request->all(), $rules);
             if ($validator->fails()) {
                 /* if the validation fails */
                 return redirect('customer/edit-profile/'.$id)->with('error', 'Address field required.');
             }

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

             $customer->display_name = $request->display_name;
             $customer->email = $request->email;
             $customer->contact_name = $request->contact_name;
             $customer->website = $request->website;
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
             return redirect('customer/edit-profile/'.$id)->with('message', 'Profile Updated Successfully.');
         }
     }
}
