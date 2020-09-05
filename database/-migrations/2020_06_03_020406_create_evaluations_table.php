<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_matter');
            $table->unsignedBigInteger('id_student');
            $table->integer('note')->unsigned();
            $table->integer('percentage')->unsigned();
            $table->string('description',250);

            $table->foreign('id_matter')
                    ->references('id')
                    ->on('matter')
                    ->onDelete('cascade'); 

            $table->foreign('id_student')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('evaluations');
    }
}
