<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaseProfesorMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clase_profesor_materia', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->enum('turno',['mañana','tarde', 'no aplica'])->default('mañana');
            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_programa');
            $table->unsignedBigInteger('id_profesor');
            //$table->unsignedBigInteger('id_estudiante');


            $table->foreign('id_materia')
                    ->references('id')
                    ->on('materia')
                    ->onDelete('cascade');

            $table->foreign('id_programa')
                    ->references('id')
                    ->on('programa')
                    ->onDelete('cascade');

            $table->foreign('id_profesor')
                    ->references('id')
                    ->on('profesor')
                    ->onDelete('cascade');

            /*$table->foreign('id_estudiante')
                    ->references('id')
                    ->on('estudiante')
                    ->onDelete('cascade');*/
                    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clase_profesor_materia');
    }
}
