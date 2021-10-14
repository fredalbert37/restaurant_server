<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = "restaurant";


    public function locals() {
        return $this->hasMany(Local::class, 'restaurant_id');
    }

    public function users(){
        return $this->hasOne(Users::class, 'restaurant_id');
    }

}