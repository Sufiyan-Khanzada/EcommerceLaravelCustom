<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;
use App\Models\Testimonials;

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
    

    
    
    

    
    
}
