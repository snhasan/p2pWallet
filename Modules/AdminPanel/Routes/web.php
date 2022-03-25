<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminPanel\Http\Controllers\AdminPanelController;
use app\Http\Middleware\CheckRole;
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



Route::group(['middleware' => 'auth'], function(){

    Route::group(['middleware' => 'curr_role:admin','prefix' => 'admin'], function(){

        Route::get('/', [AdminPanelController::class,'index'])->name('admin.user');
        Route::get("/userDetails/{id}",[AdminPanelController::class,'userDetails'])->name('admin.userDetails');
    });
});