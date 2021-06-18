<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\VarietyController;
use App\Http\Controllers\Web\StudyController;
use App\Http\Controllers\Web\DebugController;
use App\Http\Controllers\Web\StudyIndexController;
use App\Http\Controllers\Web\StudyProblemController;
use App\Http\Controllers\Web\NoteController;

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

Route::prefix('studies/{study_id}/indices')->group(function() {
  Route::get('/', [StudyIndexController::class, 'index']);
});

Route::prefix('studies/{study_id}/problems')->group(function() {
  Route::get('/', [StudyProblemController::class, 'index']);
});

Route::prefix('/notes')->group(function() {
  Route::get('/', [NoteController::class, 'index']);
  Route::get('/create', [NoteController::class, 'create']);
  Route::get('/{id}/edit', [NoteController::class, 'edit']);
  Route::get('/{id}/show', [NoteController::class, 'show']);
});


Route::prefix('/debug')->group(function(){
  Route::get('/', [DebugController::class, 'index']);
  Route::get('/plural', [DebugController::class, 'plural']);
  Route::get('/query', [DebugController::class, 'query']);
  Route::get('/diary', [DebugController::class, 'diary']);
});