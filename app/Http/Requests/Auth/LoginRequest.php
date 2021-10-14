<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
    public static function rules()
    {
        return [
            'email' => "required|email",
            'password' => "required"
        ];
    }

    public static function message()
    {
        return [
            'email.required' => "El email no puede ser vacío",
            'email.email' => "Ingresa el email correctamente",
            'password.required' => "Ingresa la contraseña correctamente"
        ];
    }
}
