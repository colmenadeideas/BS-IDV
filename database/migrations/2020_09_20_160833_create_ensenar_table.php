<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnsenarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ensenar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_inscripcion');
            $table->unsignedBigInteger('id_grupo');
            $table->unsignedBigInteger('id_evaluacion');
            $table->unsignedBigInteger('id_profesor');
            $table->unsignedBigInteger('id_clase');

            $table->foreign('id_inscripcion')
                    ->references('id')
                    ->on('inscripcion')
                    ->onDelete('cascade');

            $table->foreign('id_profesor')
                    ->references('id')
                    ->on('profesor')
                    ->onDelete('cascade');

            $table->foreign('id_grupo')
                    ->references('id')
                    ->on('grupo')
                    ->onDelete('cascade');

            $table->foreign('id_evaluacion')
                    ->references('id')
                    ->on('evaluacion')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('ensenar');
    }
}
