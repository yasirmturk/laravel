<?php

use App\Models\Booking;
use App\Models\Business;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// auth routes
Route::name('login.')->middleware('api.user')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('login/social', 'AuthController@loginSocial')->name('social');
    Route::post('login/{provider}', 'AuthController@loginProvider')->name('provider');
    Route::post('register', 'AuthController@register')->name('register');
});

// Guest routes
Route::name('meta.')->prefix('meta')->middleware('client')->group(function () {
    Route::get('', 'MetaController@default');
    Route::get('all', 'MetaController@all')->name('all');
});
Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail')->name('forgot');

// Protected routes
Route::middleware('auth:api')->group(function () {
    // User
    Route::name('user.')->prefix('user')->group(function () {
        Route::get('', 'UserController@current');
        Route::post('', 'UserController@update')->name('update');
        Route::get('provider', 'UserController@provider')->name('provider');
        Route::name('stripe.')->prefix('stripe')->group(function () {
            Route::get('', 'StripeController@index');
            Route::post('', 'StripeController@addMethod')->name('addMethod');
            Route::post('payment', 'StripeController@payment')->name('payment');
        });
        Route::name('settings.')->prefix('settings')->group(function () {
            Route::get('bank-accounts', 'SettingsController@index');
            Route::post('bank-accounts', 'SettingsController@update')->name('update');
        });
    });
    // Logout
    Route::post('logout', 'AuthController@logout')->name('logout');
    // Management
    Route::apiResource('users', 'UserController')->middleware('can:admin');
    // Subscription
    Route::post('subscribe/provider', 'SubscriptionController@provider');
    // Business
    Route::model('business', Business::class);
    Route::name('business.')->prefix('businesses')->group(function () {
        Route::get('', 'BusinessController@mine')->name('mine');
        Route::get('{business}', 'BusinessController@find')->name('find');
        Route::post('', 'BusinessController@register')->name('register');
        Route::put('{business}', 'BusinessController@update')->name('update');
        Route::post('{business}/addresses', 'BusinessController@addAddress')->name('addAddress');
        Route::post('{business}/images', 'BusinessController@addImage')->name('addImage');
        Route::delete('{business}/images', 'BusinessController@removeImage')->name('removeImage');
        Route::post('{business}/services', 'BusinessController@addService')->name('addService');
        Route::post('{business}/products', 'BusinessController@addProduct')->name('addProduct');
        Route::delete('services/{id}', 'BusinessController@removeService')->name('removeService');
        Route::delete('products/{id}', 'BusinessController@removeProduct')->name('removeProduct');
        Route::get('{business}/schedules', 'BusinessController@getSchedule')->name('getSchedule');
        Route::post('{business}/schedules', 'BusinessController@addSchedule')->name('addSchedule');
        Route::delete('{business}/schedules', 'BusinessController@removeSchedule')->name('removeSchedule');
    });
    // Service
    Route::model('service', Service::class);
    Route::name('service.')->prefix('services')->group(function () {
        Route::post('{service}/images', 'ServiceController@addImage')->name('addImage');
        Route::get('{service}/schedules', 'ServiceController@getSchedule')->name('getSchedule');
        Route::get('{service}/bookings/{date?}', 'ServiceController@getBookings')->name('getBookings');
        Route::get('{service}/slots/{date?}', 'ServiceController@getSlots')->name('getSlots');
    });
    // Product
    Route::model('product', Product::class);
    Route::name('product.')->group(function () {
        Route::post('products/{product}/images', 'ProductController@addImage')->name('addImage');
        Route::delete('products/{product}/images', 'ProductController@removeImage')->name('removeImage');
    });
    // Image
    Route::name('images.')->group(function () {
        Route::post('images', 'ImageController@store')->name('store');
        Route::post('images/update/{filename}', 'ImageController@update')->name('update');
        Route::get('images/f/{filename}', 'ImageController@showByFileName')->name('show');
    });
    // Search
    Route::name('search.')->prefix('search')->group(function () {
        Route::get('categories', 'SearchController@listCategories')->name('listCategories');
        Route::get('businesses/{category}', 'SearchController@listBusinessesInCategory')->name('listBusinessesCategories');
        Route::get('{productOrService}', 'SearchController@searchBusiness')->name('searchBusiness');
    });
    // Wish list
    Route::name('wishlist.')->prefix('wishlist')->group(function () {
        Route::get('', 'WishController@index')->name('index');
        Route::post('{productOrService}', 'WishController@addToWish')->name('addToWish');
        Route::delete('{productOrService}', 'WishController@removeFromWish')->name('removeFromWish');
    });
    // Booking
    Route::model('booking', Booking::class);
    Route::name('booking.')->prefix('bookings')->group(function () {
        Route::get('', 'BookingController@index')->name('index');
        Route::post('book', 'BookingController@book')->name('book');
        Route::delete('{booking}', 'BookingController@cancel')->name('cancel');
    });
    // Order
    Route::model('order', Order::class);
    Route::name('order.')->prefix('orders')->group(function () {
        Route::get('', 'OrderController@index')->name('index');
        Route::post('{order}/paid', 'OrderController@paid')->name('paid');
    });
});
