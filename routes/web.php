<?php

use App\Http\Controllers\TabloidController;
use App\Models\Tabloid;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/jquery', function () {
    return view('jquery');
});

Route::get('/tabloids', [TabloidController::class, 'index']);
Route::post('/tabloids', [TabloidController::class, 'store']);
Route::get('/tabloids/{tabloid}/editor', [TabloidController::class, 'edit'])->name('tabloid.edit');
Route::post('/tabloids/{tabloid}/editor', [TabloidController::class, 'update'])->name('tabloid.update');
Route::get('/tabloids/{tabloid}/get-pages', [TabloidController::class, 'getAllPages'])->name('tabloid.getpages');
