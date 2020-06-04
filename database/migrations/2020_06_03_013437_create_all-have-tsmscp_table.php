<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllHaveTsmscpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
            Schema::create('all-have-tsmscp', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_teacher');
                $table->unsignedBigInteger('id_section');
                $table->unsignedBigInteger('id_matter');
                $table->unsignedBigInteger('id_schedule');
                $table->unsignedBigInteger('id_classroom');
                $table->unsignedBigInteger('id_period');
               

                $table->foreign('id_teacher') 
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');  

                $table->foreign('id_section')
                    ->references('id')
                    ->on('section')
                    ->onDelete('cascade');
                
                $table->foreign('id_matter')
                    ->references('id')
                    ->on('matter')
                    ->onDelete('cascade');  

                $table->foreign('id_schedule')
                    ->references('id')
                    ->on('schedule')
                    ->onDelete('cascade');
                
                $table->foreign('id_classroom')
                    ->references('id')
                    ->on('classroom')
                    ->onDelete('cascade');  

                $table->foreign('id_period')
                    ->references('id')
                    ->on('period')
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
         Schema::dropIfExists('all-have-tsmscp');
    }
}
