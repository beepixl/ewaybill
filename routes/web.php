<?php

use App\Http\Controllers\{CustomerController, InvoiceController, ProductMasterController, UserController, SettingController};
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

Route::group(["middleware" => ['auth:sanctum', 'verified']], function () {
    Route::view('/dashboard', "dashboard")->name('dashboard');

    Route::get('/user', [UserController::class, "index_view"])->name('user');
    Route::view('/user/new', "pages.user.user-new")->name('user.new');
    Route::view('/user/edit/{userId}', "pages.user.user-edit")->name('user.edit');

    //Users
    Route::resource('users', UserController::class);

    //Roles
    // Route::resource('roles', RoleController::class);

    //Setting
    Route::resource('setting', SettingController::class)->only(['index']);

    //Product Master
    Route::resource('product-master', ProductMasterController::class)->only(['index', 'create', 'edit','show']);
    Route::post('product-detail',[ProductMasterController::class, "productDetail"])->name('product-detail');

    //Customer
    Route::resource('customer', CustomerController::class)->only(['index', 'create', 'edit']);

    //Invoice
    Route::resource('invoice', InvoiceController::class)->only(['index', 'create']);
    Route::post('addItem', [ProductMasterController::class, "addItem"])->name('addToCart');
});
