<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/','HomeController@index')->name('guest_homepage');

// Route::get('/posts','PostController@index');
// Route::get('/posts/{slug}','PostController@show')->name('posts_show');

Route::prefix('posts')
    ->group(function(){
        Route::get('/','PostController@index');
        Route::get('/{slug}','PostController@show')->name('posts_show');
    });

Route::prefix('categories')
    ->group(function(){
        Route::get('/','CategoryController@index');
        Route::get('/{slug}','CategoryController@show')->name('category_show');
});


Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')
->namespace('Admin')
->middleware('auth')
->group(function () {
    Route::get('/', 'HomeController@index')->name('admin_homepage');
    Route::get('/profile', 'HomeController@profile')->name('admin_profile');
    Route::resource('/posts','PostController');
});