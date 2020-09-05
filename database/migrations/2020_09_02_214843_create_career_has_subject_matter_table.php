<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerHasSubjectMatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_has_subject_matter', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_subject_matter');
                $table->unsignedBigInteger('id_career');

                $table->foreign('id_subject_matter') 
                    ->references('id')
                    ->on('subject_matter')
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
        Schema::dropIfExists('career_has_subject_matter');
    }
}
