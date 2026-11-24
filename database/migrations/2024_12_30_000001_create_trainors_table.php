<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainorsTable extends Migration
{
    public function up()
    {
        Schema::create('trainors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('expertise')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainors');
    }
}
