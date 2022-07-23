<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\api\v1\CategoriesController;
use \App\Http\Controllers\api\v1\AuthController;
use \App\Http\Controllers\api\v1\MediaController;
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here is where API(v1) routes of application are registered. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/
/**
 * Since this app is designed for web call of api, sanctum is not configured
 */
/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/**
 * The only auth route is for login. Users can be added with
 */
Route::post('/login', [AuthController::class, 'login'])->name('ApiAuthLogin');
/**
 * Entire category routes are called with api resource except show. That's because show uses slug to retrieve category data
 */
Route::apiResource('categories', CategoriesController::class)->except(['show']);
Route::get('/categories/{category:slug}', [CategoriesController::class, 'show'])->name('categories.show');

/**
 * Entire media routes are called with api resource
 */
Route::apiResource('media', MediaController::class);
