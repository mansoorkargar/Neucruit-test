<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_analytics', function (Blueprint $table) {
            $table->id();

            $table->string('session_id')->index();
            $table->string('action')->index();
            
            $table->unsignedBigInteger('study_id');
            $table->foreign('study_id')->on('studies')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('participant_id')->index();
            $table->foreign('participant_id')->on('participants')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('channel_id')->index();
            $table->foreign('channel_id')->on('study_channels')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('study_analytics');
    }
}
