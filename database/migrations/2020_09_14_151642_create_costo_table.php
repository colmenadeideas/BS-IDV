<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('monto');
            $table->integer('semestre');
            $table->unsignedBigInteger('id_carrera');
            

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
        Schema::dropIfExists('costo');
    }
}
