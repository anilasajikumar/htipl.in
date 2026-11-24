<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDocumentDatasTable extends Migration
{
    public function up()
    {
        Schema::create('master_document_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->tinyInteger('text')->default(0);
            $table->tinyInteger('file')->default(0);
            $table->tinyInteger('download')->default(0);
            $table->tinyInteger('student_upload')->default(0);
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('category')->nullable();
            $table->text('default_file')->nullable();
            $table->tinyInteger('student_download_default_file')->default(0);
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_document_datas');
    }
}
