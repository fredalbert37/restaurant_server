<?php

namespace App\Http\Requests\Meals;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
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
    public static function rules($meal_id = null)
    {
        $rules = [
            "name" => "required",
            "local_id" => "required",
            "restaurant_id" => "required",
            "price" => ["required", "numeric"],
            "description" => "required"
        ];

        return $rules;
    }

    public static function message()
    {
        return [
            "name.required" => "El campo esta vacío",
            "local_id.required" => "Debe seleccionar un local",
            "restaurant_id.required" => "Debe seleccionar un restaurante",
            "price.required" => "El campo esta vacío",
            "price.numeric" => "Datos incorrectos, ingresar precio",
            "description" => "Ingresar una descripción"
        ];
    }
}
