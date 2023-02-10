<?php

use App\Http\Controllers\{BanksController, CustomerController, InvoiceController, ProductMasterController, UserController, SettingController,InvoicePaymentsController, InvoicePerformaController};
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
    Route::resource('invoice', InvoiceController::class)->only(['index','show','create','edit','update','store']);
    Route::post('addItem', [ProductMasterController::class, "addItem"])->name('addToCart');
    Route::post('removeItem', [ProductMasterController::class, "removeItem"])->name('removeItem');
    Route::post('reloadProductsTbl', [ProductMasterController::class, "reloadProductsTbl"])->name('reloadProductsTbl');
    Route::get('showInv/{invoice}', [InvoiceController::class, "showInv"])->name('showInv');
    Route::get('generate-ewaybill/{invoice}', [InvoiceController::class, "generateEwayBill"])->name('generate-ewaybill');
    Route::get('export-invoices', [InvoiceController::class, "exportInvoices"])->name('export-invoices');

    //Inv Payments
    Route::resource('inv-payment', InvoicePaymentsController::class);

    //Banks
    Route::resource('banks', BanksController::class);

    //Invoice Performa
    Route::resource('invoice-performa',InvoicePerformaController::class);
});
