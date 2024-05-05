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

Route::get('/flares', function () {
    return view('flares');
})->name('flares');

Route::get('/flares-overview', function () {
    return view('flares-overview');
})->name('flares-overview');

Route::get('/flares-news', function () {
    return view('flares-news');
})->name('flares-news');

Route::get('/launchers', function () {
    return view('launchers');
})->name('launchers');

Route::get('/launchers-overview', function () {
    return view('launchers-overview');
})->name('launchers-overview');

Route::get('/launchers-news', function () {
    return view('launchers-news');
})->name('launchers-news');

Route::get('/firequick-accessories', function () {
    return view('firequick-accessories');
})->name('firequick-accessories');

Route::get('/fire-accessories-overview', function () {
    return view('fire-accessories-overview');
})->name('fire-accessories-overview');

Route::get('/fire-news', function () {
    return view('fire-news');
})->name('fire-news');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/launcher-repair-services', function () {
    return view('launcher-repair-services');
})->name('launcher-repair-services');

Route::get('/fire-training-services', function () {
    return view('fire-training-services');
})->name('fire-training-services');

Route::get('/safety-training-videos', function () {
    return view('safety-training-videos');
})->name('safety-training-videos');
