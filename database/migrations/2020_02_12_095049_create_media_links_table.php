<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_media_id')->unsigned();
            $table->string('title')->nullable()->default('');
            $table->string('video_url')->nullable();
            $table->string('video_type',32)->nullable()->default('');
            $table->Integer('order')->nullable();
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
        Schema::dropIfExists('media_links');
    }
}
