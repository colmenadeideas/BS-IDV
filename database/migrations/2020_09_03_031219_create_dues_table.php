<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_payments');
            $table->float('amount');
            $table->enum('status',['approved','rejected','pending']);
            $table->string('description',250)->nullable();
            
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
        Schema::dropIfExists('dues');
    }
}
