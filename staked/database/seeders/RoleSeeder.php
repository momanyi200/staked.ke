<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
        // database/seeders/RoleSeeder.php

    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'bettor']); // regular user
    }

} 