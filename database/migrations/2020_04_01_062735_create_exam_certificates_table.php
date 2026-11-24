<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('certificate_id');
            $table->integer('student_exam_id')->unsigned();
            $table->string('student_name');
            $table->string('center_name');
            $table->string('exam_name');
            $table->string('result',10);
            $table->datetime('date_of_awarded')->nullable();
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
        Schema::dropIfExists('exam_certificates');
    }
}
