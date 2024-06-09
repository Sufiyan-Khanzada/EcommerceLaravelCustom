<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Mail;
class ContactUsController extends Controller
{
    public function contactForm(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            "email" => $request->input('email'),
            "name" => $request->input('name'),
            "comment" => $request->input('comment'),
            "captcha" => $request->input('g-recaptcha-response'),
            "subject" => isset($subject) ? $subject : "",
        ];
        

        Mail::to("admin@admin.com")->send(new ContactMail($data));


        return redirect()->back()->with('success', 'Thanks for Contacting Us.');
        // $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=YOUR_SECRET_KEY&response=".$request->input('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
// dd($response);    
        // Handle the valid data (e.g., send an email, save to the database, etc.)
    
        // dd($request->all());
    }
}
