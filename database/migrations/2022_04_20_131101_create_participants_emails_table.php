<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateParticipantsEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->on('participants')->references('id')->on('participants')->onDelete('cascade');
            $table->unsignedBigInteger('study_id');
            $table->foreign('study_id')->on('studies')->references('id')->on('studies')->onDelete('cascade');
            $table->unsignedBigInteger('email_type_id');
            $table->foreign('email_type_id')->on('participants_email_types')->references('id')->on('participants_email_types')->onDelete('cascade');
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
        Schema::dropIfExists('participant_emails');
    }
}
