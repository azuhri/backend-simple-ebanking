<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", function() {
    return redirect()->route("app");
});


Route::controller(WebController::class)->group(function() {
    Route::get("login", "loginIndex")->name("login");
    Route::post("login", "loginIndex")->name("login.post");
    Route::get("app/{user_id}","appIndex")->name("app");
});

