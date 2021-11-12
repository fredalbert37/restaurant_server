<?php

namespace App\Http\Requests\Local;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocalRequest extends FormRequest
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
    public static function rules($local = null)
    {
        return [
            'name' => ["required"],
            'restaurant_id' => ["required"],
            'local_address' => ["required"],
        ];
    }
    
    /**
     * Get the validation message that apply to the rules.
     *
     * @return array
     */
    public static function message()
    {
        return [
            'name.required' => "El nombre no puede ser vacío",
            'restaurant_id.required' => "Debe seleccionar restaurante",
            'local_address.required' => "La dirección es obligatoria"
        ];
    }




}
