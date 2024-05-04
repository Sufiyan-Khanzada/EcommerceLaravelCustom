<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/company-history', function () {
    return view('company-history');
})->name('company.history');


Route::get('/testimonials', function () {
    return view('testimonials');
})->name('testimonials');


Route::get('/careers', function () {
    return view('careers');
})->name('careers');


Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/documents', function () {
    return view('documents');
})->name('documents');

Route::get('/news', function () {
    return view('news');
})->name('news');




Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/my-account', function () {
    return view('my-account');
})->name('my-account');

Route::get('/shop-detail', function () {
    return view('shop-detail');
})->name('shop-detail');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');


Route::get('/login', function () {
    return view('login');
})->name('login');


Route::get('/registration', function () {
    return view('register');
})->name('registration');


