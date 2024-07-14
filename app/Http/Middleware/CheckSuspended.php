<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Customer;
use Auth;

class CheckSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer && $customer->status == 2) {
            Auth::guard('customer')->logout();
            $notification = array(
                'message' => 'Your Account is Suspended',
                'alert-type' => 'warning'
            );
            return redirect('/login')->with($notification);
        }

        return $next($request);
    }
}
