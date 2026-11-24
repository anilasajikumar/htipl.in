<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->enum('type',['Center','ICRQ']);
            $table->string('exam_name',150);
            $table->string('slug')->unique()->nullable();
            $table->text('exam_description');
            $table->integer('register_before_days');
            $table->integer('exam_fee');
            $table->tinyInteger('status')->default(1)->comment('0: pending, 1: active, 2: completed');
            $table->string('pdf')->nullable();
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();
            
            $table->foreign('category_id')->references('id')->on('categories')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
