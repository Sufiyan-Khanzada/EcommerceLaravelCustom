<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\UserController;

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

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/company-history', [IndexController::class, 'companyHistory'])->name('company.history');
Route::get('/testimonials', [IndexController::class, 'testimonials'])->name('testimonials');
Route::get('/careers', [IndexController::class, 'careers'])->name('careers');
Route::get('/faq', [IndexController::class, 'faq'])->name('faq');
Route::get('/documents', [IndexController::class, 'documents'])->name('documents');
Route::get('/news', [IndexController::class, 'news'])->name('news');
Route::get('/customer-service', [IndexController::class, 'customerService'])->name('customer.service');
Route::get('/privacy-policy', [IndexController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/order-and-return', [IndexController::class, 'orderReturn'])->name('order.return');
Route::get('/shipping-information', [IndexController::class, 'shippingInformation'])->name('shipping.information');
Route::get('/term-and-use', [IndexController::class, 'termAndUse'])->name('term.use');
Route::get('/page/{pageId}/{pageTitle}', [IndexController::class, 'contentPage'])->name('page');

Route::get('/firequick-conducts-field-testing-of-new-large-format-launcher', [IndexController::class, 'firequickconductsfieldtestingofnews'])->name('firequick-conducts-field-testing-of-new-large-format-launcher');
Route::get('/firequick-products-Inc-approves-new-large-format-flare-for-production', [IndexController::class, 'firequickproductsIncapprovesnews'])->name('firequick-products-Inc-approves-new-large-format-flare-for-production');
Route::get('/wiley-x-available-at-firequick-products', [IndexController::class, 'wileyxavailableatfirequickproducts'])->name('wiley-x-available-at-firequick-products');

Route::get('/products/{categoryId?}', 
    [IndexController::class, 'productsList'])
    ->name('products');

Route::get('/single-product/{productId}', 
    [IndexController::class, 'singleProduct'])
    ->name('single.product');

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

Route::get('/flares-overview', function () {
    return view('flares-overview');
})->name('flares-overview');

Route::get('/flares-news', function () {
    return view('flares-news');
})->name('flares-news');

Route::get('/launchers-overview', function () {
    return view('launchers-overview');
})->name('launchers-overview');

Route::get('/launchers-news', function () {
    return view('launchers-news');
})->name('launchers-news');

Route::get('/fire-accessories-overview', function () {
    return view('fire-accessories-overview');
})->name('fire-accessories-overview');

Route::get('/fire-news', function () {
    return view('fire-accessories-news');
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

// Route for user registration
Route::post('/register', [UserController::class, 'register'])->name('register-user');

// Route for user login
Route::post('/login', [UserController::class, 'login'])->name('authenticate');

// Route for user logout
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/countries', [IndexController::class, 'getCountries'])->name('getCountries');
Route::get('/states/{countryId?}', [IndexController::class, 'getStates'])->name('getStates');