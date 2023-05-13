<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [LoanController::class, 'index'])->name('loan.index');

Route::get('/loan', [LoanController::class, 'index'])->name('loan.index');

Route::post('/loan/calculate', [LoanController::class, 'calculate'])->name('loan.calculate');
