<?php

use Illuminate\Http\Request;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;

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

Route::post('login', 'API\APIMainController@login');
Route::post('login/refresh', 'API\APIMainController@refresh');
Route::post('register', 'API\APIMainController@signup');
Route::post('delete-account', 'API\APIMainController@deleteAccount');
Route::post('forgot-password', 'API\APIMainController@forgotPassword');

Route::post('profile', 'API\APIMainController@profile');
Route::get('sliders', 'API\APIMainController@sliders');
Route::get('purchase', 'API\APIMainController@purchase');
Route::get('purchase-item', 'API\APIMainController@purchaseitem');
Route::get('categories', 'API\APIMainController@categories');
Route::get('products', 'API\APIMainController@products');
Route::get('notifications', 'API\APIMainController@notifications');
Route::get('coupons', 'API\APIMainController@coupons');
Route::get('branches', 'API\APIMainController@branches');
Route::get('feedback', 'API\APIMainController@feedback');
Route::post('feedback', 'API\APIMainController@postFeedback');
Route::get('events', 'API\APIMainController@events');
Route::post('events', 'API\APIMainController@postEvents');
Route::put('userpoint/update', 'API\APIMainController@updateUserPoints');
Route::get('subcategories', 'API\APIMainController@subcategories');

// Route::get('users', 'API\APIMainController@getAllUsers');
// //Route::get('users/{userId}', 'API\APIMainController@getUsersByUserId');
// Route::post('users', 'API\APIMainController@postUser');