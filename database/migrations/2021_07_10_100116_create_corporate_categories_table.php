<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',['Corporate Course','Corporate Exam','Both']);
            $table->string('category_name',150);
            $table->string('slug')->unique()->nullable();
            $table->text('description');
            $table->string('cover_image');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('corporate_categories');
    }
}
