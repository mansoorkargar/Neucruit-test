<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateParticipantsEmailTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_email_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('participants_email_types')->insert(
            [
                [
                    'id'         => 1,
                    'name'       => 'REGISTRATION',
                ],
                [
                    'id'         => 2,
                    'name'       => 'COMPLETING',
                ],
                [
                    'id'         => 3,
                    'name'       => 'IN_ELIGIBLE',
                ],
                [
                    'id'         => 4,
                    'name'       => 'NOT_REACHABLE',
                ],
                [
                    'id'         => 5,
                    'name'       => 'CONFIRMATION',
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants_email_types');
    }
}
