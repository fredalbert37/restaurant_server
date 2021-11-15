<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Local\LocalController;
use App\Http\Controllers\Meals\MealsController;
use App\Http\Controllers\Menu\MenuController;
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
Route::prefix('/')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('edit_user', [AuthController::class, 'editUser']);
    
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    /***RESTAURANT****/
    Route::prefix('restaurants')->group(function () {
        Route::get("/", [RestaurantController::class, 'index']);
        Route::post("/search_ruc", [RestaurantController::class, 'search_ruc']);
        Route::post("/store", [RestaurantController::class, 'store']);
        Route::put("/update", [RestaurantController::class, 'update']);
        Route::delete("/", [RestaurantController::class, 'delete']);
    });
    
    
    //LOCALES
    Route::prefix('locals')->group(function (){
        $c = LocalController::class;
        Route::get("/", [$c, 'index']);
        Route::post("/store", [$c, 'store']);
        Route::put("/update", [$c, 'update']);
        Route::delete("/", [$c, 'delete']);
    });

    //PLATILLOS
    Route::prefix('meals')->group(function (){
        $c = MealsController::class;
        Route::get('/', [$c, 'index']);
        Route::post('/store', [$c, 'store']);
        Route::put('/update', [$c, 'update']);
        Route::delete('/delete', [$c, 'delete']);
        Route::put('/status', [$c, 'SetStatus']);
    }); 

    //MENU
    Route::prefix('menu')->group(function (){
        $c = MenuController::class;
        Route::get('/', [$c, 'index']);
        Route::post('/store', [$c, 'store']);
        Route::put('/update', [$c, 'update']);
        Route::delete('/delete', [$c, 'delete']);
    });


    //MESAS
    



        /*****QR*****/





        
        
        
        
    //PLATILLOS (DEBE HABER DISPONIBILIDAD



    //DEL PLATILLO PONER UN ATRIBUTO PARA ACTIVAR O NO EL PLATILLO SEGUN DISPONIBILIDAD)
        
        
    //CARRITO DE COMPRAS





});

