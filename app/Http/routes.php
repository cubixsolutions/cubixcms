<?php

    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the controller to call when that URI is requested.
    |
    */

    use Illuminate\Support\Facades\Route;

    Route::bind('category', function($slug) {

       return App\ProductCategory::whereSlug($slug)->first();

    });

    Route::get('/', 'pageController@index');
    Route::get('/page/{page}', 'pageController@index');

    Route::get('blog', 'blogController@index');
    Route::get('store', 'storeController@index');
    Route::get('store/category/{category}','storeController@category');
    Route::get('store/refresh-cart','storeController@refreshCart');
    Route::get('store/view-cart','storeController@viewCart');
    Route::get('store/checkout', ['middleware' => 'nocart', 'only' => 'checkout', 'uses' => 'storeController@checkout']);
    Route::get('webpayment','webpaymentController@index');
    Route::get('webpayment/{token}', 'webpaymentController@index');
    Route::post('webpayment/create','webpaymentController@create');
    Route::post('store/add-cart/{id}','storeController@addCart');
    Route::post('store/update-cart','storeController@updateCart');
    Route::post('store/remove-cart','storeController@removeCart');
    Route::post('store/change-qty','storeController@changeItemQty');

    Route::post('store/create-account','storeController@createAccount');

    Route::post('webhooks', 'Webhooks\StripeWebhookController@handleWebhook');

    //Route::post('webhooks','Laravel\Cashier\WebhookController@handleWebhook');

    Route::controllers([
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController'

    ]);
