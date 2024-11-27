<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegenciesCombinedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO regencies_combined (regencies_id, regency_rajaongkir_id, regency_name, rajaongkir_regency_name)
            SELECT
                r.id AS regencies_id,
                rr.id AS regency_rajaongkir_id,
                r.name AS regency_name, 
                rr.name AS rajaongkir_regency_name
            FROM 
                regencies r
            JOIN 
                regencies_rajaongkir rr ON TRIM(r.name) = TRIM(rr.name)
        ");
    }
}