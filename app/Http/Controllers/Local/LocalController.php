<?php

namespace App\Http\Controllers\Local;

use App\Http\Controllers\Controller;
use App\Http\Requests\Local\LocalRequest;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocalController extends Controller
{

    /**
     * @return Local::class
     * RETURN A LIST OF LOCALS
    */
    public function index(){
        //verificando que los locales buscados tengan activo el paremetro active
        $local = Local::where('active', 1)->get();

        return response()->json($local, 200);
    }

    /**
     * @return string
     * RESPONSE HTTP:200 RETURN A JSON HTTP_OK FOR THE RIGTH CREATION OF THE LOCAL
     * RESPONSE HTTP:500 RETURN A JSON ERRORS ARRAY AND AN HTTP_ERROR FROM THE SERVER
     */

    public function store(Request $request){

        //validando el request que llega del front end
        $validate = Validator::make(
            $request->all(),
            LocalRequest::rules(),
            LocalRequest::message() 
        );

        //si la validacion falla devolver los errores del server con codigo HTTP::ERROR
        if($validate->fails()){
           return response()->json($validate->errors(), 500); 
        }

        //intenter realizar la insercion en la base de datos
        try {
            //guardando el resturante con todos los campos que se necesitan
            $l = new Local();
            $l->local = strtoupper($request->name);
            $l->restaurant_id = $request->restaurant_id;
            $l->local_address = $request->local_address;
            $l->local_phone = isset($request->local_phone) ? $request->local_phone : null;
            $l->save();
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha creado el local", 201);
    }


    /**
     * @return string
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH UPDATE OF THE LOCAL
     * RESPONSE HTTP:500 RETURN A JSON ERRORS ARRAY AND AN  HTTP_ERROR FROM THE SERVER 
     */
    public function update(Request $request){
        $validate = Validator::make(
            $request->all(),
            LocalRequest::rules($request->id),
            LocalRequest::message() 
        );

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        try {
            //guardando el local con todos los campos que se necesitan
            $l = Local::find($request->id);
            $l->local = strtoupper($request->name);
            $l->restaurant_id = $request->restaurant_id;
            $l->local_address = $request->local_address;
            $l->local_phone = isset($request->local_phone) ? $request->local_phone : null;
            $l->save();
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha actualizado el local", 200);

    }

    /**
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH DEACTIVATION OF THE LOCAL
     * RESPONSE HTTP:500 RETURN A JSON HTTP_ERROR FROM THE SERVER
     */
    public function delete(Request $request){
        $l = Local::find($request->id);
        $l->active = 0;
        $l->save();

        return response()->json("Se ha eliminado el local");
    }


}
