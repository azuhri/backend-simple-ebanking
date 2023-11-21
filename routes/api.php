<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post("v1/register", [APIController::class,"createUser"]);
Route::post("v1/login", [APIController::class,"loginUser"]);

Route::prefix("v1/auth")->middleware("auth:api")->group(function() {
    Route::controller(APIController::class)->group(function() {
        Route::prefix("user")->group(function() {
            Route::put("/","updateUser");
            Route::get("/", "getDataUser");
        });
        Route::prefix("bank-account")->group(function() {
            Route::get("/", "getDataBank");
            Route::put("pin", "changePin");
            Route::post("/transfer", "transferAmount");
            Route::get("/mutations", "getMutation");
        });
    });
});
