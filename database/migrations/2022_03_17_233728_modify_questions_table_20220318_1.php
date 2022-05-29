<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyQuestionsTable202203181 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('studyQuestion', 'study_question');
            $table->renameColumn('studyDescription', 'study_description');
            $table->renameColumn('copyPaste', 'copy_paste');
            $table->renameColumn('studyLink', 'study_link');
            $table->renameColumn('studyMinutes', 'study_minutes');
            $table->renameColumn('studyStart', 'study_start');
            $table->renameColumn('studyEnd', 'study_end');
            $table->renameColumn('lookingFor', 'looking_for');
            $table->renameColumn('studyPart', 'study_part');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('study_question', 'studyQuestion');
            $table->renameColumn('study_description', 'studyDescription');
            $table->renameColumn('copy_paste', 'copyPaste');
            $table->renameColumn('study_link', 'studyLink');
            $table->renameColumn('study_minutes', 'studyMinutes');
            $table->renameColumn('study_start', 'studyStart');
            $table->renameColumn('study_end', 'studyEnd');
            $table->renameColumn('looking_for', 'lookingFor');
            $table->renameColumn('study_part', 'studyPart');
        });
    }
}
