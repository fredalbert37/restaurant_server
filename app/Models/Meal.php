<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $table = "meals";

    public function locals() {
        return $this->belongsTo(Local::class, 'restaurant_id')->where('active', 1);
    }

    public function restaurants(){
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }


}
