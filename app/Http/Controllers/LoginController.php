<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\MasterSetting;
use Validator;
use App\Customer;
use Hash;

class LoginController extends Controller
{
    /* admin login */
    public function doAdminLogin(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            $settings = new MasterSetting();
            $site = $settings->siteData();
            return view('login', compact('site'));
        } else {
            /*if the url has post method */
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'user_type' => '1'])) {
                /* user type admin and login is successful */
                return redirect('admin/dashboard');
            } else {
                /* if the credentials are incorrect */
                return redirect()->back()->with('error', 'Invalid email/password');
            }
        }
    }
    /* admin logout */
    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('/admin');
    }
     
    
    /* customer login */
    public function doCustomerLogin(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('customer-login');
        } else {
            /*if the url has post method */

            $customer = Customer::where('email',$request->email)->first();

            if( !empty($customer))
            {
                /* if the customer is available */
                $hashedPassword = $customer->password;
    
                if (Hash::check($request->password, $hashedPassword)){
                    /*if the password is correct */
                    $request->session()->put('id', $customer->id);
                    $request->session()->put('name',$customer->display_name);
                    $request->session()->put('email',$customer->email);
                    $request->session()->put('customer', 'customer');
                    return redirect('customer/dashboard');
                }
                else {
                    /*if the password is incorrect */
                    return redirect()->back()->with('error', 'Invalid email/password');
                }
                
            }else
            {
                /* if the customer is not available */
                return redirect()->back()->with('error', 'Invalid email/password');
            }
        
        }
    }

    /* customer logout */
    public function customerLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/customer');
    }
}