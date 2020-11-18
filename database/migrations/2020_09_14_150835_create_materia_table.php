<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',100);
            $table->string('slug',100);
            $table->string('codigo',50);
            $table->string('descripcion',250);
            $table->enum('status',['activo','inactivo'])->default('activo');
            $table->integer('semestre')->unsigned();
            $table->integer('h_teorica')->unsigned();
            $table->integer('h_practica')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materia');
    } 
}
