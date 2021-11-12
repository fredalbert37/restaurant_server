<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id(); //id del restaurante
            $table->string("restaurant_name"); //nombre del restaurante
            $table->string("ruc"); //ruc del restaurante
            $table->string("address")->nullable(); // la direccion de la sede
            $table->integer("phone")->nullable(); // el telefono principal del restaurante
            $table->smallInteger("active")->default(1); //verifica si el restaurante esta activo en el sistema
            $table->date('contract_date')->nullable(); //es la fecha de contrato del restaurante.
            $table->timestamps(); // created_at y updated_at de cada fila
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
