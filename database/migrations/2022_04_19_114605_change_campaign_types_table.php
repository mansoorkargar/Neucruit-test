<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeCampaignTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('campaign_types')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Direct to Individual',
                ],
                [
                    'id' => 2,
                    'name' => 'Via Clinician',
                ],
                [
                    'id' => 3,
                    'name' => 'Via non-clinical organisation',
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
        Schema::dropIfExists('campaign_types');
    }
}
