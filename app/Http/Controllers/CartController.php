<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use App\Services\Cart;
class CartController extends Controller
{

    public $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    
    }


    public function cart()
    {
        $cart = new Cart();
        // dd($cart);
        $cartContents = $cart->cart_contents;
        dd($cartContents);
        if($cartContents)
        {
        $cartItems = array_filter($cartContents, function($key) {
            return !in_array($key, ['total_items', 'cart_total']);
        }, ARRAY_FILTER_USE_KEY);
        }
        $total_items = $cartContents['total_items'] ?? 0;
        $cart_total = $cartContents['cart_total'] ?? 0;
        // dd(Session::get('cart_contents'));
        // dd($cartContents);
        return view('cart')->with(compact('total_items','cart_total','cartContents'));
    }

        public function addToCart(Request $request)
        {
            // dd(count(session()->get('cart')));
            // session()->flush();
            // return response()->json([
            // ]);
            // dd($request->session());
            // Validate the request
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

            $price = $product->sale_price < 1 ? $product->regular_price : $product->sale_price;

            $data = [
                'id' => $product_id,
                'qty' => $quantity,
                'price' => $price,
                'name' => $product->sku . "-",
                'title' => $product->title,
                'restricted_status' => $product->restricted_status,
                'handling_fee' => $product->handling_fee,
                'options' => ['optional_info' => $optional_info]
            ];

            if (!empty($size)) {
                $data['size'] = $size;
            }

            if (!empty($color)) {
                $data['color'] = $color;
            }

            $this->cart->insert($data);
            Session::put('cart_contents',$data);
            // session()->put('cart',$data);
            $request->session()->put('cart_needToUpdate', true);
            $user_status = $request->session()->get('firequick.status', 3);
            // dd($product);
            // dd($user_status);
        
            if ($product->restricted_status === "yes" && $user_status == 3) {
                $res = [
                    'alert' => true,
                    'cart_total_item' => $this->cart->total()
                ];
            } else {
                $res = [
                    'alert' => false,
                    'cart_total_item' => $this->cart->total(),
                    'cart_data' => $this->cart->contents()
                ];
            }

            return response()->json($res);
        }

    public function removeFromCart(Request $request)
    {
        
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

