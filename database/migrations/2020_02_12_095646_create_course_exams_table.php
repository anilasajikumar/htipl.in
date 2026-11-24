<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_id')->unsigned();
            $table->string('exam_name');
            $table->text('exam_description');
            $table->integer('total_questions')->unsigned()->default(0);
            $table->integer('total_time')->unsigned()->comment('duration in minute'); 
            $table->double('total_marks',10,2)->unsigned()->default(0.00);
            $table->double('mark_per_question',10,2)->unsigned()->default(0.00);
            $table->double('minus_mark_per_question',10,2)->unsigned()->default(0.00);
            $table->double('pass_mark',10,2)->unsigned()->default(0.00);
            $table->tinyInteger('status')->default(1);
            $table->string('answer_key')->default('');
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();

            $table->foreign('course_id')->references('id')->on('online_courses')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_exams');
    }
}
