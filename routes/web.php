<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignController;

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

Route::redirect('/', '/admin');

Route::get('/sign/{id}/{token}', [SignController::class, 'index'])->name('sign');
Route::post('/store/{id}', [SignController::class, 'store'])->name('store');
Route::get('/thankyou/{id}/{token}', [SignController::class, 'thankyou'])->name('thankyou');

