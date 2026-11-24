<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->string('course_name',150);
            $table->string('slug')->unique()->nullable();
            $table->text('course_description');
            $table->integer('course_duration')->unsigned()->default(0);
            $table->double('course_fee',10,2)->default(0.0);
            $table->tinyInteger('status')->default(1);
            $table->string('pdf')->nullable();
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();

            $table->foreign('category_id')->references('id')->on('corporate_categories')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corporate_courses');
    }
}
