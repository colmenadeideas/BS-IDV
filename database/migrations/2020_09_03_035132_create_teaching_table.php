<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_inscription');
            $table->unsignedBigInteger('id_group');
            $table->unsignedBigInteger('id_evaluation');
            $table->unsignedBigInteger('id_teacher');
            $table->unsignedBigInteger('id_lesson');

            $table->foreign('id_inscription')
                    ->references('id')
                    ->on('inscription')
                    ->onDelete('cascade');

            $table->foreign('id_teacher')
                    ->references('id')
                    ->on('teacher')
                    ->onDelete('cascade');

            $table->foreign('id_group')
                    ->references('id')
                    ->on('group')
                    ->onDelete('cascade');

            $table->foreign('id_evaluation')
                    ->references('id')
                    ->on('evaluation')
                    ->onDelete('cascade');

            $table->foreign('id_lesson')
                    ->references('id')
                    ->on('lesson')
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
        Schema::dropIfExists('teaching');
    }
}
