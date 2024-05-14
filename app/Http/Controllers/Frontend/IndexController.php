<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        
        return view('welcome');
    }

    public function about(){
        
        return view('about');
    }

    public function companyHistory(){
        
        return view('company-history');
    }

    public function careers(){
        
        return view('careers');
    }

    public function faq(){
        
        return view('faq');
    }

    public function documents(){
        
        return view('documents');
    }

    public function news(){
        
        return view('news');
    }
    public function cart(){
        
        return view('cart');
    }
    

    

    
    
}
