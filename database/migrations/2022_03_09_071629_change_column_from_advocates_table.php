<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnFromAdvocatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advocates', function (Blueprint $table) {
            $table->dropColumn('study');
            $table->string('specialty')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('role')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('contact_number')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('total_experience')->nullable()->change();
            $table->string('board_certification')->nullable()->change();
            $table->string('board')->nullable()->change();
            $table->string('handle')->nullable()->change();
            $table->string('reach')->nullable()->change();
            $table->string('image_reference')->nullable()->change();
            $table->string('notes')->nullable()->change();
            $table->unsignedBigInteger('study_id')->after('specialty');
            $table->foreign('study_id')->references('id')->on('studies');
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
            $table->string('study');
            $table->dropColumn('specialty');
            $table->dropColumn('status');
            $table->dropColumn('role');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('contact_number');
            $table->dropColumn('gender');
            $table->dropColumn('total_experience');
            $table->dropColumn('board_certification');
            $table->dropColumn('board');
            $table->dropColumn('handle');
            $table->dropColumn('reach');
            $table->dropColumn('image_reference');
            $table->dropColumn('notes');
            $table->dropForeign('advocates_study_id_foreign');
            $table->dropColumn('study_id');
        });
    }
}
