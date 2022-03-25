<?php

use Illuminate\Support\Facades\Route;
use Modules\UserPanel\Http\Controllers\UserPanelController;
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

    Route::group(['middleware' => 'curr_role:user','prefix' => 'user'], function(){

        Route::get('/', [UserPanelController::class,'index'])->name('standard.user');
        Route::post("tran",[UserPanelController::class,'savetran'])->name('user.tran');
    });
});