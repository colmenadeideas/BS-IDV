<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensumHasMatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pensum_has_matter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_pensum');
            $table->unsignedBigInteger('id_matter');


            $table->foreign('id_pensum')
                ->references('id')
                ->on('pensum')
                ->onDelete('cascade');

            $table->foreign('id_matter')
                ->references('id')
                ->on('matter')
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
        Schema::dropIfExists('pensum_has_matter');
    }
}
