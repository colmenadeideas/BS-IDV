<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectMatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_matter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('code',10);
            $table->string('description',250);
            $table->integer('semester')->unsigned();
            $table->integer('h_theory')->unsigned();
            $table->integer('h_practice')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_matter');
    }
}
