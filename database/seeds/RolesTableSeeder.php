<?php

use EQM\Models\Roles\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        Role::create(['name' => 'member']);
        Role::create(['name' => 'administrator']);
    }
}
