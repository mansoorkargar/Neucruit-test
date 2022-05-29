<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('type');
            $table->string('slug')->index()->unique();

            $table->unsignedBigInteger('study_id');
            $table->foreign('study_id')->on('studies')->references('id')->on('studies')->onDelete('cascade');

            $table->date('starts_at')
                  ->nullable();

            $table->date('ends_at')
                  ->nullable();

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
        Schema::dropIfExists('channels');
    }
}
