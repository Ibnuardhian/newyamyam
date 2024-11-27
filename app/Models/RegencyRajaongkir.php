<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegencyRajaongkir extends Model
{
    use HasFactory;

    protected $table = 'regencies_rajaongkir';

    protected $fillable = [
        'id', 'name' // Remove 'province_id' here
    ];

    public $timestamps = false;
}