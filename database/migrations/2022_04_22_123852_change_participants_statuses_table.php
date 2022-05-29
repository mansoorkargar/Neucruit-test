<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeParticipantsStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('participants_statuses')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('participants_statuses')->insert([
            [
                'id'         => 1,
                'name'       => 'REGISTERED',
                'slug'       => 'Registered',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'name'       => 'INELIGIBLE',
                'slug'       => 'Ineligible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'name'       => 'CONFIRMED',
                'slug'       => 'Confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 4,
                'name'       => 'COMPLETED',
                'slug'       => 'Completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 5,
                'name'       => 'NOT_REACHABLE',
                'slug'       => 'Not Reachable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
