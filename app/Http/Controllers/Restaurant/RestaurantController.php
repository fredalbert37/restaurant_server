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
     * @return string
     * RESPONSE HTTP:200 RETURN A JSON HTTP_OK FOR THE RIGTH CREATION OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON HTTP_ERROR FROM THE SERVER
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
            $restaurant = new Restaurant();
            $restaurant->name = $request->name;
            $restaurant->ruc = $request->ruc;
            $restaurant->address = $request->address;
            $restaurant->phone = isset($request->phone) ? $request->phone : null;
            $restaurant->save();

        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha creado el restaurante", 200);
    }


    /**
     * @return string
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH UPDATE OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON HTTP_ERROR FROM THE SERVER 
     */
    public function update(){

    }

    /**
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH DEACTIVATION OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON HTTP_ERROR FROM THE SERVER
     */
    public function delete(){

    }



}
