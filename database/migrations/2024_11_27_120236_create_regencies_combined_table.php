<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class CreateRegenciesCombinedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regencies_combined', function (Blueprint $table) {
            $table->string('regencies_id', 255);
            $table->string('regency_rajaongkir_id', 255);
            $table->string('regency_name', 255)->nullable();
            $table->string('rajaongkir_regency_name', 255)->nullable();
            $table->foreign('regencies_id')->references('id')->on('regencies');
            $table->foreign('regency_rajaongkir_id')->references('id')->on('regencies_rajaongkir');
        });

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

        Artisan::call('db:seed', [
            '--class' => 'RegenciesCombinedTableSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regencies_combined');
    }
}