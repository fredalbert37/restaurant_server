<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string("lastname")->nullable();
            $table->string("doc_type")->nullable();
            $table->string("doc_number")->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->smallInteger('active')->default(1);
            $table->bigInteger("restaurant_id")->unsigned();
            $table->string("role")->default("user");
            $table->foreign("restaurant_id")->references("id")->on("restaurants");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
