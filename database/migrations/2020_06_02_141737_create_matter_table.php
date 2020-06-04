<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matter', function (Blueprint $table) {
           
            $table->bigIncrements('id');
            $table->string('description',250);
            $table->integer('semester')->unsigned();;
            $table->integer('h_theory')->unsigned();;
            $table->integer('h_practice')->unsigned();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matter');
    }
}
