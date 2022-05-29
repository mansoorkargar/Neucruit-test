<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupQuestionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_up_question_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('sign_up_question_types')->insert([
            [
                'id'         => 1,
                'name'       => 'TEXT',
                'slug'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id'         => 2,
                'name'       => 'TEXT_MULTIPLE_ROWS',
                'slug'       => 'text-multiple-rows',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id'         => 3,
                'name'       => 'NUMBER',
                'slug'       => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id'         => 4,
                'name'       => 'DROPDOWN',
                'slug'       => 'dropdown',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id'         => 5,
                'name'       => 'CHECKBOX',
                'slug'       => 'checkbox',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id'         => 6,
                'name'       => 'RADIOBUTTON',
                'slug'       => 'radiobutton',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sign_up_question_types');
    }
}
