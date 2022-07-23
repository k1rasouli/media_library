<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\MediaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where web routes of application are registered. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/
/**
 * Global routes
 */
Route::controller(HomeController::class)->group(function (){
    Route::get('/',  'index')->name('HomeIndex');
    Route::post('/login', 'login')->name('HomeLogin');
    Route::post('/logout', 'logout')->name('HomeLogout');
});

/**
 * Auth required routes
 */
Route::middleware('auth')->group(function (){
    /**
     * Index admin page contains a form to add media and list of added media
     */
    Route::controller(AdminController::class)->group(function (){
        Route::get('/admin', 'index')->name('AdminIndex');
    });

    /**
     * Controller grouping is new to laravel 9. Here is CategoriesController web routes
     */
    Route::controller(CategoriesController::class)->group(function (){
       Route::get('/admin/categories', 'index')->name('CategoriesIndex');
       Route::post('/admin/categories', 'store')->name('CategoriesStore');
       Route::get('/admin/category/{category:slug}', 'show')->name('CategoriesShow');
       Route::patch('/admin/category/{category}', 'update')->name('CategoriesUpdate');
       Route::delete('/admin/category/{category}', 'destroy')->name('CategoriesDestroy');
    });

    /**
     * MediaController web routes
     */
    Route::controller(MediaController::class)->group(function (){
       Route::post('/admin/media', 'store')->name('MediaStore');
       Route::get('/admin/media/{media}', 'show')->name('MediaShow');
       Route::patch('/admin/media/{media}', 'update')->name('MediaUpdate');
       Route::delete('/admin/media/{media}', 'destroy')->name('MediaDestroy');
    });
});
