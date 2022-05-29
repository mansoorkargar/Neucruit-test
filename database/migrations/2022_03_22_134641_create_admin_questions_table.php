<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_up_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->unsignedBigInteger('type_id')->nullable(true);
            $table->foreign('type_id')->references('id')->on('sign_up_question_types');
            $table->text('options')->nullable();
            $table->boolean('is_required')->default(0);
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
        Schema::dropIfExists('sign_up_questions');
    }
}
