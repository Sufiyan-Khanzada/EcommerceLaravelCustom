<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMail;
use App\Mail\ResetPasswordMail;
use App\Mail\ProfileUpdateMail;
use Illuminate\Support\Str;
use App\Mail\NewCustomerNotificationAdmin;




use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    // Handle user registration
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string',
            'company' => 'nullable|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postcode' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);
    
        // Create a new user
        $customer = Customer::create([
            'fname' => $validatedData['fname'],
            'lname' => $validatedData['lname'],
            'company' => $validatedData['company'] ?? null,
            'email' => $validatedData['email'],
            'password' =>  md5($validatedData['password']),
            'phone' => $validatedData['phone'],
            'address1' => $validatedData['address1'],
            'address2' => $validatedData['address2'] ?? null,
            'country_id' => $validatedData['country'],
            'state_id' => $validatedData['state'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'postalcode' => $validatedData['postcode'],
            'status' => 3
        ]);
    
        // Send email
        $email = $validatedData['email'];
        $fname = $validatedData['fname'];
        $lname = $validatedData['lname'];
    
        // Sending email to the specified email
        Mail::to($email)->send(new SendMail($email, $fname, $lname));
    
        // Sending notification to the admin
        $adminEmail = User::first()->email;
        Mail::to($adminEmail)->send(new NewCustomerNotificationAdmin($email, $fname, $lname));
    
        // Return a response or redirect to a specific page
        return redirect()->route('login')->with('message', 'Well done! Thank you for registration. Your account is not approved yet but you can place orders.');
    }

    // Handle user login
    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Get the customer record by email
        $customer = Customer::where('email', $credentials['email'])->first();

        if($customer->status == 2)
        {
            $notification = array(
                'message' => 'Your Account is Suspended',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }

        // Verify MD5 password
        if ($customer && $customer->password === md5($credentials['password'])) {
            // Log the user in manually
            Auth::guard('customer')->login($customer);
            $request->session()->regenerate();

            // Return a response or redirect to a specific page
            $notification = array(
                'message' => 'Login Successful',
                'alert-type' => 'success'
            );
            return redirect()->route('home')->with($notification);
        }

        // If login fails, return an error response
        $notification = array(
            'message' => 'Incorrect Email or Password',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return a response or redirect to a specific page
        $notification = array(
            'message' => 'Logged Out',
            'alert-type' => 'info'
        );
        Session::forget('cart_contents');
        Session::forget('cart_needToUpdate');
        Session::forget('Shipping_rate');
        Session::forget('california_tax');
        Session::forget('restricted_place');
        Session::forget('token');
        return redirect()->route('home')->with($notification);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
            'company' => 'nullable|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'string|max:255',
            'city' => 'string|max:255',
            'postcode' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        $customer = Customer::find($id);

        $customer->fname = $validatedData['fname'];
        $customer->lname = $validatedData['lname'];
        $customer->company = $validatedData['company'];
        $customer->email = $validatedData['email'];
        $customer->password = md5($validatedData['password']);
        $customer->phone = $validatedData['phone'];
        $customer->address1 = $validatedData['address1'];
        $customer->address2 = $validatedData['address2'];
        $customer->country_id = $validatedData['country'];
        $customer->state_id = $validatedData['state'];
        $customer->city = $validatedData['city'];
        $customer->postalcode = $validatedData['postcode'];
        $customer->status = 3;

        $customer->save();

         // Send email
        $customerName = $customer->fname . ' ' . $customer->lname;
        $customerEmail = $customer->email;
        $email = User::first()->email;

        $mailTemplate = new ProfileUpdateMail($customerName,$customerEmail);
        Mail::to($email)->send($mailTemplate);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Return a response or redirect to a specific page
        
        return redirect()->route('login')->with('message', 'You have made changes to your account information, our office will need to revalidate your account. This may take up to 2 business days. You will receive an email once you have been revalidated.');
    }

    public function recoverPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
              
            $customer = Customer::where('email', $request->input('email'))->first();
            if (!$customer) {
                return view('reset-password')->with('error','Invalid Email Address.');
            } else {
                $name = $customer->fname . ' ' . $customer->lname;
                $email = trim($request->input('email'));

                $result = $this->sendResetPasswordEmail($email, $name);
                if ($result) {
                    return view('reset-password')->with('success','Reset password link has been sent to your Email.');
                } else {
                    return view('reset-password')->with('error','Error, unable to send Email');
                }
            }
        

        return view('reset-password', ['data' => $data, 'data2' => $user]);
    }

    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    private function sendResetPasswordEmail($email, $username)
    {
        $pp = $this->randomPassword();
        $token = md5($pp);

        try {

        DB::table('reset_users')->insert([
                'email' => $email,
                'hash' => $token,
                'time' => now(),
        ]);    
            Mail::to($email)->send(new ResetPasswordMail($email, $token));

            return true;
        } catch (\Exception $e) {
        
            return false;
        }
    }
    

    public function resetPasswordForm($email, $hash)
    {
        $resetUser = DB::table('reset_users')
            ->select('*')
            ->where('email', $email)
            ->where('hash', $hash)
            ->first();
    
        if ($resetUser) {
            $currentTime = now();
    
            // Assuming $resetUser->time is a datetime field from your database
            $resetTime = Carbon::parse($resetUser->time);
    
            if ($resetTime <= $currentTime) { // Check if resetTime is equal to or greater than current time
                return view('reset-password-form')->with(compact('email','hash'));
            } else {
                $notification = [
                    'message' => 'URL has expired.',
                    'alert-type' => 'error'
                ];
                return redirect()->route('login')->with($notification);
            }
        } else {
            $notification = [
                'message' => 'Invalid URL.',
                'alert-type' => 'error'
            ];
            return redirect()->route('login')->with($notification);
        }
    }

    

    public function resetPasswordPost(Request $request)
    {
    
   
        $request->validate([
            'password' => 'required|min:8|max:20',
            'cpassword' => 'required|same:password', // Ensure cpassword matches password
        ], [
            'cpassword.same' => 'The password confirmation does not match.',
            'cpassword.required' => 'The confirm password field is required.',
        ]
    );

// Retrieve the customer by email
$customer = Customer::where('email', $request->input('email'))->first();


if ($customer) {
    // Update the password
    $customer->password =  md5($request->password);
    $customer->save();

    DB::table('reset_users')
    ->where('email', $request->input('email'))
    ->where('hash', $request->input('token'))
    ->delete();

    return redirect()->route('login')->with('success','Password updated successfully.');

} else {
    // Handle case where customer with the given email does not exist
    return view('reset-password-form')->with('error','something went wrong.');
}

    
    }


}
