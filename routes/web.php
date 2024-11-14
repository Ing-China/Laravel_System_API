<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\BookTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TypeOfBookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('backend.layout.master');
// });


Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('booktypes', BookTypeController::class);
    Route::patch('/sliders/{slider}/status', [SliderController::class, 'updateStatus'])->name('sliders.updateStatus');
    Route::patch('/booktypes/{id}/update-active', [BookTypeController::class, 'updateActive'])->name('booktypes.updateActive');
});
