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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

//All the Admin Routes
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth', 'admin')->group(function(){
    Route::get('/', 'AdminController@index');
    Route::post('/user/role', 'AdminController@assignRole')->name('user.role');
    Route::post('/user/search', 'AdminController@users')->name('user.search');
});

//All the Staff Routes
Route::namespace('Staff')->prefix('staff')->name('staff.')->middleware('auth', 'staff')->group(function(){
    Route::get('/', 'StaffController@index');

    Route::prefix('profile')->name('profile')->group(function(){
        Route::get('/','StaffController@profile');
        Route::post('/edit', 'StaffController@edit')->name('.edit');
        Route::post('avatar/edit', 'StaffController@avatar')->name('.avatar.edit');
    });
   
});

// General Auth Routes
Route::middleware('auth')->group(function(){
    Route::get('/search/{id}', 'UserController@show')->name('search.show');
    Route::post('/search', 'UserController@index')->name('search');

    Route::post('user/delete', 'UserController@remove')->name('user.delete');
});

//Guest Login 
Route::get('/guest', 'HomeController@index')->name('home');
