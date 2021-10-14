<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Restaurant\RestaurantController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/***AUTH***/
Route::prefix('auth')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
});


/***RESTAURANT****/
Route::prefix('restaurants')->group(function () {
    Route::get("/", [RestaurantController::class, 'index']);
    Route::post("/store", [RestaurantController::class, 'store']);
    Route::put("/update", [RestaurantController::class, 'update']);
    Route::delete("/", [RestaurantController::class, 'delete']);
});
