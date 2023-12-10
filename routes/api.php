<?php

use App\Http\Controllers\BurgerHubController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('foods')->group(function () {
    Route::get('/', [FoodController::class, 'index']);
    Route::get('/{id}', [FoodController::class, 'show']);
    Route::post('/', [FoodController::class, 'store']);
    Route::put('/{id}', [FoodController::class, 'update']);
    Route::delete('/{id}', [FoodController::class, 'destroy']);
});

Route::get('/burger-hub', [BurgerHubController::class,'index'])->name('index');

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/', [CategoryController::class, 'store']);
});
