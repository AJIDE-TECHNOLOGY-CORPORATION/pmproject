<?php

namespace App\Http\Middleware;

use Closure;
use App\Customer;

class APIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('Token')) {
            $token = $request->header('Token');
            $customer = Customer::where('auth_token', $token)->first();
            if ($customer) {
                return $next($request);
            } else {
                return response()->json([
                    'success' => false,
                    'session_expired' => true,
                    'error' => array('Not a valid API request.'),
                ]);
            }

        }
        return response()->json([
            'success' => false,
            'error' => array('Not a valid API request.'),
        ]);
    }
}
