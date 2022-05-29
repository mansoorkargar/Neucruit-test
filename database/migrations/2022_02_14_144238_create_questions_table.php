<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('recruiting');
            $table->string('studyQuestion', 50);
            $table->text('studyDescription');
            $table->text('copyPaste')->nullable();
            $table->string('studyLink');
            $table->integer('studyMinutes');
            $table->date('studyStart');
            $table->date('studyEnd');
            $table->integer('participants');
            $table->string('lookingFor');
            $table->string('studyPart');
            $table->text('notes')->nullable();
            $table->string('questions');
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
        Schema::dropIfExists('questions');
    }
}
