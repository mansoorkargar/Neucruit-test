<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCommunicationsTable202203111 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communications', function (Blueprint $table) {
            $table->unsignedBigInteger('study_id')->nullable(true)->after('id');
            $table->foreign('study_id')->references('id')->on('studies');

            $table->string('design_structure')
                  ->nullable();

            $table->string('file')
                  ->nullable(true)
                  ->change();

            $table->boolean('opt_in')
                  ->default(0)
                  ->nullable();

            $table->boolean('enabled')
                  ->default(1)
                  ->change();

            $table->unsignedBigInteger('communication_trigger_id')->nullable(true)->after('opt_in');
            $table->foreign('communication_trigger_id')->references('id')->on('communications_triggers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communications', function (Blueprint $table) {
            $table->dropForeign(['study_id']);
            $table->dropColumn('study_id');

            $table->dropColumn('design_structure');
            $table->dropColumn('opt_in');

            $table->string('file')
                  ->nullable(false)
                  ->change();

            $table->boolean('enabled')
                  ->default(1)
                  ->change();

            $table->dropForeign(['communication_trigger_id']);
            $table->dropColumn('communication_trigger_id');
        });
    }
}
