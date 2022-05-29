<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStudiesQuestionsTable202205181 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies_questions', function (Blueprint $table) {
            $table->text('ineligible_options')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studies_questions', function (Blueprint $table) {
            $table->text('ineligible_options')->nullable(false)->change();
        });
    }
}
