<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RestaurantRequest extends FormRequest
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
    public static function rules($restaurant_id = null)
    {
        return [
            'name' => ["required"],
            'ruc' => 
                ["required","integer","min:11", 
                 Rule::unique('restaurants')->ignore($restaurant_id)
                ],
            'address' => ["required"],
        ];
    }

    public static function message(){
        return[
            'name.required' => "El nombre no puede ser vacio",
            'ruc.required' => "El ruc no puede ser vacio",
            'ruc.numeric' => "El ruc tiene que ser un numero de 11 digitos",
            'ruc.min' => "El ruc tiene que ser un numero de 11 digitos",
            'ruc.unique' => "El ruc indicado ya existe",
            "address.required" => "La direccion no puede ser vacia"
        ];
    }


}
