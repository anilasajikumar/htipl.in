<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_calendars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_name',150);
            $table->date('starting_date')->nullable();
            $table->string('location',150);
            $table->date('exam_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_calendars');
    }
}
