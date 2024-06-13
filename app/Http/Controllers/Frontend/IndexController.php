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

class IndexController extends Controller
{
    public function index(){

        $data = [ 
            "frontProducts" =>  Product::select('products.image_id', 'products.discripition', 'categories.title')
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->where('products.status', 1)
            ->limit(4)
            ->get(),
            "testimonials" => Testimonials::get(),
        ];

        return view('welcome')->with(compact('data'));
    }

    public function contentPage($pageId, $pageTitle) {
        // Your controller logic here
        $data = Post::where([
            ['post_id', $pageId],
            ['type',1]
        ])->first();
        
        return view('content-page')->with(compact('data'));

    }

    public function gallery(){
        
        $data = Image::where('status',1)->get();
        return view('gallery')->with(compact('data'));
    }

    public function documents(){
        
        return view('documents');
    }

    public function news(){
        
        $data = Post::where([
            ['post_id', 36],
            ['type',1]
        ])->first();

        return view('news')->with(compact('data'));
    }
        
    public function safetyTrainingVideos(){
    

        $stv_result=SafetyTrainingVideo::get();

        $stv_result = $stv_result[0];
        if (isset($stv_result['description']) && $stv_result['description'] != '')
            $description = $stv_result['description'];
        else
            $description = '';
        
        if (isset($stv_result['youtube_title']) && $stv_result['youtube_title'] != '')
            $youtube_title = unserialize($stv_result['youtube_title']);
        else
            $youtube_title = '';
        
        if (isset($stv_result['youtube_url']) && $stv_result['youtube_url'] != '')
            $youtube_url = unserialize($stv_result['youtube_url']);
        else
            $youtube_url = '';

            $data =[
                "description" => $description,
                "youtube_title" => $youtube_title,
                "youtube_url" => $youtube_url

            ];

        return view('safety-training-videos')->with(compact('data'));
    }

    public function firequickconductsfieldtestingofnews(){
       

        return view('firequick-conducts-field-testing-of-new-large-format-launcher');
    }

    public function firequickproductsIncapprovesnews(){
       

        return view('firequick-products-Inc-approves-new-large-format-flare-for-production');
    }

    public function wileyxavailableatfirequickproducts(){
       

        return view('wiley-x-available-at-firequick-products');
    }
 
    public function customerService(){
        $data = Post::where([
            ['post_id', 26],
            ['type',1]
        ])->first();

        return view('customer-service')->with(compact('data'));
    }

    public function privacyPolicy(){
        $data = Post::where([
            ['post_id', 28],
            ['type',1]
        ])->first();
        
        return view('privacy-policy')->with(compact('data'));
    }


    public function orderReturn(){
        $data = Post::where([
            ['post_id', 32],
            ['type',1]
        ])->first();

        return view('order-return')->with(compact('data'));
    }
    
    public function shippingInformation(){
        $data = Post::where([
            ['post_id', 33],
            ['type',1]
        ])->first();
        
        return view('shipping-information')->with(compact('data'));
    }

    public function termAndUse(){
        $data = Post::where([
            ['post_id', 34],
            ['type',1]
        ])->first();
        
        return view('term-use')->with(compact('data'));
    }

    public function productsList($categoryId = null) {

        $categories = Category::all();
        $currentCategory = null;
        if($categoryId)
        {
            $products = Product::where('category_id', 'LIKE', $categoryId)
                ->orWhere('category_id', 'LIKE', $categoryId . ',%')
                ->orWhere('category_id', 'LIKE', '%,' . $categoryId)
                ->orWhere('category_id', 'LIKE', '%,' . $categoryId . ',%')
                ->get();
            $currentCategory = Category::where('category_id', $categoryId)->first();
        }
        else {
            $products = Product::all();
        }
        
            
        return view('products')->with(compact(['products', 'categories', 'currentCategory', 'user']));
    }
    
    public function singleProduct($productId) {

        $product = Product::where('product_id', $productId)->first();
        $categories = Category::all();

        if(!$product)
        {
            return redirect('products');
        }

        return view('product-detail')->with(compact(['product', 'categories', 'user']));
    }
    public function getCountries()
    {
        $countries = Country::all();

        return response()->json($countries);
    }
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();

        if(count($states) <= 0)
        {
            return 'false';
        }
        else {
            return response()->json($states);
        }
    }
    public function myDetails()
    {
        $customer = Auth::guard('customer')->user();
        
        return view('myaccount.details')->with('customer');
    }


    


    public function sendToFriend(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'url' => 'required|url'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }

            $email = $request->input('email');
            $url = $request->input('url');

            $message = '<!DOCTYPE html><html><body>';
            $message .= '<p>Product Url: <a href="'. $url .'">'. $url .'</a></p>';
            $message .= '</body></html>';

            Mail::raw([], function ($msg) use ($email, $message) {
                $msg->to($email)
                    ->subject('Firequick product referral')
                    ->setBody($message, 'text/html');
            });

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }
    

}