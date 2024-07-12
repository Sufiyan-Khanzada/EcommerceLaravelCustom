<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use App\Services\Cart;
use Auth;
class CartController extends Controller
{

    public $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    
    }


    public function cart()
    {
        // dd(Auth::guard('customer')->user());
        $cartItems = null;
        // Session::forget('cart_contents');
        $cart = new Cart();
        // dd($cart);
        $cartContents = Session::get('cart_contents');
        // dd($cartContents);
        // Debugging cart retrieval
        // dd([
        //     'cart_contents_on_cart_retrieval' => $cartContents,
        //     'session_on_cart_retrieval' => Session::all()
        // ]);
    
        if($cartContents)
        {
            $cartItems = array_filter($cartContents, function($key) {
                return !in_array($key, ['total_items', 'cart_total','handling_fee']);
            }, ARRAY_FILTER_USE_KEY);
            // $other = array_filter($cartContents, function($key) {
            //     return in_array($key, ['total_items', 'cart_total']);
            // }, ARRAY_FILTER_USE_KEY);
        }
        // dd($cartContents);
        // $total_items = $cartContents['total_items'] ?? 0;
        // $cart_total = $cartContents['cart_total'] ?? 0;
    
        return view('cart')->with(compact('cartItems'));
    }
    

    public function addToCart(Request $request)
{
    // Validate the request
    // dd($request->all());
    $validatedData = $request->validate([
        'myDataid' => 'required|integer',
        'size' => 'nullable|string',
        'color' => 'nullable|string',
        'quantity' => 'required|integer',
        'optional_info' => 'nullable|string',
        'currentURL' => 'required|url',
    ]);

    $optional_info = $request->input('optional_info');
    $quantity = $request->input('quantity');
    $product_id = $request->input('myDataid');
    $size = $request->input('size');
    $color = $request->input('color');

    $product = DB::table('products')->where([
        ['product_id', '=', $product_id],
        ['status', '=', 1]
    ])->first();

    if (!$product) {
        return response()->json(false);
    }
    // dd(auth()->guard('customer')->user()->status);
    if($product->restricted_status === "yes" && auth()->guard('customer')->user()->status == 3)
    {
        return response()->json(['alert' => true]);
    }

    $price = $product->sale_price < 1 ? $product->regular_price : $product->sale_price;

    $data = [
        'id' => $product_id,
        'qty' => $quantity,
        'price' => $price,
        'tax' => $product->tax,
        'name' => $product->sku . "-",
        'title' => $product->title,
        'restricted_status' => $product->restricted_status,
        'handling_fee' => $product->handling_fee,
        'options' => ['optional_info' => $optional_info]
    ];
    // dd($data);

    if (!empty($size)) {
        $data['size'] = $size;
    }

    if (!empty($color)) {
        $data['color'] = $color;
    }

    $this->cart->insert($data);
    $request->session()->put('cart_needToUpdate', true);
    $user_status = auth()->guard('customer')->user()->status;

    if ($product->restricted_status === "yes" && $user_status == 3) {
        $res = [
            'alert' => true,
            // 'cart_total_item' => $this->cart->total()
        ];
       
    } else {
        $res = [
            'alert' => false,
            'cart_total_item' => $this->cart->total(),
            'cart_data' => $this->cart->contents()
        ];
        
    }

    // dd($res);
    // Session::put('cart_contents', $this->cart->cart_contents);
    
    // Debug session after saving
    // dd(Session::all());

    return response()->json($res);
}

    

    public function removeFromCart(Request $request)
    {
        // dd($request->all());
        $id = $request->input('myDataid');
        $data = [
            'rowid' => $id,
            'qty' => 0
        ];

        $this->cart->update($data);
        $result = [
            'total_item' => $this->cart->total_items(),
            'sub_total' => $this->cart->total()
        ];

        return response()->json($result);
    }


}

