<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menus";


    public function locals(){
        return $this->belongsTo(Locals::class, "local_id");
    }

    public function restaurants(){
        return $this->belongsTo(Restaurant::class, "restaurant_id");
    }

    public function meals(){
        return $this->hasMany(Meal::class, "menu_id");
    }



}
