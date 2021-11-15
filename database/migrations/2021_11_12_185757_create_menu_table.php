<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id(); //id del menu
            $table->string("name")->nullable(); //nombre del menu, por defecto seria el nombre del local
            $table->bigInteger("local_id")->unsigned(); //id del local al cual pertenece el menu
            $table->bigInteger("restaurant_id")->unsigned(); //id del restaurante
            $table->smallInteger("active")->default(1); // si el menu esta activo o inactivo
            $table->foreign("local_id")->references('id')->on('locals');
            $table->foreign("restaurant_id")->references('id')->on('restaurants');
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
        Schema::dropIfExists('menus');
    }
}
