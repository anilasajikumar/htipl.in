<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCenterOnlineCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('center_online_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('center_id')->unsigned();
            $table->date('validity');
            $table->integer('limit')->unsigned()->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();

            $table->foreign('course_id')->references('id')->on('online_courses')->ondelete('cascade');
            $table->foreign('center_id')->references('id')->on('centers')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('center_online_courses');
    }
}
