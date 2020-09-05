<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscription', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_student');
            $table->unsignedBigInteger('id_period');
            $table->unsignedBigInteger('id_payments')->nullable();
            $table->enum('status',['completed','cancel','pending','started']);
            $table->integer('semester');


            $table->foreign('id_student')
                    ->references('id')
                    ->on('student')
                    ->onDelete('cascade');

             $table->foreign('id_period')
                    ->references('id')
                    ->on('period')
                    ->onDelete('cascade');
                   
             $table->foreign('id_payments')
                    ->references('id')
                    ->on('payments')
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
        Schema::dropIfExists('inscription');
    }
}
