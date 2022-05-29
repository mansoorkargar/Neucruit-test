<?php

namespace Database\Seeders;

use App\Models\CampaignType;
use Illuminate\Database\Seeder;

class CampaignTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'MIXED'],
            ['name' => 'ADVOCATES'],
            ['name' => 'THREADS'],
        ];

        CampaignType::insert($data);
    }
}
