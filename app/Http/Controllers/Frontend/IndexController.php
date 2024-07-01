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
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendProductReferral;


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
        
            
        return view('products')->with(compact(['products', 'categories', 'currentCategory']));
    }
    
    public function singleProduct($productId,$productTitle) {

        $product = Product::where('product_id', $productId)->first();
        $categories = Category::all();

        if(!$product)
        {
            return redirect('products');
        }

        return view('product-detail')->with(compact(['product', 'categories']));
    }
    public function getCountries()
    {
        $countries = Country::get()->toArray();
        // dd($countries);
        return response()->json($countries);
    }
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get()->toArray();

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
        return view('myaccount.details');
    }



    public function downloadWorkbook()
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->workbook_status == '1') {
            $filePath = public_path('Workbook.pdf');
            $fileName = 'workbook.pdf';

            return response()->download($filePath, $fileName);
        } else {
            return redirect()->route('myaccount');
        }
    }

    public function orderInfo()
    {
        // dd('s');
        $customer = Auth::guard('customer')->user();
        // dd($customer->email);
        if (!$customer) {
            return redirect()->route('home');
        }
    
        
        $order = Order::where('customer_email', $customer->email)->get();
        // dd($order);
     
    
        $validStatuses = ['1', '2', '3', '4', '5'];
    
        $orderItems = OrderItem::select('orderitems.*', 'products.title', 'orders.customer_email', 'orders.shipping_cost', 'orders.sub_total as order_subtotal', 'orders.handling_fee as total_handling_fee', 'orders.tax as total_tax')
            ->join('products', 'orderitems.product_id', '=', 'products.product_id')
            ->join('orders', 'orderitems.order_id', '=', 'orders.order_id')
            // ->where('orderitems.order_id', $orderId)
            ->where('orders.customer_email','=', $customer->email)
            ->whereIn('orders.order_status', $validStatuses)
            ->get();
    
     
        // dd($orderItems);
        $user = User::select('facebook', 'instagram', 'linkedin', 'address', 'phone', 'tollfree', 'fax')->first();
    
        $data = [
            'title' => 'Order Info',
            'user' => $user,
            'orderItems' => $orderItems,
        ];

        // dd($data);
        // dd($data);
        return view('myaccount.orders')->with(compact('data'));
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

            Mail::to($email)->send(new SendProductReferral($url));

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }
    
    


    public function addImage()
    {
    
        return view('add-image');
    }

    public function addImagePost(Request $request)
    {
        dd("S");
        
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:55',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Get authenticated user
        $email = Auth::user()->email;
        $customer = Customer::where('email', $email)->first();
        $customer_id = $customer->id;

        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/gallery', $filename);

            // Save image data to the database
            $data = [
                'title' => $request->title,
                'location' => $filename,
                'type' => $image->getClientMimeType(),
                'uploadedby' => 'user',
                'user_id' => $customer_id,
                'status' => 2,
            ];

            Image::create($data);

            // Get admin email
            $admin_email = User::where('role', 'admin')->pluck('email');

            // Send email to admin
            $message = '<p>Firequick customer email ' . $email . ' has submitted an image. The image will need to be approved before posting.</p>';
            $message .= '<img src="' . asset('storage/gallery/' . $filename) . '" alt="User submitted image" />';

            Mail::raw($message, function ($mail) use ($admin_email) {
                $mail->from(env('MAIL_FROM_ADDRESS'),env('APP_NAME'));
                $mail->to($admin_email)->subject('Customer Submitted an Image');
            });

            return redirect()->back()->with('success', 'Image uploaded successfully.');
        } else {
            return redirect()->back()->withErrors(['image' => 'Image upload failed.']);
        }
    }

    
    

    
    
}


