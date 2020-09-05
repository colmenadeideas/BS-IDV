<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonTeacherMatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_teacher_matter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_lesson');
            $table->unsignedBigInteger('id_subject_matter');
            $table->unsignedBigInteger('id_study_program');
            $table->unsignedBigInteger('id_teacher');
            $table->unsignedBigInteger('id_student');

            $table->foreign('id_lesson')
                    ->references('id')
                    ->on('lesson')
                    ->onDelete('cascade');

            $table->foreign('id_subject_matter')
                    ->references('id')
                    ->on('subject_matter')
                    ->onDelete('cascade');

            $table->foreign('id_study_program')
                    ->references('id')
                    ->on('study_program')
                    ->onDelete('cascade');

            $table->foreign('id_teacher')
                    ->references('id')
                    ->on('teacher')
                    ->onDelete('cascade');

            $table->foreign('id_student')
                    ->references('id')
                    ->on('student')
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
        Schema::dropIfExists('lesson_teacher_matter');
    }
}
