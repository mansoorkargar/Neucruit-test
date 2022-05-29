<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateParticipantsStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('participants_statuses')->insert(
            [
                [
                    'id'         => 1,
                    'name'       => 'BOOKED',
                    'slug'       => 'booked',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id'         => 2,
                    'name'       => 'SENT',
                    'slug'       => 'sent',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id'         => 3,
                    'name'       => 'IN_PROGRESS',
                    'slug'       => 'in_progress',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id'         => 4,
                    'name'       => 'COMPLETE',
                    'slug'       => 'complete',
                    'created_at' => now(),
                    'updated_at' => now(),
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
        Schema::dropIfExists('participants_statuses');
    }
}
