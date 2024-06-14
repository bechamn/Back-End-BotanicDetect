<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlantDiseaseController;
use App\Http\Controllers\Api\PlantDiseaseList;
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\SuggestionController;

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

// routes/api.php

//myplant
Route::get('/plants', [PlantController::class, 'index']);
Route::get('/plants/{plant}', [PlantController::class, 'show']);
Route::post('plants', [PlantController::class, 'store']);
Route::put('plants/{id}', [PlantController::class, 'update']);

//scan
Route::post('/scan-leaf', [PlantDiseaseController::class, 'scanLeaf'])->name('scan-leaf');

//list Disease
Route::get('/diseases', [PlantDiseaseList::class, 'index']);

//suggestion
Route::get('/suggestion', [SuggestionController::class, 'index']);
Route::get('/suggestion/{diseaseSlug}', [SuggestionController::class, 'show']);