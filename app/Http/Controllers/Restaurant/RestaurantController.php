<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\RestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /**
     * @return Restaurant::class
     * RETURN A LIST OF RESTAURANTS
     */

    public function index(){
        //verificando que los restaurantes buscados tengan activo el paremetro active
        $restaurant = Restaurant::where('active', 1)->get();

        return response()->json($restaurant, 200);
    }

    /**
     * @return boolean
     * RETURN A BOOLEAN TRUE OR FALSE IF THE RUC EXISTS
     */
    public function search_ruc(Request $request){
        
        $restaurant = Restaurant::where('ruc', $request->ruc)->first();
        
        if(!$restaurant){
            return response()->json(false, 200);
        }

        return response()->json(true, 200);
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
            RestaurantRequest::rules(),
            RestaurantRequest::message() 
        );

        //si la validacion falla devolver los errores del server con codigo HTTP::ERROR
        if($validate->fails()){
           return response()->json($validate->errors(), 500); 
        }

        //intenter realizar la insercion en la base de datos
        try {
            //guardando el resturante con todos los campos que se necesitan
            $r = new Restaurant();
            $r->restaurant_name = strtoupper($request->name);
            $r->ruc = $request->ruc;
            $r->address = $request->address;
            $r->phone = isset($request->phone) ? $request->phone : null;
            $r->save();

        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha creado el restaurante", 201);
    }


    /**
     * @return string
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH UPDATE OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON ERRORS ARRAY AND AN  HTTP_ERROR FROM THE SERVER 
     */
    public function update(Request $request){
        $validate = Validator::make(
            $request->all(),
            RestaurantRequest::rules($request->id),
            RestaurantRequest::message() 
        );

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        try {
            //guardando el resturante con todos los campos que se necesitan
            $r = Restaurant::find($request->id);
            $r->restaurant_name = strtoupper($request->name);
            $r->ruc = $request->ruc;
            $r->address = $request->address;
            $r->phone = isset($request->phone) ? $request->phone : null;
            $r->save();

        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha actualizado el restaurante", 200);

    }

    /**
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH DEACTIVATION OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON HTTP_ERROR FROM THE SERVER
     */
    public function delete(Request $request){
        $r = Restaurant::find($request->id);
        $r->active = 0;
        $r->save();

        return response()->json("Se ha eliminado el restaurante");
    }



}
