<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('pensum', function (Blueprint $table) {

        $table->bigIncrements('id');
        $table->date('start_date');
        $table->date('end_date');
        $table->enum('status',['active','inactive']);
        $table->text('matters');
        $table->string('caree',100);
        $table->string('description',250);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pensum');
    }
}
