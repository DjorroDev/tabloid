<?php

use App\Http\Controllers\TabloidController;
use App\Http\Controllers\TabloidImageController;
use App\Http\Controllers\TabloidTemplateController;
use App\Models\TabloidTemplate;
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
Route::get('/tabloids/{id}/export', [TabloidController::class, 'exportToPDF'])->name('tabloid.export');
Route::put('/tabloids/{tabloid}/update-title', [TabloidController::class, 'updateTitle'])->name('tabloid.updatetitle');
Route::delete('/tabloids/{tabloid}/delete', [TabloidController::class, 'destroy'])->name('tabloid.destroy');


Route::get('/tabloids/template', [TabloidTemplateController::class, 'index'])->name('tabloid.template.index');
Route::post('/tabloids/template/save', [TabloidTemplateController::class, 'save'])->name('tabloid.template.save');
Route::get('/tabloids/images', [TabloidImageController::class, 'index'])->name('tabloid.image.index');
Route::post('/tabloids/upload-image', [TabloidImageController::class, 'store'])->name('tabloid.image.store');
Route::delete('/tabloids/images/{id}', [TabloidImageController::class, 'destroy'])->name('tabloid.image.destroy');
