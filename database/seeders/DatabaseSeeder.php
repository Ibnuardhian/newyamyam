<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\IndoRegionProvinceSeeder;
use Database\Seeders\IndoRegionRegencySeeder;
use Database\Seeders\IndoRegionDistrictSeeder;
use Database\Seeders\IndoRegionVillageSeeder;
use Database\Seeders\RegencyRajaOngkirSeeder;
use Database\Seeders\RegenciesCombinedTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        if (!User::where('email', 'ibnu@gmail.com')->exists()) {
            User::create([
                'name' => 'ibnu',
                'email'=> 'ibnu@gmail.com',
                'password' => bcrypt('password'),
                'roles' => 'ADMIN',
            ]);
        }

        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
            'name' => 'user',
            'email'=> 'user@example.com',
            'password' => bcrypt('password'),
            'roles' => 'USER',
            ]);
        }
        $this->call(IndoRegionProvinceSeeder::class);
        $this->call(IndoRegionRegencySeeder::class);
        $this->call(IndoRegionDistrictSeeder::class);
        $this->call(IndoRegionVillageSeeder::class);
        $this->call(RegencyRajaOngkirSeeder::class);
        $this->call(RegenciesCombinedTableSeeder::class);
    }
}
