<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Illuminate\Support\Facades\DB;
class RegencyRajaOngkirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
     * 
     * @return void
     */

public function run()
{
    // Truncate the table
    DB::table('regencies_rajaongkir')->truncate();
    // Get Data
    $regencies = RawDataGetter::getRegenciesRajaOngkir();
    // Remove province_id column
    $regencies = array_map(function($regency) {
        unset($regency['province_id']);
        return $regency;
    }, $regencies);
    // Insert Data to Database
    DB::table('regencies_rajaongkir')->insert($regencies);
}
}