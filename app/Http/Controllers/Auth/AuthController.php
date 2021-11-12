<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //registro de usuarios
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
            $user->role = isset($request->role) ? $request->role : "user";
            $user->save();
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }

        return response()->json("El usuario fue registrado!", 201);
    }

    //funcion para editar usuario
    public function editUser(Request $request){
        $validate = Validator::make(
            $request->all(),
            AuthRequest::rules($request->id),
            AuthRequest::message()
        );

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }
        
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->doc_type = $request->doc_type;
            $user->doc_number = $request->doc_number;
            $user->restaurant_id = $request->restaurant_id;
            $user->role = isset($request->role) ? $request->role : "user";
            $user->save();
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }

        return response()->json("El usuario fue actualizado!", 200);
    }





    //login de usuarios
    public function login(Request $request){
        $credentials  = $request->only('email', 'password');
        $validate = Validator::make(
            $credentials,
            LoginRequest::rules(),
            LoginRequest::message()
        );

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        if(!Auth::attempt($credentials)){
            return response()->json('Usuario no autorizado', 500);
        }

        $user = User::where('email', $request->email)->first();

        if(!Hash::check($request->password, $user->password)){
            return response()->json("Contraseña incorrecta", 400);
        }

        $role = "admin";
        $tokenResult = $user->createToken('authToken', [$role])->plainTextToken;
        
        return response()->json([
            'token' => "Bearer $tokenResult",
            'user' => $user
        ], 200);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            "Logget Out",
            200
        );
    }


}
