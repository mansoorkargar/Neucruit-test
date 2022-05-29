<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvocatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advocates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('study');
            $table->string('specialty');
            $table->string('status');
            $table->string('role');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email');
            $table->string('gender');
            $table->string('total_experience');
            $table->string('board_certification');
            $table->string('board');
            $table->string('handle');
            $table->string('reach');
            $table->string('image_reference');
            $table->string('notes');
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
        Schema::dropIfExists('advocates');
    }
}
