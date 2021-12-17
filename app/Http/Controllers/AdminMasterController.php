<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\MasterSetting;
use App\User;
use App\ExpenseCategory;
use App\TaxType;
use App\PaymentMode;
use App\Currency;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Expense;
use Auth;
use Image;
use Validator;
class AdminMasterController extends Controller
{
    /* Account Master */
    public function mastersAccountIndex(Request $request)
    {
        $settings = new MasterSetting();
        $site = $settings->siteData();
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('get')) {
            /* url has get method */
            return view('admin.master.index-account', compact('site', 'user'));
        } else {
            /* url has post method */
            $request->validate([
                'email' => 'unique:users,email,' . $user->id,
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            /* if the request has password */
            if ($request->password != "") {
                $user->password = Hash::make($request->password);
            }
            /* if the requst has avatar */
            if ($request->hasFile('avatar')) {
                /* if file has image */
                $image = $request->file('avatar');
                $ImageName = uniqid() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('uploads/profile')) {
                    /* if user profile folder is exits */
                    mkdir('uploads/profile', 0777, true);
                }
                Image::make($image)->resize(400, 400)->save('uploads/profile/' . $ImageName);
                $user->avatar = $ImageName;
            }
            $user->phone = $request->phone;
            if ($user->save()) {
                /* if account setting updation is success */
                return redirect('admin/masters/account/')->with('message', 'AccountSetting Updated Successfully.');
            } else {
                /* if account setting updation is failure */
                return redirect('admin/profile/edit-profile/')->with('error', 'Something went wrong.');
            }
        }
    }
    /* Company Master */
    public function mastersCompanyIndex(Request $request)
    {
        $settings = new MasterSetting();
        $site = $settings->siteData();
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('get')) {
            /* url has get method */
            return view('admin.master.index-company', compact('site', 'user'));
        } else {
            $site['company_name'] = $request->company_name;
            $site['site_title'] = $request->site_title;
            $site['company_address1'] = $request->company_address1;
            $site['company_address2'] = $request->company_address2;
            $site['company_phone'] = $request->company_phone;
            $site['company_email'] = $request->company_email;
            $site['company_zip'] = $request->company_zip;
            $site['company_country'] = $request->company_country;
            $site['company_state'] = $request->company_state;
            $site['company_city'] = $request->company_city;
            if ($request->hasFile('site_logo')) {
                /* if the request has site logo */
                $image = $request->file('site_logo');
                $ImageName = uniqid() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('uploads/logo')) {
                    /* if the specified folder not exists */
                    mkdir('uploads/logo', 0777, true);
                }
                Image::make($image)->resize(240, 68)->save('uploads/logo/' . $ImageName);
                $site['site_logo'] = $ImageName;
            }
            /* favicon update */
            if ($request->hasFile('favicon')) {
                /* if the request has favicon image */
                $image = $request->file('favicon');
                $ImageName = uniqid() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('uploads/favicon')) {
                    /* if the specified folder not exists */
                    mkdir('uploads/favicon', 0777, true);
                }
                Image::make($image)->resize(68, 68)->save('uploads/favicon/' . $ImageName);
                $site['favicon'] = $ImageName;
            }
            /* create or if exists update the details */
            foreach ($site as $key => $value) {
                MasterSetting::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
            }
            return redirect()->back()->with('message', 'Information updated successfully.');
        }
    }
    /* Company Master */
    public function mastersPreferenceIndex(Request $request)
    {
        $settings = new MasterSetting();
        $site = $settings->siteData();
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('get')) {
            /* url has get method */
            return view('admin.master.index-preferences', compact('site', 'user'));
        } else {
            $currency = Currency::find($request->default_currency);
            $site['default_timezone'] = $request->default_timezone;
            $site['default_currency'] = $currency->symbol;
            $site['default_currency_code'] = $currency->code;
            $site['default_financialyear'] = $request->default_financialyear;
            $site['default_dateformat'] = $request->default_dateformat;
            /* create or if exists update the details */
            foreach ($site as $key => $value) {
                MasterSetting::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
            }
            return redirect()->back()->with('message', 'Information updated successfully.');
        }
    }
    /* expense Category Insertion */
    public function expenseCategoryIndex(Request $request)
    {
        $expense_categories = ExpenseCategory::latest()->paginate(15);
        if ($request->isMethod('get')) {
            /* url has get method */
            return view('admin.master.index-expense-category', compact('expense_categories'));
        } else {
            $rules = [
                'expense_category_name' => Rule::unique('expense_categories', 'name')
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }
            $expense_category = new ExpenseCategory();
            $expense_category->name = $request->expense_category_name;
            $expense_category->description = $request->description;
            $expense_category->is_active = 1;
            $expense_category->save();
            return response()->json("success");
        }
    }
    /* destroy expense category information*/
    public function destroyExpenseCategory($id)
    {
        $expenseCategory = ExpenseCategory::find($id);
        $expense = Expense::where('expense_category_id',$id)->first();
        /* if expence categoroy is restricted */
        if(!empty($expense)) {
            return redirect()->back()->with('error', 'Expense Category Deletion Restricted.');
        }
        $expenseCategory->delete();
        return redirect()->back()->with('message', 'Expense Category Destroyed Successfully');
    }
    /* update Expense Category details */
    public function updateExpenseCategory(Request $request, $id)
    {
        $expense_category = ExpenseCategory::find($id);
        if ($request->isMethod('get')) {
            /* url has get method */
            return response()->json([
                'data' => $expense_category
            ]);
        } else {
            /* url has post method */
            $rules = [
                'expense_category_name' => Rule::unique('expense_categories', 'name')->ignore($id)
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }
            $expense_category->name = $request->expense_category_edit_name;
            $expense_category->description = $request->expense_category_edit_description;
            $expense_category->save();
            return response()->json("success");
        }
    }
    /* tax creation */
    public function taxIndex(Request $request)
    {
        $taxes = TaxType::latest()->paginate(15);
        if ($request->isMethod('get')) {
            /* url has get method */
            return view('admin.master.index-tax-type', compact('taxes'));
        } else {
            $rules = [
                'tax_name' => Rule::unique('tax_types', 'name')
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }
            $tax = new TaxType();
            $tax->name = $request->tax_name;
            $tax->percentage = $request->tax_percentage;
            $tax->description = $request->tax_description;
            $tax->save();
            return response()->json("success");
        }
    }
    /* destroy Tax information*/
    public function destroyTax($id)
    {
        $tax = TaxType::find($id);
        $tax->delete();
        return redirect()->back()->with('message', 'Tax Destroyed Successfully');
    }
    /* update Tax details */
    public function updateTax(Request $request, $id)
    {
        $tax = TaxType::find($id);
        if ($request->isMethod('get')) {
            /* url has get method */
            return response()->json([
                'data' => $tax
            ]);
        } else {
            /* url has post method */
            $rules = [
                'edit_tax_name' => Rule::unique('tax_types', 'name')->ignore($id)
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }
            $tax->name = $request->tax_edit_name;
            $tax->percentage = $request->tax_edit_percentage;
            $tax->description = $request->tax_edit_description;
            $tax->save();
            return response()->json("success");
        }
    }
    /* payment_mode creation */
    public function paymentModeIndex(Request $request)
    {
        $payment_modes = PaymentMode::latest()->paginate(15);
        if ($request->isMethod('get')) {
            /* url has get method */
            return view('admin.master.index-payment-mode', compact('payment_modes'));
        } else {
            /* url has post method */
            $rules = [
                'payment_mode_name' => Rule::unique('payment_modes', 'name')
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }
            $payment_mode = new PaymentMode();
            $payment_mode->name = $request->payment_mode_name;
            $payment_mode->description = $request->payment_mode_description;
            $payment_mode->save();
            return response()->json("success");
        }
    }
    /* destroy Payment Mode information*/
    public function destroyPaymentMode($id)
    {
        $payment_mode = PaymentMode::find($id);
        $payment_mode->delete();
        return redirect()->back()->with('message', 'Payment Mode Destroyed Successfully');
    }
    /* update Tax details */
    public function updatePaymentMode(Request $request, $id)
    {
        $payment_mode = PaymentMode::find($id);
        if ($request->isMethod('get')) {
            /* url has get method */
            return response()->json([
                'data' => $payment_mode
            ]);
        } else {
            /* url has post method */
            $rules = [
                'edit_payment_mode_name' => Rule::unique('payment_modes', 'name')->ignore($id)
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }
            $payment_mode->name = $request->payment_mode_edit_name;
            $payment_mode->description = $request->payment_mode_edit_description;
            $payment_mode->save();
            return response()->json("success");
        }
    }

    /* Email Master */
    public function mastersEmailIndex(Request $request)
    {
        $settings = new MasterSetting();
        $site = $settings->siteData();
        if ($request->isMethod('get')) {
            /* url has get method */
            return view('admin.master.index-email', compact('site'));
        } else {
            /* url has post method */
            $site['mail_port'] = $request->mail_port;
            $site['mail_driver'] = $request->mail_driver;
            $site['mail_host'] = $request->mail_host;
            $site['mail_user_name'] = $request->mail_user_name;
            $site['mail_user_password'] = $request->mail_user_password;
            $site['mail_from_name'] = $request->mail_from_name;
            $site['mail_from_address'] = $request->mail_from_address;
            $site['mail_encryption'] = $request->mail_encryption;
              /* if the request has password */
              if($request->password!=""){
                $site['mail_user_password'] = Hash::make($request->mail_user_password);
            }
            /* create or if exists update the details */
            foreach ($site as $key => $value) {
                MasterSetting::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
            }
            $env_update = $this->changeEnv([
                'MAIL_MAILER'=>$site['mail_driver'],
                'MAIL_HOST'=>$site['mail_host'],
                'MAIL_PORT'=> $site['mail_port'],
                'MAIL_USERNAME'=> $site['mail_user_name'],
                'MAIL_PASSWORD'=> $site['mail_user_password'],
                'MAIL_ENCRYPTION'=> $site['mail_encryption'],
                'MAIL_FROM_ADDRESS'=> $site['mail_from_address'],
                'MAIL_FROM_NAME'=> $site['mail_from_name']
            ]);

            return redirect()->back()->with('message','Information updated successfully.');
        }
    }

    /* payment master */
    public function mastersPaymentIndex(Request $request){
            $settings = new MasterSetting();
            $site = $settings->siteData();
            if ($request->isMethod('get')) {
            /* url has get method */
                return view('admin.master.index-payment',compact('site'));
            } else {
                /* url has post method */
                /* stripe section */
                $site['stripe_key']  = $request->stripe_key;
                $site['stripe_secret']  = $request->stripe_secret;
                $site['stripe_status']  = ($request->stripe_status) ? '1' : '0';
                /*paypal section */
                $site['paypal_client_id']  = $request->paypal_client_id;
                $site['paypal_secret']  = $request->paypal_secret;
                $site['paypal_status']  = ($request->paypal_status) ? '1' : '0';
                $site['paypal_mode']  = $request->paypal_mode;
                /* razorpay section */
                $site['razorpay_key']  = $request->razorpay_key;
                $site['razorpay_secret']  = $request->razorpay_secret;
                $site['razorpay_status']  = ($request->razorpay_status) ? '1' : '0';
                /* create or if exists update the details */
                foreach ($site as $key => $value) {
                    MasterSetting::updateOrCreate(['master_title' => $key],['master_value' => $value]);
                }
                return redirect()->back()->with('message','Information updated successfully.');
            }
    }
    /* change env file details */
    protected function changeEnv($data = array()){
        if(count($data) > 0){

            $env = file_get_contents(base_path() . '/.env');
            $env = preg_split('/\s+/', $env);;
            foreach((array)$data as $key => $value){
                foreach($env as $env_key => $env_value){
                    $entry = explode("=", $env_value, 2);
                    if($entry[0] == $key){
                        $env[$env_key] = $key . "=" . $value;
                    }
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);
            return true;
        } else {
            return false;
        }
    }

}
