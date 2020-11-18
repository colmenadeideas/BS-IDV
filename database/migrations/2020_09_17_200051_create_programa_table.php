<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_periodo');
            //$table->date('fecha_inicio');
            //$table->date('fecha_fin');
            $table->string('dias',50)->nullable();
            
            $table->foreign('id_materia') 
                    ->references('id')
                    ->on('materia')
                    ->onDelete('cascade');

            $table->foreign('id_periodo') 
                    ->references('id')
                    ->on('periodo')
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
        Schema::dropIfExists('programa');
    }
}
