<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    public function register (Request $request){
        //register new user in database
        $validate = Validator::make(
            $request->all(),
            AuthRequest::rules(),
            AuthRequest::message()
        );

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        //create new user
        try {
            $user = new User();
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->doc_type = $request->doc_type;
            $user->doc_number = $request->doc_number;
            $user->restaurant_id = $request->restaurant_id;
            $user->save();
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }

        return response()->json("El usuario fue registrado!", 200);
    }


}
