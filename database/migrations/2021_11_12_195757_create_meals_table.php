<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            
            $table->string('name'); //indica el nombre del platillo
            
            $table->bigInteger('local_id')->unsigned(); //indica el id del local al cual pertenece dicho platillo
            
            $table->bigInteger('restaurant_id')->unsigned(); // indica el id del restaurante de dicho platillo
            
            $table->bigInteger('menu_id')->unsigned()->nullable(); // indica el id del menu de dicho platillo -
            
            $table->string("category");//categoria del platillo (SI ES A LA ASADOS, SI ES FRITOS, SI ES COMBO, PACK, ETC)
            
            $table->decimal('price', 8, 2); // indica el precio unitario del platillo (2 decimales)
            
            $table->text('description'); //indica la descripcion del platillo (ingredientes y especificaciones)
            
            $table->smallInteger('active')->default(1); // indica si el platillo esta activo o no (si se ha borrado)
            
            $table->smallInteger('status')->default(1); //indica si el platillo se sirve hoy o no
            
            $table->foreign("local_id")->references("id")->on("locals"); //llave foranea de local
            
            $table->foreign("restaurant_id")->references("id")->on("restaurants"); //llave foranea de restaurante
            
            $table->foreign("menu_id")->references("id")->on("menus"); //llave foranea de menu
            
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
        Schema::dropIfExists('meals');
    }
}
