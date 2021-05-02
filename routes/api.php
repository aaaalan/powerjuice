<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Locations REST */
Route::get('locations', [LocationController::class,'index']);
Route::get('locations/{zipcode}', [LocationController::class,'findByZipcode']);
Route::get('locations/checkzipcode/{zipcode}', [LocationController::class,'checkZipcode']);
Route::get('/locations/search/{searchTerm}', [LocationController::class, 'findBySearchTerm']);
Route::delete('locations/{id}', [LocationController::class,'delete']);
Route::put('locations/{id}', [LocationController::class,'update']);
Route::post('locations', [LocationController::class,'save']);

/* Users REST */
Route::put('users/{id}', [UserController::class,'update']);
Route::get('users', [UserController::class,'index']);
Route::delete('users/{id}', [UserController::class,'delete']);
Route::post('users', [UserController::class,'save']);


/* Vaccinations REST */

Route::get('vaccinations', [VaccinationController::class,'index']);
Route::post('vaccinations', [VaccinationController::class,'save']);
Route::put('vaccinations/{id}', [VaccinationController::class,'update']);
Route::delete('vaccinations/{id}', [VaccinationController::class,'delete']);
