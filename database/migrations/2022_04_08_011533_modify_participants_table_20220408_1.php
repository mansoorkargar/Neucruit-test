<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyParticipantsTable202204081 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->string('name')->nullable(true)->after('reference_number');
            $table->string('email')->nullable(true)->after('name');
            $table->string('phone_number')->nullable(true)->after('email');
            $table->string('site')->nullable(true)->after('phone_number');
            $table->string('site_distance')->nullable(true)->after('site');
            $table->boolean('opt_in')->nullable(true)->after('site_distance');
            $table->datetime('contact_date')->nullable(true)->after('opt_in');
            $table->datetime('confirmation_date')->nullable(true)->after('contact_date');
            $table->datetime('symptoms_date')->nullable(true)->after('confirmation_date');
            $table->datetime('suspect_date')->nullable(true)->after('symptoms_date');
            $table->boolean('form_sent')->nullable(true)->after('suspect_date');
            $table->string('screening_data')->nullable(true)->after('form_sent');
            $table->string('country')->nullable(true)->after('screening_data');
            $table->string('city')->nullable(true)->after('country');
            $table->string('postcode')->nullable(true)->after('city');
            $table->string('address_line_1')->nullable(true)->after('postcode');
            $table->string('address_line_2')->nullable(true)->after('address_line_1');
            $table->datetime('birthdate')->nullable(true)->after('address_line_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->string('name')->nullable(true)->after('reference_number');
            $table->dropColumn(['email']);
            $table->dropColumn(['phone_number']);
            $table->dropColumn(['site']);
            $table->dropColumn(['site_distance']);
            $table->dropColumn(['opt_in']);
            $table->dropColumn(['contact_date']);
            $table->dropColumn(['confirmation_date']);
            $table->dropColumn(['symptoms_date']);
            $table->dropColumn(['suspect_date']);
            $table->dropColumn(['form_sent']);
            $table->dropColumn(['screening_data']);
            $table->dropColumn(['country']);
            $table->dropColumn(['city']);
            $table->dropColumn(['postcode']);
            $table->dropColumn(['address_line_1']);
            $table->dropColumn(['address_line_2']);
            $table->dropColumn(['birthdate']);
    }
}
