<?php

use Illuminate\Support\Facades\Route;

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

// Auth routes w/o email verification, although you could use the log driver for emails.
// In this case forgoing emails made sense.
Auth::routes(['verify' => true]);

// For redirecting root to home
// This allows us flexiblity to change what displays at the root,
// ie show a splash/about page later on,
// as opposed to changing where the auth redirects to after login/registration
Route::get('/', 'RootController@index')->name('root');

// And finally we have the home controller also generated by Laravel's Auth
Route::get('home', 'HomeController@index')->name('home');

// This route group handles the uploads
Route::prefix('upload')->group(function(){
    Route::get('/', 'UploadController@index')->name('upload');
    Route::post('/', 'UploadController@create')->name('upload.create');
});

// And here we have the routes that handle previewing files
Route::get('preview/{slug}', 'PreviewController@index')->name('preview');
Route::get('media/{slug}', 'MediaController@index')->name('media');