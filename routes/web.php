<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\UserSession;

use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\DailySellController;

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

//login - logout
Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/check-login', [UserController::class, 'checkLogin'])->name('checkLogin');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::middleware([UserSession::class])->group(function () {

//users
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::post('/update-user', [UserController::class, 'updateUser'])->name('updateUser');


//dashboard
Route::get('/dashboard', [ShipmentController::class, 'dashboard'])->name('dashboard');

//shipments
Route::get('/shipments', [ShipmentController::class, 'shipments'])->name('shipments');
Route::post('/add-shipment', [ShipmentController::class, 'addShipment'])->name('addShipment');
Route::post('/add-product-shipment', [ShipmentController::class, 'addProductShipment'])->name('addProductShipment');
Route::post('/update-shipment', [ShipmentController::class, 'updateShipment'])->name('updateShipment');
Route::post('/delete-shipment', [ShipmentController::class, 'deleteShipment'])->name('deleteShipment');
Route::post('/delete-shipment-product', [ShipmentController::class, 'deleteShipmentProduct'])->name('deleteShipmentProduct');


Route::post('/update-item', [ShipmentController::class, 'updateItem'])->name('updateItem');

Route::post('/sell-shipment', [ShipmentController::class, 'sellShipment'])->name('sellShipment');
Route::post('/update-sell', [ShipmentController::class, 'updateSell'])->name('updateSell');
Route::post('/delete-sell', [ShipmentController::class, 'deleteSell'])->name('deleteSell');

Route::post('/search-shipment-value', [ShipmentController::class, 'searchShipmentValue'])->name('searchShipmentValue');

Route::get('/search-shipment/{number}', [ShipmentController::class, 'searchShipment'])->name('searchShipment');

Route::post('/add-expneses', [ShipmentController::class, 'addExpenses'])->name('addExpenses');

Route::get('/exp-report', [ShipmentController::class, 'expReport'])->name('expReport');
Route::post('/expneses-report', [ShipmentController::class, 'expensesReport'])->name('expensesReport');

//currency
Route::get('/currency', [ShipmentController::class, 'currency'])->name('currency');
Route::post('/update-currency', [ShipmentController::class, 'updateCurrency'])->name('updateCurrency');

//products
Route::get('/products', [ShipmentController::class, 'products'])->name('products');
Route::post('/add-product', [ShipmentController::class, 'addProduct'])->name('addProduct');
Route::post('/update-product', [ShipmentController::class, 'updateProduct'])->name('updateProduct');
Route::get('/hide-product/{id}', [ShipmentController::class, 'hideProduct'])->name('hideProduct');
Route::get('/delete-product/{id}', [ShipmentController::class, 'deleteProduct'])->name('deleteProduct');

//note
Route::get('/notes', [NoteController::class, 'notes'])->name('notes');
Route::post('/add-note', [NoteController::class, 'addNote'])->name('addNote');
Route::post('/update-note', [NoteController::class, 'updateNote'])->name('updateNote');
Route::post('/selling-from-note', [NoteController::class, 'sellingFromNote'])->name('sellingFromNote');

Route::post('/search-note-value', [NoteController::class, 'searchNoteValue'])->name('searchNoteValue');

Route::get('/search-note/{date_from}/{date_to}', [NoteController::class, 'searchNote'])->name('searchNote');

//transactions
Route::get('/transactions', [TransactionController::class, 'transactions'])->name('transactions');

Route::post('/add-client', [TransactionController::class, 'addClient'])->name('addClient');
Route::post('/update-client', [TransactionController::class, 'updateClient'])->name('updateClient');
Route::get('/print-client/{id}', [TransactionController::class, 'printClient'])->name('printClient');

Route::post('/add-transaction', [TransactionController::class, 'addTransaction'])->name('addTransaction');
Route::post('/update-transaction', [TransactionController::class, 'updateTransaction'])->name('updateTransaction');


//daily sells
Route::get('/daily-sells', [DailySellController::class, 'dailySells'])->name('dailySells');
Route::post('/add-daily-sell', [DailySellController::class, 'addDailySell'])->name('addDailySell');
Route::post('/edit-daily-sell', [DailySellController::class, 'editDailySell'])->name('editDailySell');
Route::get('/delete-daily-sell/{id}', [DailySellController::class, 'deleteDailySell'])->name('deleteDailySell');

Route::post('/search-daily-value', [DailySellController::class, 'searchDailyValue'])->name('searchDailyValue');
Route::get('/search-daily/{date_from}/{date_to}', [DailySellController::class, 'searchDaily'])->name('searchDaily');

Route::get('/daily-shorts', [DailySellController::class, 'dailyShorts'])->name('dailyShorts');
Route::post('/add-daily-short', [DailySellController::class, 'addDailyShort'])->name('addDailyShort');

});
