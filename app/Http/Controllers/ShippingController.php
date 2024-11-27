<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShippingController extends Controller
{
    public function calculate(Request $request)
    {
        try {
            $userRegencyId = DB::table('users')
                ->where('id', $request->user()->id)
                ->value('regencies_id');
            $regencyRajaOngkirId = DB::table('regencies_combined')
                ->where('regencies_id', $userRegencyId)
                ->value('regency_rajaongkir_id');
            $courier = 'jne';

            $requestData = [
                'origin' => $request->origin,
                'destination' => $regencyRajaOngkirId,
                'weight' => $request->weight,
                'courier' => $courier
            ];

            Log::info('Raja Ongkir Request:', $requestData);

            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->post(config('services.rajaongkir.base_url') . 'cost', $requestData);

            Log::info('Raja Ongkir Response:', $response->json());

            $results = $response->json()['rajaongkir']['results'][0]['costs'];
            $shippingCost = 50000; // Default shipping cost

            foreach ($results as $result) {
                if ($result['service'] === 'REG') {
                    $shippingCost = $result['cost'][0]['value'];
                    break;
                }
            }

            $totalPrice = $request->total_price;
            $totalCost = $totalPrice + $shippingCost;

            return response()->json(['cost' => $shippingCost, 'total' => $totalCost]);
        } catch (\Exception $e) {
            Log::error('Error calculating shipping cost:', ['exception' => $e]);
            return response()->json(['cost' => 50000, 'total' => $request->total_price + 50000]);
        }
    }
}