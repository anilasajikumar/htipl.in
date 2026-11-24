<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('exam_id')->unsigned();
            $table->integer('center_id')->unsigned();
            $table->enum('center',['In Study Center','Outside Center']);
            $table->text('center_address');
            $table->date('date');
            $table->date('payment_due_date');
            $table->date('closing_date');
            $table->tinyInteger('status')->default(0)->comment('0: pending, 1: active, 2: completed, 3: live');
            $table->tinyInteger('payment_status')->default(0)->comment('0: unpaid, 1: paid');
            $table->enum('result_published',['Yes','No'])->default('No');
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_centers');
    }
}
