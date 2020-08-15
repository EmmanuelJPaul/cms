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
    return view('index');
});



Auth::routes();

//All the Admin Routes
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth', 'admin')->group(function(){
    Route::get('/', 'AdminController@index');
    Route::post('/user/role', 'AdminController@assignRole')->name('user.role');
});

//All the Staff Routes
Route::namespace('Staff')->prefix('staff')->name('staff.')->middleware('auth', 'staff')->group(function(){
    Route::get('/', 'StaffController@index');

    Route::prefix('profile')->name('profile')->group(function(){
        Route::get('/','StaffController@profile');
        Route::post('/edit', 'StaffController@profileUpdate')->name('.edit');
        Route::post('avatar/edit', 'StaffController@avatar')->name('.avatar.edit');
    });

    Route::prefix('qualification')->name('qualification')->group(function(){
        Route::get('/','StaffController@qualification');
        Route::post('/edit','StaffController@jsonUpdate')->name('.edit');
    });

    Route::prefix('publication')->name('publication')->group(function(){
        Route::get('/','StaffController@publication');
        Route::post('/edit','StaffController@jsonUpdate')->name('.edit');
    });

    Route::prefix('workshop')->name('workshop')->group(function(){
        Route::get('/','StaffController@workshop');
        Route::post('/edit','StaffController@jsonUpdate')->name('.edit');
    });

    Route::prefix('online_course')->name('online_course')->group(function(){
        Route::get('/','StaffController@online_course');
        Route::post('/edit','StaffController@jsonUpdate')->name('.edit');
    });
    
});

Route::get('/home', 'HomeController@index')->name('home');
