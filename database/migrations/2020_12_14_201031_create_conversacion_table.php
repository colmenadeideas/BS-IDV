<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->string('nombre',100);
            //$table->string('descripcion',250);
            $table->enum('status',['pendiente','aceptado','rechazado'])->default('pendiente');;
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversacion');
    }
}

