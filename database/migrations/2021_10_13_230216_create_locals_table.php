<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locals', function (Blueprint $table) {
            $table->id(); //id del local
            $table->string("local"); //indica la sede donde se encuentra el restaurante
            $table->string("local_address"); // la direccion de la sede
            $table->integer("local_phone")->nullable(); // el telefono de la sede del restaurante
            $table->smallInteger("active")->default(1); //verifica si la sede esta activa o no en el sistema
            $table->bigInteger("restaurant_id")->unsigned(); //id del restaurante al cual pertenece el local
            $table->foreign("restaurant_id")->references("id")->on("restaurants");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locals');
    }
}
