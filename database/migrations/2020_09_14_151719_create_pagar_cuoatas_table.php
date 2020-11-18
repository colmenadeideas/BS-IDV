<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagarCuoatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagar_coutas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_costo');
            $table->unsignedBigInteger('id_pagos');
            $table->unsignedBigInteger('id_carrera');
            

            $table->foreign('id_costo')
                    ->references('id')
                    ->on('costo')
                    ->onDelete('cascade');
            $table->foreign('id_pagos')
                    ->references('id')
                    ->on('pagos')
                    ->onDelete('cascade');
            $table->foreign('id_carrera')
                    ->references('id')
                    ->on('carrera')
                    ->onDelete('cascade');
                     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagar_cuoatas');
    }
}
