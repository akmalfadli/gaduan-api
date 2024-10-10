<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\KambingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::get('logout', [PassportAuthController::class, 'logout'])->middleware('auth:api');
Route::get('penerimas', [PenerimaController::class, 'index']);
Route::get('kambings', [KambingController::class, 'index']);

//Route::get('image/{filename}', [PostController::class, 'displayImage']);
Route::middleware('auth:api')->group(function () {

    Route::resource('periksas', PeriksaController::class);
    Route::resource('posts', PostController::class);
     /**
     * Route penerima
     */
    
    Route::post('penerimas', [PenerimaController::class, 'store']);
    Route::patch('penerimas/{id}', [PenerimaController::class, 'update']);
    Route::delete('penerimas/{id}', [PenerimaController::class, 'destroy']);

    /**
     * Route kambing
     */
    
    Route::post('kambings', [KambingController::class, 'store']);
    Route::patch('kambings/{id}', [KambingController::class, 'update']);
    Route::delete('kambings/{id}', [KambingController::class, 'destroy']);

    /**
     * Route Like
     */
    Route::post('likes', [LikeController::class, 'store']);
    Route::get('likes', [LikeController::class, 'index']);
});