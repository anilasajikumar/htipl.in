<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('certificate_id');
            $table->integer('exam_marks_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->string('student_name');
            $table->string('center_name');
            $table->string('course_name');
            $table->datetime('date_of_awarded');
            $table->double('total_mark_scored',10,2);
            $table->double('total_mark',10,2)->nullable();
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
        Schema::dropIfExists('certificates');
    }
}
