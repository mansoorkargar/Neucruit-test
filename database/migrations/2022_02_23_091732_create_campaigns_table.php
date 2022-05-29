<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_type_id')->nullable();
            $table->string('name');
            $table->smallInteger('status')->default(0);
            $table->text('description')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->bigInteger('created_by')->index()->nullable();
            $table->bigInteger('updated_by')->index()->nullable();
            $table->timestamps();

            $table->foreign('campaign_type_id')->references('id')->on('campaign_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
