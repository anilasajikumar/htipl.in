<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_exam_id')->unsigned();
            $table->text('question')->nullable();
            $table->string('option_a')->default('');
            $table->string('option_b')->default('');
            $table->string('option_c')->default('');
            $table->string('option_d')->default('');
            $table->char('answer',1)->default('A');
            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();

            $table->foreign('course_exam_id')->references('id')->on('course_exams')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
