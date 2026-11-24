<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('exam_center_id')->unsigned();
            $table->string('register_number',150)->unique();
            $table->string('name');
            $table->string('email');
            $table->string('mobile',16);
            $table->date('dob');
            $table->enum('gender',['male','female','other']);
            $table->mediumText('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->enum('result',['pass','fail'])->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('student_exams');
    }
}
