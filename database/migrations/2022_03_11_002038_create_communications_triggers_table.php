<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationsTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communications_triggers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('communications_triggers')->insert(
            [
                [
                    'id'         => 1,
                    'name'       => 'REGISTRATION',
                    'slug'       => 'registration',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 2,
                    'name'       => 'CONFIRMATION',
                    'slug'       => 'confirmation',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 3,
                    'name'       => 'IS_INELIGIBLE',
                    'slug'       => 'is-ineligible',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 4,
                    'name'       => 'COMPLETION',
                    'slug'       => 'completion',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 5,
                    'name'       => 'NOT_REACHABLE',
                    'slug'       => 'not-reachable',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
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
        Schema::dropIfExists('communications_triggers');
    }
}
