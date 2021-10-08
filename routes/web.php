<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    return view('welcome');
});

//signup form route
Route::get('/signup', 'AuthController@signup')->name('signup');
//store employee details route
Route::post('/store', 'AuthController@submitDetails')->name('employee.store');
//signin form route
Route::get('/signin', 'AuthController@signin')->name('signin');
//signin route
Route::post('/login', 'AuthController@login')->name('employee.login');

//admin login route
Route::prefix('/admin')->group(function () {
    Route::get('/signin', 'AuthController@signin')->name('admin.signin');
    Route::post('/login', 'AuthController@adminLogin')->name('admin.login');
    Route::resource('dtable-employees', 'DashboardController');
    Route::get('dtable-employees/destroy/{id}', 'DashboardController@destroy');
});
	

