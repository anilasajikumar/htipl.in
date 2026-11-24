<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('exam_id')->unsigned();
            $table->string('register_number');
            $table->smallInteger('correct_answers')->unsigned()->default(0);
            $table->smallInteger('incorrect_answers')->unsigned()->default(0);
            $table->smallInteger('unanswered')->unsigned()->default(0);
            $table->double('mark_scored',10,2)->default(0);
            $table->smallInteger('total_mark')->unsigned()->default(0);
            $table->integer('time_took')->unsigned()->default(0)->comment('Time in seconds');
            $table->integer('total_time')->unsigned()->default(0)->comment('Time in seconds');
            $table->datetime('exam_date')->nullable();
            $table->mediumText('extras')->nullable();
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_marks');
    }
}
