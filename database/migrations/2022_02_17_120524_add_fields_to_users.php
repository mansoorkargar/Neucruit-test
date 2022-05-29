<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('name');
            $table->integer('phone_number')->after('last_name');
            $table->string('company')->after('phone_number');
            $table->boolean('info_checked')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('info_checked');
            $table->dropColumn('last_name');
            $table->dropColumn('phone_number');
            $table->dropColumn('company');
        });
    }
}
