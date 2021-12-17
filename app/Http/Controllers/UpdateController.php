<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Install\UpdateRequirement;
use App\Http\Middleware\RedirectIfNoUpdateAvailable;
use Auth;

class UpdateController extends Controller
{
    public function __construct()
    {
//        Debugbar::disable();
        $this->middleware(RedirectIfNoUpdateAvailable::class);
    }

    public function start(UpdateRequirement $requirement){
        $updateFile = File::get(storage_path('update'));
        if ($updateFile) {
            $updateVersion = 'v' . $updateFile;
        } else {
            $updateVersion = null;
        }

        $extensionSatisfied = true;
        foreach ($requirement->extensions() as $label => $satisfied) {
            if (!$satisfied) {
                $extensionSatisfied = false;
                break;
            }
        }

        $permissionSatisfied = true;
        foreach ($requirement->directories() as $label => $satisfied) {
            if (!$satisfied) {
                $permissionSatisfied = false;
                break;
            }
        }

        return view('install.update',[
            'updateVersion' => $updateVersion,
            'extensionSatisfied' => $extensionSatisfied,
            'permissionSatisfied' => $permissionSatisfied,
            'requirement' => $requirement,
        ]);
    }

    public function update(Request $request)
    {

        $admin = User::where('id', '1')->first();
        $hashedPassword = $admin->password;

       if (!Hash::check($request->password, $hashedPassword)) {
           return redirect()->back()->with(['message' => 'Please Chek your Admin Password...']);
       } else {

        Artisan::call('db:seed --class=MailControlSeeder');
        Artisan::call('db:seed --class=StripeControlSeeder');

           // process update here...
           $start_time = microtime(true);
           $start_time2 = microtime(true);
           sleep(5); //manual delay


               Artisan::call('migrate', [
                   '--force' => true,
               ]);

               /** CLEAR LARAVEL CACHES **/
               Artisan::call('cache:clear');
               Artisan::call('view:clear');
               /** END CLEAR LARAVEL CACHES **/

               $end_time = microtime(true);
               $execution_time = ($end_time - $start_time);

               if ($execution_time < 12) {
                   sleep(12 - $execution_time);
               }
               $end_time2 = microtime(true);
               $execution_time2 = ($end_time2 - $start_time2);
               // dd($execution_time2);

               //delete update file
               unlink(storage_path('update'));

               //login admin user
               $user = User::where('id', 1)->first();
               if ($user) {
                   if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                       //redirect to admin dashboard
                       return Redirect::to('admin/dashboard')->with(['success' => 'Update Successful']);
                   } else {
                       //or redirect to login page
                       return redirect()->route('admin-login')->with(['success' => 'Update Successful']);
                   }
               } else {
                   //or redirect to login page
                   return redirect()->route('admin-login')->with(['success' => 'Update Successful']);
               }

           }


   }


}
