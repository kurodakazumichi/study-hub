<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\VarietyController;
use App\Http\Controllers\Api\StudyController;
use App\Http\Controllers\Api\StudyIndexController;
use App\Http\Controllers\Api\StudyProblemController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\AchievementController;
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
Route::put('/studies/{id}/sort', [StudyController::class, 'sort'])->name('studies.sort');

Route::prefix('/studies/{study_id}/indices')->group(function() {
  Route::post('/'     , [StudyIndexController::class, 'store'])->name('studies.indices.store');
  Route::post('/batch', [StudyIndexController::class, 'batch'])->name('studies.indices.batch');
  Route::get('/{index_id}', [StudyIndexController::class, 'show'])->name('studies.indices.show');
  Route::put('/{index_id}', [StudyIndexController::class, 'update'])->name('studies.indices.update');
});

Route::prefix('/studies/{study_id}/problems')->group(function() {
  Route::post('/'         , [StudyProblemController::class, 'store'])->name('studies.problems.store');
  Route::get('/{index_id}', [StudyProblemController::class, 'show'])->name('studies.problems.show');
  Route::put('/{index_id}', [StudyProblemController::class, 'update'])->name('studies.problems.update');  
});

Route::prefix('/notes')->group(function() {
  Route::post('/', [NoteController::class, 'store'])->name('notes.store');
  Route::put('/{note_id}', [NoteController::class, 'update'])->name('notes.update');
});

Route::prefix('/achievements')->group(function() {
  Route::post('/'         , [AchievementController::class, 'store'])->name('achievements.store');
  Route::get('/{achievement_id}', [AchievementController::class, 'show'])->name('achievements.show');
  Route::put('/{achievement_id}', [AchievementController::class, 'update'])->name('achievements.update');  
});