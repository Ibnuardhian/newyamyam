<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'code',
        'discount_type',
        'description',
        'discount_value',
        'start_date',
        'end_date',
        'minimum_purchase',
        'usage_limit',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}