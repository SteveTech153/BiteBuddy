<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run():void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'hotel_owner']);
        Role::create(['name' => 'delivery_partner']);
        Role::create(['name' => 'customer']);
    }
}
