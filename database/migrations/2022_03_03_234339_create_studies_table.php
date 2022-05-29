<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name');
            $table->string('study_question')
                  ->nullable();
            $table->string('description')
                  ->nullable();
            $table->string('trial_id')
                  ->nullable();
            $table->foreignId('study_type_id')
                  ->constrained('studies_types')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('investigating_audience')
                  ->nullable();
            $table->string('study_run_time')
                  ->nullable();
            $table->boolean('is_offering_incentives')
                  ->default(0);
            $table->string('incentive_description')
                  ->nullable();
            $table->string('field')
                  ->nullable();
            $table->string('location')
                  ->nullable();
            $table->date('recruitment_starts_at')
                  ->nullable();
            $table->date('recruitment_ends_at')
                  ->nullable();
            $table->unsignedInteger('participant_min_age')
                  ->nullable();
            $table->unsignedInteger('participant_max_age')
                  ->nullable();
            $table->foreignId('gender_id')
                  ->constrained('genders')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('condition')
                  ->nullable();
            $table->string('criteria')
                  ->nullable();
            $table->string('approval_number')
                  ->nullable();
            $table->boolean('consent')
                  ->default(0);
            $table->string('study_status_id')
                  ->nullable();
            $table->string('designated_contact')
                  ->nullable();
            $table->unsignedInteger('required_participants')
                  ->nullable();
            $table->string('link_suffix');

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('studies');
    }
}
