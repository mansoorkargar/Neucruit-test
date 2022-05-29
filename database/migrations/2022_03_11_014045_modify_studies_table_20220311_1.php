<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStudiesTable202203111 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn(['uuid']);
            $table->unsignedBigInteger('gender_id')->nullable(true)->change();
            $table->unsignedBigInteger('study_type_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studies', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
            $table->unsignedBigInteger('gender_id')->nullable(false)->change();
            $table->unsignedBigInteger('study_type_id')->nullable(false)->change();
        });
    }
}
