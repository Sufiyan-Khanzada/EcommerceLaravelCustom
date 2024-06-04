<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    // Handle user registration
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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

        // Merge first name and last name into a single name
        $name = $validatedData['fname'] . ' ' . $validatedData['lname'];
        $address = $validatedData['address1'] . ',\n' . 
            $validatedData['address2'] . ',\n' .
            $validatedData['postcode'] . ',\n' .
            $validatedData['city'] . ',\n' .
            $validatedData['state'] . ',\n' .
            $validatedData['country'] . ',\n';

        // Create a new user
        $user = User::create([
            'username' => $name,
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'company' => $validatedData['company'],
            'address' => $address,
            'phone' => $validatedData['phone'],
            'status' => 2
        ]);

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

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            dd(session()->all()); // Check session data
            
            echo(Auth::check());
            echo(Auth::user());
            dd();
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
