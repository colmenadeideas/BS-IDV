<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('asistencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion',250);
            $table->enum('status',['presente','inasistente','no aplica']);
            $table->unsignedBigInteger('id_clase');

            $table->foreign('id_clase')
                    ->references('id')
                    ->on('clase')
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
        Schema::dropIfExists('asistencia');
    }
}
