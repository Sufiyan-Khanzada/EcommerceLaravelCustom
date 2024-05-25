<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;
use App\Models\Testimonials;
use App\Models\Category;

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
        // dd($data);
        return view('customer-service')->with(compact('data'));
    }

    public function privacyPolicy(){
        $data = Post::where([
            ['post_id', 28],
            ['type',1]
        ])->first();
        // dd($data);
        return view('privacy-policy')->with(compact('data'));
    }


    public function orderReturn(){
        $data = Post::where([
            ['post_id', 32],
            ['type',1]
        ])->first();
        // dd($data);
        return view('order-return')->with(compact('data'));
    }
    
    public function shippingInformation(){
        $data = Post::where([
            ['post_id', 33],
            ['type',1]
        ])->first();
        // dd($data);
        return view('shipping-information')->with(compact('data'));
    }

    public function termAndUse(){
        $data = Post::where([
            ['post_id', 34],
            ['type',1]
        ])->first();
        // dd($data);
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
            
        return view('products')->with(compact(['products', 'categories', 'currentCategory']));
    }
    
    public function singleProduct($productId) {

        $product = Product::where('product_id', $productId)->first();
        $categories = Category::all();

        if(!$product)
        {
            return redirect('products');
        }

        return view('product-detail')->with(compact(['product', 'categories']));
    }
}