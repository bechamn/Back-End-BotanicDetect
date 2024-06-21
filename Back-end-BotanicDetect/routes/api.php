<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlantDiseaseController;
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\SuggestionController;
use App\Http\Controllers\Api\UserController;
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
Route::post('/register', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group( function () {
    //myplant
    Route::get('/plants', [PlantController::class, 'index']);
    Route::get('/plants/{plant}', [PlantController::class, 'show']);
    Route::post('plants', [PlantController::class, 'store']);
    Route::put('plants/{id}', [PlantController::class, 'update']);
    
    //scan
    Route::post('/scan-leaf', [PlantDiseaseController::class, 'scanLeaf'])->name('scan-leaf');
    
    //list Disease
    Route::get('/diseases', [PlantDiseaseController::class, 'indexdiseases']);
    
    //suggestion
    Route::get('/suggestion', [SuggestionController::class, 'index']);
    Route::get('/suggestion/{diseaseSlug}', [SuggestionController::class, 'show']);

    //history
    Route::get('/history', [PlantDiseaseController::class, 'indexhistory']);
    Route::post('/history', [PlantDiseaseController::class, 'indexhistory']);

    //logout
    Route::post('/logout', [UserController::class, 'logout']);
});
