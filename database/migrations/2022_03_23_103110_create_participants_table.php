<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_id')->nullable(true);
            $table->foreign('study_id')->references('id')->on('studies');
            $table->string('reference_number');
            $table->unsignedBigInteger('status_id')->nullable(true);
            $table->foreign('status_id')->references('id')->on('participants_statuses');
            $table->integer('age');
            $table->unsignedBigInteger('gender_id')->nullable(true);
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->string('ethnicity');
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
        Schema::dropIfExists('participants');
    }
}
