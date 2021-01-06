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
Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('user/table-data', 'UsersController@getData')->name('user.table');
    Route::post('user/update/password/{id}', 'UsersController@updatePassword')->name('user.update-password');
    Route::resource('/users', 'UsersController');

    Route::get('role/table-data', 'RolesController@getData')->name('role.table');
    Route::resource('/roles', 'RolesController');

    // Settings
    Route::patch('/settings', 'SettingsController@update')->name('settings.update');
    Route::get('/settings', 'SettingsController@index')->name('settings.index');

    //Branch
    Route::resource('/branches','BranchController');
    Route::get('branch/table-data', 'BranchController@getData')->name('branch.table');

    //Category
    Route::resource('/categories','CategoryController');

    //Brand
    Route::resource('/brands','BrandController');

    //Sale
    Route::resource('/sales','SaleController');

    //Customer
    Route::resource('/customers','CustomerController');
    Route::get('customer/table-data', 'CustomerController@getData')->name('customer.table');

    //Supplier
    Route::resource('/suppliers','SupplierController');

    //Import Stock
    Route::resource('/import-stocks','ImportStockController');
});

Auth::routes();
