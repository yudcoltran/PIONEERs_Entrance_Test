<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('jwt.verify')->group(function() {
    Route::get('/users', [UserController::class, 'index']);
    Route::controller(ProductController::class)->group(function(){
        Route::get('/products', 'index');
        Route::get('/products/{id}', 'show');
        Route::post('/products', 'store');
        Route::get('/products/{id}/edit', 'edit');
        Route::put('/products/{id}/edit', 'update');
        Route::delete('/products/{id}/delete', 'destroy');
    });
});
