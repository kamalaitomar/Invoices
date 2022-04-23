<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Models\invoices_attachments;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductsController::class);
Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);

Route::get('section/{id}', [InvoicesController::class, 'getProducts']);

Route::get('InvoicesDetails/{id}', [InvoicesDetailsController::class, 'show']);
Route::post('/Status_Update/{id}', [InvoicesDetailsController::class, 'update'])->name('Status_Update');

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'openFile']);
Route::get('Download_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'DownloadFile']);
Route::post('Delete_file', [InvoicesDetailsController::class, 'destroy'])->name('Delete_file');

Route::get('/{page}', [AdminController::class, 'index']);
