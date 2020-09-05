<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayForTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_for', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cost');
            $table->unsignedBigInteger('id_payments');
            $table->unsignedBigInteger('id_career');
            

            $table->foreign('id_cost')
                    ->references('id')
                    ->on('cost')
                    ->onDelete('cascade');
            $table->foreign('id_payments')
                    ->references('id')
                    ->on('payments')
                    ->onDelete('cascade');
            $table->foreign('id_career')
                    ->references('id')
                    ->on('career')
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
        Schema::dropIfExists('pay_for');
    }
}
