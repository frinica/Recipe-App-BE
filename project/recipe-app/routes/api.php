<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomListController;
use App\Models\CustomList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//Protected routes
Route::group([
    'middleware' => 'auth:sanctum'], function() {
    //User routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'userData']);

    //List routes
    Route::post('store-list', [CustomListController::class, 'store']);
    Route::get('lists-view', [CustomListController::class, 'getAll']);
    Route::get('list-view/{id}', [CustomListController::class, 'getByID']);
    Route::put('update-list/{id}', [CustomListController::class, 'update']);
    Route::delete('delete-list/{id}', [CustomListController::class, 'destroy']);

});