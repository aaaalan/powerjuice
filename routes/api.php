<?php

use App\Http\Controllers\AuthController;
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
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('locations', [LocationController::class, 'index']);
Route::get('locations/zip/{zipcode}', [LocationController::class, 'findByZipcode']);
Route::get('locations/{id}', [LocationController::class, 'findById']);
Route::get('locations/checkzipcode/{zipcode}', [LocationController::class, 'checkZipcode']);
Route::get('/locations/search/{searchTerm}', [LocationController::class, 'findBySearchTerm']);
Route::get('vaccinations/{id}', [VaccinationController::class, 'findById']);
Route::get('vaccinations', [VaccinationController::class, 'index']);
Route::get('vaccinations/getLocationName/{id}', [VaccinationController::class, 'getLocationNameFromVaccination']);

/*  REST Calls with Authentication */
Route::group(['middleware' => ['api', 'auth.jwt']], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
});
    /* Locations REST */
    Route::delete('locations/{id}', [LocationController::class, 'delete']);
    Route::put('locations/{id}', [LocationController::class, 'update']);
    Route::post('locations', [LocationController::class, 'save']);

    /* Users REST */
    Route::get('users', [UserController::class, 'index']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'delete']);
    Route::post('users', [UserController::class, 'save']);

    /* Vaccinations REST */
    Route::post('vaccinations', [VaccinationController::class, 'save']);
    Route::put('vaccinations/{id}', [VaccinationController::class, 'update']);
    Route::delete('vaccinations/{id}', [VaccinationController::class, 'delete']);

