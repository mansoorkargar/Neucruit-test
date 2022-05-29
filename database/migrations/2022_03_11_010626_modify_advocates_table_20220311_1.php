<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAdvocatesTable202203111 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advocates', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->unsignedBigInteger('gender_id')->nullable(true)->after('specialty');
            $table->foreign('gender_id')->references('id')->on('genders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advocates', function (Blueprint $table) {
            $table->string('gender');
            $table->dropForeign(['gender_id']);
            $table->dropColumn('gender_id');
        });
    }
}
