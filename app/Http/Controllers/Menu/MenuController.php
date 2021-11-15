<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
     /**
     * @return Menu::class
     * RETURN A LIST OF Menus
     */

    public function index(){
        //verificando que los menus buscados tengan activo el paremetro active
        $menu = Menu::where('active', 1)->with('meals')->with('locals')->with('restaurants')->get();

        return response()->json($menu, 200);
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
            MenuRequest::rules(),
            MenuRequest::message() 
        );

        //si la validacion falla devolver los errores del server con codigo HTTP::ERROR
        if($validate->fails()){
           return response()->json($validate->errors(), 500); 
        }

        //intenter realizar la insercion en la base de datos
        try {
            //guardando el menu con todos los campos que se necesitan
            $m = new Menu();
            $m->name = strtoupper($request->name);
            $m->local_id = $request->local_id;
            $m->restaurant_id = $request->restaurant_id;
            $m->save();

        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha creado el menu", 201);
    }


    /**
     * @return string
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH UPDATE OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON ERRORS ARRAY AND AN  HTTP_ERROR FROM THE SERVER 
     */
    public function update(Request $request){
        $validate = Validator::make(
            $request->all(),
            MenuRequest::rules($request->id),
            MenuRequest::message() 
        );

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        try {
            //guardando el menu con todos los campos que se necesitan
            $m = Menu::find($request->id);
            $m->name = strtoupper($request->name);
            $m->local_id = $request->local_id;
            $m->restaurant_id = $request->restaurant_id;
            $m->save();

        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
        
        //si todo sale bien devolver la respuesta exitosa!
        return response()->json("Se ha actualizado el menu", 200);

    }

    /**
     * RESPONSE HTTP:202 RETURN A JSON HTTP_OK FOR THE RIGTH DEACTIVATION OF THE RESTAURANT
     * RESPONSE HTTP:500 RETURN A JSON HTTP_ERROR FROM THE SERVER
     */
    public function delete(Request $request){
        $m = Menu::find($request->id);
        $m->active = 0;
        $m->save();

        return response()->json("Se ha eliminado el menu", 200);
    }
}
