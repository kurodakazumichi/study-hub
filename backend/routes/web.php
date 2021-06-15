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

Route::prefix('/categories')->group(function() {
  Route::get('/', [CategoryController::class, 'index']);
});

Route::prefix('/varieties')->group(function() {
  Route::get('/', [VarietyController::class, 'index']);
});

Route::prefix('/studies')->group(function() {
  Route::get('/', [StudyController::class, 'index']);
  Route::get('/{id}/edit', [StudyController::class, 'edit']);
});

Route::prefix('/debug')->group(function(){
  Route::get('/', [DebugController::class, 'index']);
  Route::get('/plural', [DebugController::class, 'plural']);
  Route::get('/query', [DebugController::class, 'query']);
});