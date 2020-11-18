<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_periodo');
            $table->unsignedBigInteger('id_pagos')->nullable();
            $table->enum('status',['completada','cancelada','pendiente','iniciada']);
            $table->integer('semestre');


            $table->foreign('id_estudiante')
                    ->references('id')
                    ->on('estudiante')
                    ->onDelete('cascade');

             $table->foreign('id_periodo')
                    ->references('id')
                    ->on('periodo')
                    ->onDelete('cascade');
                   
             $table->foreign('id_pagos')
                    ->references('id')
                    ->on('pagos')
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
        Schema::dropIfExists('inscripcion');
    }
}
