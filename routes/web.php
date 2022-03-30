<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DTRController;

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
    return redirect('/dtr');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dtr', [DTRController::class, 'index'])->name('index');
Route::get('/upload', [DTRController::class, 'upload'])->name('upload');
Route::post('/uploadSubmit', [DTRController::class, 'uploadSubmit'])->name('uploadSubmit');
Route::get('/import', [DTRController::class, 'import'])->name('import');
Route::get('/dtr/get', [DTRController::class, 'getDTR'])->name('getDTR');
