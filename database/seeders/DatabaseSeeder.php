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
        $this->call(BienSeeder::class);
        $this->call(LocataireBienSeeder::class);
        $this->call(ContratsDeBailSeeder::class);
        $this->call(LocataireSeeder::class);
        $this->call(PaiementSeeder::class);
        $this->call(ArticleContratBailSeeder::class);

    }
}
