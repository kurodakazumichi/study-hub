<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\VarietyController;
use App\Http\Controllers\Api\StudyController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/categories', CategoryController::class);
Route::put('/categories/{id}/order', [CategoryController::class, 'order'])->name('categories.order');
Route::apiResource('/varieties', VarietyController::class);
Route::put('/varieties/{id}/order', [VarietyController::class, 'order'])->name('varieties.order');
Route::apiResource('/studies', StudyController::class);
