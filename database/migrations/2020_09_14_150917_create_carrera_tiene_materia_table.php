<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraTieneMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera_tiene_materia', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_materia');
                $table->unsignedBigInteger('id_carrera');

                $table->foreign('id_materia') 
                    ->references('id')
                    ->on('materia')
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
        Schema::dropIfExists('carrera_tiene_materia');
    }
}
