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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\MediaController;

Route::get('/upload', function () {
    return view('upload');
})->name('media.upload.form');

Route::get('/detail/{id}', [MediaController::class, 'detail'])->name('media.detail');
Route::post('/upload', [MediaController::class, 'store'])->name('media.upload');
