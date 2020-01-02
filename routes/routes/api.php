<?php

use Illuminate\Http\Request;

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

Route::post('CheckLogin', 'API\UserController@userLogin');
Route::post('CustomerLogin', 'API\UserController@customerLogin');
Route::post('CustomerRegister', 'API\UserController@customerRegister');
Route::post('user/register', 'API\UserController@userRegister');
Route::post('SendNotification', 'API\FirebaseController@sendNotification');
Route::post('CheckExistedEmail', 'API\UserController@checkExistedEmail');
Route::post('CheckExistedPhone', 'API\UserController@checkExistedPhone');
Route::get('user/test', 'API\UserController@test');
//Route::group(['middleware' => 'auth:api'], function () {
//User
Route::post('user/UpdateLastLogin', 'API\UserController@updateLastLogin');
Route::post('user/LoadRole', 'API\UserController@loadRole');
Route::post('user/LoadAccountant', 'API\UserController@loadAccountant');
Route::post('user/LoadEmployee', 'API\UserController@loadEmployee');
Route::post('user/UpdateTimeCardD', 'API\UserController@updateTimeCardD');
Route::post('user/CountEmployee', 'API\UserController@countEmployee');
Route::post('user/LoadCustomer', 'API\UserController@loadCustomer');
Route::post('user/InsertCustomer', 'API\UserController@insertCustomer');
Route::post('user/UpdateCustomer', 'API\UserController@updateCustomer');
Route::post('user/DeleteCustomer', 'API\UserController@deleteCustomer');
Route::post('user/LoadCustomerToGrid', 'API\UserController@loadCustomerToGrid');
Route::post('user/EnableCustomer', 'API\UserController@enableCustomer');
Route::post('user/ChangePassword', 'API\UserController@changePassword');

//Advance
Route::post('GetAdvanced', 'API\AdvanceController@getAdvanced');
Route::post('GetAdvancedDetails', 'API\AdvanceController@getAdvancedDetails');
Route::post('InsertAdvanceMaster', 'API\AdvanceController@insertAdvanceMaster');
Route::post('InsertAdvanceDetail', 'API\AdvanceController@insertAdvanceDetail');

//Payment
Route::post('GetPayment', 'API\PaymentController@getPayment');
Route::post('GetPaymentDetails', 'API\PaymentController@getPaymentDetails');
Route::post('GetLastPayCode', 'API\PaymentController@getLastPayCode');
Route::post('InsertPaymentMaster', 'API\PaymentController@insertPaymentMaster');
Route::post('UpdatePaymentMaster', 'API\PaymentController@updatePaymentMaster');
Route::post('InsertPaymentDetails', 'API\PaymentController@insertPaymentDetails');
Route::post('UpdateTotalPayment', 'API\PaymentController@updateTotalPayment');
Route::post('DeletePaymentDetails', 'API\PaymentController@deletePaymentDetails');

//MaxID
Route::post('GetMaxID', 'API\MaxIDController@getMaxID');
Route::post('UpdateMaxPayment', 'API\MaxIDController@updateMaxPayment');
Route::post('UpdateMaxReceipt', 'API\MaxIDController@updateMaxReceipt');
Route::post('UpdateMaxImport', 'API\MaxIDController@updateMaxImport');
Route::post('UpdateMaxExport', 'API\MaxIDController@updateMaxExport');

//Item
Route::post('InsertItem', 'API\ItemsController@insertItem');
Route::post('UpdateItem', 'API\ItemsController@updateItem');
Route::post('DeleteItem', 'API\ItemsController@deleteItem');
Route::post('LoadItem', 'API\ItemsController@loadItem');
Route::post('CheckExistedItemName', 'API\ItemsController@checkExistedItemName');


//Unit
Route::post('InsertUnit', 'API\UnitsController@insertUnit');
Route::post('LoadUnit', 'API\UnitsController@loadUnit');
Route::post('CheckExistedUnitName', 'API\UnitsController@checkExistedUnitName');
Route::post('LoadUnitID', 'API\UnitsController@loadUnitID');

//Tour
Route::post('LoadTour', 'API\TourController@loadTour');
Route::post('LoadStartDateByTour', 'API\TourController@loadStartDateByTour');

//test

Route::post('GetFirstDate', 'API\UserController@getFirstDate');
Route::post('GetCurrentDateTime', 'API\UserController@getCurrentDateTime');
Route::post('ExecuteSQL', 'API\UserController@executeSQL');

//});
Route::post('blog', 'API\BlogController@index');
Route::post('blog/{slug}', 'API\BlogController@getBlog');
Route::post('blog/category/{slug}', 'API\BlogController@getBlogCategory');
Route::post('blog/category/{slug}/search/{search}', 'API\BlogController@getBlogCategory');
Route::post('destinationpoint', 'API\DestinationPointController@getAll');

