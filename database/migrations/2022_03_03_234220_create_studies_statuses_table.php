<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiesStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studies_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('studies_statuses')->insert(
            [
                [
                    'id'         => 1,
                    'name'       => 'CREATED',
                    'slug'       => 'created',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 2,
                    'name'       => 'IN_PROGRESS',
                    'slug'       => 'in-progress',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 3,
                    'name'       => 'SUBMITTED',
                    'slug'       => 'submitted',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 4,
                    'name'       => 'MISSING_INFORMATION',
                    'slug'       => 'missing_information',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 5,
                    'name'       => 'COMPLETED',
                    'slug'       => 'completed',
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
        Schema::dropIfExists('studies_statuses');
    }
}
