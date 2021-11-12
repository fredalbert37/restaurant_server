<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($user_id = null)
    {
        return [
            'name' => ["required"],
            'lastname' => ["required"],
            'doc_type' => ['required',Rule::in(["CE", "DNI"])],
            'doc_number' =>
                [
                    "required", 
                    Rule::unique('users')->ignore($user_id)
                ],
            'email' => "required", "email",
            'password' => "required", "confirmed",
            // 'restaurant_id' => "required",
        ];
    }

    public static function message(){
        return [
            'name.required' => 'El nombre no puede ser vacio',
            'lastname.required' => 'El apellido no puede ser vacio',
            'doc_type.in' => 'Tiene que ser DNI o Carnet de Extranjeria',
            'doc_type.required' => 'Elija un tipo de documento',
            'doc_number.required' => 'El numero de documento no puede ser vacio',
            'doc_number.unique' => 'El numero de documento ya existe',
            'email.required' => 'El email no puede ser vacio',
            'email.email' => 'El email no tiene el formato correcto',
            'password.required' => 'La contraseña no puede ser vacia',
            'password.confirmed' => 'La contraseña debe ser confirmada',
            // 'restaurant_id.required' => 'Se debe asignar un restaurante' 
        ];
    }

}
