<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_channels', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('study_id');
            $table->foreign('study_id')->on('studies')->references('id')->onDelete('cascade');

            $table->string('name')->index();
            $table->string('token')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_channels');
    }
}
