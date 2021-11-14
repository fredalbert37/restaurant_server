<?php

namespace App\Http\Controllers\Meals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meals\MealRequest;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealsController extends Controller
{
     /**
     * @return Meal::class
     * RETURN A LIST OF Meals
     */

    public function index(){
        //verificando que los platillos buscados tengan activo el paremetro active
        $restaurant = Meal::where('active', 1)->with('locals')->with('restaurants')->get();

        return response()->json($restaurant, 200);
    }


    /**
     * @return string
     * RESPONSE HTTP:200 RETURN A JSON HTTP_OK FOR THE RIGTH CREATION OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON ERRORS ARRAY AND AN HTTP_ERROR FROM THE SERVER
     */

    public function store(Request $request){

        //validando el request que llega del front end
        $validate = Validator::make(
            $request->all(),
            MealRequest::rules(),
            MealRequest::message() 
        );

        //si la validacion falla devolver los errores del server con codigo HTTP::ERROR
        if($validate->fails()){
           return response()->json($validate->errors(), 500); 
        }

        //intenter realizar la insercion en la base de datos
        try {
            //guardando el platillo con todos los campos que se necesitan
            $r = new Meal();
            $r->name = strtoupper($request->name);
            $r->local_id = $request->local_id;
            $r->restaurant_id = $request->restaurant_id;
            $r->price = $request->price;
            $r->description = $request->description;
            $r->save();

        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha creado el platillo", 201);
    }


    /**
     * @return string
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH UPDATE OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON ERRORS ARRAY AND AN  HTTP_ERROR FROM THE SERVER 
     */
    public function update(Request $request){
        $validate = Validator::make(
            $request->all(),
            MealRequest::rules($request->id),
            MealRequest::message() 
        );

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        try {
            //guardando el platillo con todos los campos que se necesitan
            $r = Meal::find($request->id);
            $r->name = strtoupper($request->name);
            $r->local_id = $request->local_id;
            $r->restaurant_id = $request->restaurant_id;
            $r->price = $request->price;
            $r->description = $request->description;
            $r->save();

        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha actualizado el platillo", 200);

    }

    /**
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH DEACTIVATION OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON HTTP_ERROR FROM THE SERVER
     */
    public function delete(Request $request){
        $r = Meal::find($request->id);
        $r->active = 0;
        $r->save();

        return response()->json("Se ha eliminado el platillo");
    }
}
