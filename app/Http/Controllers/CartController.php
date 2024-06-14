<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function addToCart(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $validatedData = $request->validate([
            'myDataid' => 'required|integer',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'required|integer',
            'optional_info' => 'nullable|string',
            'currentURL' => 'required|url',
        ]);

        // Example response data
        $response = [
            'cart_total_item' => 5, // Example data
            'alert' => false,
        ];

        // Add your logic here
        // e.g., add the product to the cart, check for alerts, etc.

        return response()->json($response);
    }

}
