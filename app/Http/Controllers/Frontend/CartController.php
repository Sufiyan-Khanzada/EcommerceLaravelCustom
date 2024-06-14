<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;
use App\Models\Testimonials;
use App\Models\Category;
use App\Models\Country;
use App\Models\Image;
use App\Models\State;
use App\Models\SafetyTrainingVideo;
use App\Models\User;
use App\Models\Customer;
use DB;
class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        dd('abx');
        if (!$request->session()->has('firequick')) {
            $add = route('login'); // or url('page/login');
            
            $request->session()->put('currentURL', $request->input('currentURL'));
    
            $res = [
                'alert' => "login",
                'cart_total_item' => "0",
                'address' => $add
            ];
    
            return response()->json($res);
        } else {
            if ($request->isMethod('post')) {
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
    
                Cart::add($data);
    
                $request->session()->put('cart_needToUpdate', true);
    
                $user_status = $request->session()->get('firequick.status', 3);
    
                if ($product->restricted_status === "yes" && $user_status == 3) {
                    $res = [
                        'alert' => true,
                        'cart_total_item' => Cart::count()
                    ];
                } else {
                    $res = [
                        'alert' => false,
                        'cart_total_item' => Cart::count(),
                        'cart_data' => Cart::content()
                    ];
                }
    
                return response()->json($res);
            }
        }
    }
    

}