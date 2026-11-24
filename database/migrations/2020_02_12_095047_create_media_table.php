<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_media_id')->unsigned();
            $table->string('title')->nullable()->default('');
            $table->string('file_name')->default('');
            $table->string('thumbnail')->default('');
            $table->string('file_path');
            $table->string('mime_type',32)->nullable()->default('');
            $table->string('extension',20)->nullable()->default('');
            $table->enum('type',['video','image','document'])->nullable();
            $table->string('size',20)->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: inactive, 1: active, 2:Draft');
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();

            $table->foreign('course_media_id')->references('id')->on('course_media')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
