<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStudiesQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studies_questions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('study_id')->nullable();
            $table->foreign('study_id')->on('studies')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('position')->default(0);
            
            $table->enum('type', [
                'TEXT',
                'TEXT_MULTIPLE_ROWS',
                'NUMBER',
                'DROPDOWN',
                'CHECKBOX',
                'RADIOBUTTON',
                'DATE',
                'BIRTHDATE',
                'GENDER',
                'ETHNICITY',
                'ADDRESS',
                'EMAIL',
                'SEPARATOR',
            ]);
            
            $table->string('name');
            $table->text('options')->nullable(true);

            $table->boolean('is_required')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studies_questions');
    }
}
