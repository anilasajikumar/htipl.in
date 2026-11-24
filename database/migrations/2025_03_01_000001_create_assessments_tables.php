<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTables extends Migration
{
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainor_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->tinyInteger('is_published')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('trainor_id')->references('id')->on('trainors')->onDelete('set null');
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->text('question_text');
            $table->string('question_type')->default('mcq'); // mcq, text
            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->string('correct_answer')->nullable();
            $table->integer('marks')->default(1);
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
        });

        Schema::create('student_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_course_id');
            $table->unsignedBigInteger('assessment_id');
            $table->string('status')->default('pending'); // pending, started, submitted, evaluated
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->decimal('score', 8, 2)->nullable();
            $table->decimal('total_marks', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('student_assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_assessment_id');
            $table->unsignedBigInteger('assessment_question_id');
            $table->text('answer')->nullable();
            $table->timestamps();
            $table->foreign('student_assessment_id')->references('id')->on('student_assessments')->onDelete('cascade');
            $table->foreign('assessment_question_id')->references('id')->on('assessment_questions')->onDelete('cascade');
        });

        Schema::create('assessment_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_assessment_id');
            $table->unsignedBigInteger('trainor_id')->nullable();
            $table->text('comments')->nullable();
            $table->string('grade')->nullable();
            $table->decimal('score_override', 8, 2)->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();
            $table->foreign('student_assessment_id')->references('id')->on('student_assessments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_evaluations');
        Schema::dropIfExists('student_assessment_answers');
        Schema::dropIfExists('student_assessments');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessments');
    }
}
