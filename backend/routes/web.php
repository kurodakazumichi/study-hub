<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\VarietyController;
use App\Http\Controllers\Web\StudyController;
use App\Http\Controllers\Web\DebugController;

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
Route::get('/', function() { return view('welcome'); });
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/create', [CategoryController::class, 'create']);
Route::post('/categories/store', [CategoryController::class, 'store']);
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
Route::patch('/categories/{id}', [CategoryController::class, 'update']);

Route::prefix('/varieties')->group(function() {
  Route::get('/', [VarietyController::class, 'index']);
});

Route::prefix('/studies')->group(function() {
  Route::get('/', [StudyController::class, 'index']);
});

Route::prefix('/debug')->group(function(){
  Route::get('/', [DebugController::class, 'index']);
  Route::get('/plural', [DebugController::class, 'plural']);
  Route::get('/query', [DebugController::class, 'query']);
});