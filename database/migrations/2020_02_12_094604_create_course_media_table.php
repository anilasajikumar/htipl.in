<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_module_id')->unsigned();
            $table->text('course_media_description');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();

            $table->foreign('course_module_id')->references('id')->on('course_modules')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_media');
    }
}
