<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public static function calculateDiscount($discount, $totalPrice, $price, $shippingCost)
    {
        if ($discount->discount_type == 'percentage') {
            return $totalPrice * ($discount->discount_value / 100);
        } elseif ($discount->discount_type == 'fixed') {
            return $discount->discount_value;
        } elseif ($discount->discount_type == 'percentageproduct') {
            return $price * ($discount->discount_value / 100);
        } elseif ($discount->discount_type == 'ongkir') {
            return $shippingCost * $discount->discount_value;
        }
        return 0;
    }
}
