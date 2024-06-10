<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;
use App\Mail\SendMail;

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
            'state' => 'string|max:255',
            'city' => 'string|max:255',
            'postcode' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        // Create a new user
        $customer = Customer::create([
            'fname' => $validatedData['fname'],
            'lname' => $validatedData['lname'],
            'company' => $validatedData['company'],
            'email' => $validatedData['email'],
            'password' => md5($validatedData['password']),
            'phone' => $validatedData['phone'],
            'address1' => $validatedData['address1'],
            'address2' => $validatedData['address2'],
            'country_id' => $validatedData['country'],
            'state_id' => $validatedData['state'],
            'city' => $validatedData['city'],
            'postalcode' => $validatedData['postcode'],
            'status' => 3
        ]);

        
         // Send email

    $email = $validatedData['email'];

    Mail::to($email)->send(new SendMail($email));

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

        // Verify MD5 password
        if ($customer && $customer->password === md5($credentials['password'])) {
            // Log the user in manually
            Auth::guard('customer')->login($customer);
            $request->session()->regenerate();

            // Return a response or redirect to a specific page
            return redirect()->route('home');
        }

        // If login fails, return an error response
        return redirect()->route('login')->with('error', 'Incorrect Email or Password');
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return a response or redirect to a specific page
        return redirect()->route('home');
    }
}
