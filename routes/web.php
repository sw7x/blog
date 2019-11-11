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

// Route::get('/', function () {
//     return view('welcome');
// });





Route::get('/', function () {
    return view('index');
})->name('index');






Route::get('/teen-and-summer-holidays', function () {
    return view('teen-and-summer-holidays');
})->name('teen-and-summer-holidays');

Route::get('/destinations', function () {
    return view('destinations');
})->name('destinations');

Route::get('/accommodation', function () {
    return view('accommodation');
})->name('accommodation');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');




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






//AdminController@login




// home
// teen-and-summer-holidays
// destinations
// accommodation
// gallery
// contact


// packdisplay.php?dis=8
// packages
