<?php

namespace Database\Seeders;

use App\Models\Design;
use Illuminate\Database\Seeder;

class DesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Design::query()->create([
            'study_id'   => null,
            'assets'     => file_get_contents(resource_path('/temp/assets.txt')),
            'components' => file_get_contents(resource_path('/temp/components.txt')),
            'css'        => file_get_contents(resource_path('/temp/css.txt')),
            'html'       => file_get_contents(resource_path('/temp/html.txt')),
            'styles'     => file_get_contents(resource_path('/temp/styles.txt')),
        ]);
    }
}
