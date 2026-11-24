<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('study_center_id',20)->unique();
            $table->string('study_center_name',100);
            $table->string('study_center_contact_person',100);
            $table->string('study_center_email')->unique();
            $table->string('password')->nullable();
            $table->string('study_center_mobile',20);
            $table->string('study_center_address');
            $table->string('pincode',15);
            $table->bigInteger('location_id')->unsigned();
            $table->string('logo');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->DateTime('deleted_at')->nullable();

            $table->foreign('location_id')->references('id')->on('locations')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centers');
    }
}
