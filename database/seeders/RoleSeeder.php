<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Enums\RoleEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (RoleEnum::keyValueArray() as $id => $name) {
            $role = Role::firstOrNew(['id' => $id]);
            $role->name = $name;
            $role->slug = Str::slug($name, '-');
            $role->save();
        }
    }
}
