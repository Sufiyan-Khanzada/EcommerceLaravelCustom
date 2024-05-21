<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'password' => 'required|string|min:8',
            'company' => 'nullable|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
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

        // Automatically log the user in
        Auth::login($user);

        // Return a response or redirect to a specific page
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
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

            // Return a response or redirect to a specific page
            return response()->json(['message' => 'User logged in successfully'], 200);
        }

        // If login fails, return an error response
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return a response or redirect to a specific page
        return response()->json(['message' => 'User logged out successfully'], 200);
    }
}
