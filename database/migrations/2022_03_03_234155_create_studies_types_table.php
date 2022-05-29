<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studies_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('studies_types')->insert(
            [
                [
                    'id'         => 1,
                    'name'       => 'PSYSICAL',
                    'slug'       => 'psycical',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'id'         => 2,
                    'name'       => 'DIGITAL',
                    'slug'       => 'digital',
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
        Schema::dropIfExists('studies_types');
    }
}
