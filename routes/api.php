<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboadController;
use App\Http\Controllers\SettingController;


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


Route::get('/admin/dashboard', [DashboadController::class, 'index']);
Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']);
    Route::post('/', [VehicleController::class, 'store']);
    Route::get('/{id}', [VehicleController::class, 'show']);
    Route::put('/{id}', [VehicleController::class, 'update']);
    Route::delete('/{id}', [VehicleController::class, 'destroy']);
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::post('/', [NewsController::class, 'store']);
    Route::get('/{news}', [NewsController::class, 'show']);
    Route::put('/{news}', [NewsController::class, 'update']);
    Route::delete('/{news}', [NewsController::class, 'destroy']);
});

Route::prefix('reviews')->group(function () {
    Route::get('/',      [ReviewsController::class, 'index']);
    Route::post('/',     [ReviewsController::class, 'store']);

    Route::get('/{review}',    [ReviewsController::class, 'show']);
    Route::put('/{review}',    [ReviewsController::class, 'update']);
    Route::delete('/{review}', [ReviewsController ::class, 'destroy']);
});
// FIXED: Update these routes to match frontend calls
Route::get('/fuel-types', [SettingController::class, 'fuels']);
Route::get('/models', [SettingController::class, 'models']);
Route::get('/svehicle_type', [SettingController::class, 'vehicle_type']);

Route::get('/transmission', [SettingController::class, 'transmission']);

Route::get('/drive', [SettingController::class, 'drive']);

Route::get('/exterior_color', [SettingController::class, 'exterior_color']);

Route::get('/interior_grade', [SettingController::class, 'interior_grade']);

Route::get('/exterior_grade', [SettingController::class, 'exterior_grade']);

Route::get('/status', [SettingController::class, 'status']);

Route::get('/condition', [SettingController::class, 'condition']);




// These should be grouped or follow REST convention
Route::prefix('settings')->group(function () {
    Route::get('/', [SettingController::class, 'index']); // Optional: get all settings
    Route::post('/', [SettingController::class, 'store']);
    Route::put('/{id}', [SettingController::class, 'update']);
    Route::delete('/{id}', [SettingController::class, 'destroy']);
});
