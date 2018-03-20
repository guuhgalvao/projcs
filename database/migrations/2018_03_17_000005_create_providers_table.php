<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('name', 60);
            $table->string('cnpj', 18)->nullable();
            $table->string('cpf', 14)->nullable();
            $table->string('cep', 9);
            $table->string('address', 60);
            $table->integer('number')->unsigned();
            $table->string('complement', 45);
            $table->string('neighborhood', 60);
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
        Schema::dropIfExists('providers');
    }
}
