<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->integer('value')->unsigned()->nullable();
            $table->boolean('datetime_auto')->default(false);
            $table->integer('time')->unsigned();
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
        Schema::dropIfExists('services_types');
    }
}
