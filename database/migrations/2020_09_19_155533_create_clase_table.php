<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clase', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->date('clase_creada');
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('id_clase_profesor_materia');
            $table->unsignedBigInteger('id_aula')->nullable();
            $table->enum('tipo',['online','presencial']);
            $table->boolean('evaluada')->default(1);
            $table->longText('contenido');
            $table->longText('imagen');


            $table->foreign('id_clase_profesor_materia')
                    ->references('id')
                    ->on('clase_profesor_materia')
                    ->onDelete('cascade');

            $table->foreign('id_aula')
                    ->references('id')
                    ->on('aula')
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
        Schema::dropIfExists('clase');
    }
}
