<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([
        //     RoleSeeder::class,
         //      etc..
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AgentImmonilierSeeder::class);
        $this->call(LocataireSeeder::class);

    }
}
