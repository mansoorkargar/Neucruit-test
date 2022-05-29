<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('genders')->insert(
            [
                [
                    'id'         => 1,
                    'name'       => 'FEMALE',
                    'slug'       => 'female',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 2,
                    'name'       => 'MALE',
                    'slug'       => 'male',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 3,
                    'name'       => 'OTHER',
                    'slug'       => 'other',
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
        Schema::dropIfExists('genders');
    }
}
