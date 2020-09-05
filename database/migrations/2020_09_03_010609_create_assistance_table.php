<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description',250);
            $table->enum('status',['attend','absent','does not apply']);
            $table->unsignedBigInteger('id_lesson');

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
        Schema::dropIfExists('assistance');
    }
}
