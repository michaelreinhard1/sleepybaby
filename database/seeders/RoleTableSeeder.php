<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $writerRole = Role::create([
            'name'         => 'user'
        ]);

        $publisherRole = Role::create([
            'name'         => 'admin'
        ]);

    }
}
