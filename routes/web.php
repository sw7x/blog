<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');

Route::get('/teen-and-summer-holidays', 'TeenAndSummerHolidaysController@index')->name('teen-and-summer-holidays');

Route::get('/destinations', function () {
    return view('destinations');
})->name('destinations');

Route::get('/accommodation', function () {
    return view('accommodation');
})->name('accommodation');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');




//routes for contact page
Route::group(['prefix'=>'contact','as'=>'contact.'], function(){
    Route::get('', 	  'ContactController@index')->name('index');
    Route::post('/submit', 'ContactController@submit')->name('submit');
    Route::get('/submit', 'ContactController@loadSubmit')->name('submit');
    //Route::get('/failed', 'ContactController@failed')->name('failed');
});


Route::group(['prefix'=>'packages','as'=>'packages.'], function(){
    Route::get('', 	  'PackageController@index')->name('index');
    Route::get('/{pakageId?}', 'PackageController@singlePackage')->name('single');
});


//admin panel routes
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){

    Route::group(['middleware'=> 'adminPanelAuthCheck'], function() {
        
        Route::get ('', 'admin\AdminController@index')->name ('index');

        Route::group(['prefix'=>'contact','as'=>'contact.'], function(){
            Route::get ('/contact', 'admin\AdminController@loadContactPage')->name ('index');
            Route::post ('/contact/view', 'admin\ContactFormController@viewComments')->name ('view'); ///
            Route::post ('/contact/delete', 'admin\ContactFormController@deleteCommentById')->name ('delete');///
        });

        Route::get ('/dashboard', 'admin\AdminController@loadDashboardPage')->name ('dashboard');

        Route::group(['prefix'=>'packages','as'=>'packages.'], function(){
            Route::get ('/packages', 'admin\AdminController@loadPackagesPage')->name ('index');
            Route::post ('/packages/view', 'admin\PackagesController@loadPackagesTbl')->name ('view');
            Route::post ('/packages/delete', 'admin\PackagesController@deletePackageById')->name ('delete');
            Route::post ('/packages/create', 'admin\PackagesController@createPackage')->name ('create');
            Route::post ('/packages/update', 'admin\PackagesController@updatePackage')->name ('update');
        });

        Route::group(['prefix'=>'home-slider','as'=>'home-slider.'], function(){
            Route::get ('/home-slider', 'admin\HomeSliderController@loadHomeSliderPage')->name ('index');
            Route::post ('/home-slider/view', 'admin\HomeSliderController@loadHomeSliderTbl')->name ('view');
            Route::post ('/home-slider/delete', 'admin\HomeSliderController@deleteHomeSliderById')->name ('delete');
            Route::post ('/home-slider/create', 'admin\HomeSliderController@createHomeSlider')->name ('create');
            Route::post ('/home-slider/update', 'admin\HomeSliderController@updateHomeSlider')->name ('update');
        });

        //Route::get ('/destinations', 'admin\AdminController@loadDestinationsPage')->name ('destinations');
        //Route::get ('/hotels', 'admin\AdminController@loadHotelsPage')->name ('hotels');       
        
        Route::post('/change-password', 'admin\AdminController@changePassword')->name('change-password');
    });

    //Auth::routes();

    // Authentication Routes...
    Route::get('login', ['as' => 'login','uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.submit','uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout','uses' => 'Auth\LoginController@logout']);

    // Password Reset Routes...
    // Route::post('password/email', ['as' => 'password.email','uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    // Route::get('password/reset', ['as' => 'password.request','uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    // Route::post('password/reset', ['as' => 'password.update','uses' => 'Auth\ResetPasswordController@reset']);
    // Route::get('password/reset/{token}', ['as' => 'password.reset','uses' => 'Auth\ResetPasswordController@showResetForm']);
    // Route::post('password/confirm', ['as' => 'password.confirm','uses' => 'Auth\ConfirmPasswordController@confirm']);
    // Route::get('password/confirm', ['as' => 'password.confirm','uses' => 'Auth\ConfirmPasswordController@showConfirmForm']);

    // Registration Routes...
    // Route::get('register', ['as' => 'register','uses' => 'Auth\RegisterController@showRegistrationForm']);
    // Route::post('register', ['as' => 'register.submit','uses' => 'Auth\RegisterController@register']);

});