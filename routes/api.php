<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[AuthController::class,'userLogin']);
Route::post('register',[AuthController::class,'register']);
Route::group(['middleware'=>'auth:api'], function() {
    Route::get('email-list',[EmailController::class,'getEmailList']);
    Route::post('send-email',[EmailController::class,'sendEmail']);  
    Route::get('logout',[AuthController::class,'logout']);  
});

Route::get('validate-token',function(){
        return true;
})->middleware('auth:api');