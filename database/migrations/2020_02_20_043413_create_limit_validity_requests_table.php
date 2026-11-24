<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitValidityRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limit_validity_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('center_online_courses_id')->unsigned();
            $table->date('old_validity')->nullable();
            $table->integer('old_limit')->unsigned()->default(0);
            $table->date('new_validity')->nullable();
            $table->integer('new_limit')->unsigned()->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('limit_validity_requests');
    }
}
