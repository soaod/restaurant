<?php

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

Route::post('login', [\App\Http\Controllers\API\AuthController::class, "login"]);


Route::group(["prefix" => "tables", "as" => ".tables", "middleware" => ["auth:api", "adminOnly"]], function () {
    Route::get('/', [\App\Http\Controllers\API\TableController::class, "index"])
        ->name("index");

    Route::post('/store', [\App\Http\Controllers\API\TableController::class, "store"])
        ->name("store");

    Route::delete('/{table}/delete', [\App\Http\Controllers\API\TableController::class, "destroy"])
        ->name("delete");
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
