<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $table = "locals";

    public function restaurant(){
        return $this->belongsTo(Restaurant::class, "restaurant_id");
    }

    public function meals(){
        return $this->hasMany(Meal::class, "local_id");
    }


}
