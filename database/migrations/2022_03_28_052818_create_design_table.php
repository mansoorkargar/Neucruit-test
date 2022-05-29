<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_id')->nullable(true);
            $table->foreign('study_id')->on('studies')->references('id')->onDelete('cascade');

            $table->text('assets')->nullable(true);
            $table->text('components')->nullable(true);
            $table->text('css')->nullable(true);
            $table->text('html')->nullable(true);
            $table->text('styles')->nullable(true);

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
        Schema::dropIfExists('designs');
    }
}
