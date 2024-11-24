<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSettingController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        $provinces = Province::orderBy('name', 'ASC')->get();
        $regencies = collect();
        $districts = collect();

        if ($user->provinces_id) {
            $regencies = Regency::where('province_id', $user->provinces_id)->orderBy('name', 'ASC')->get();
        }

        if ($user->regency_id) {
            $districts = District::where('regency_id', $user->regency_id)->orderBy('name', 'ASC')->get();
        }

        return view('pages.dashboard-account', [
            'user' => $user,
            'provinces' => $provinces,
            'regencies' => $regencies,
            'districts' => $districts,
            'zip_code' => $user->zip_code,
            'phone_number' => $user->phone_number,
        ]);
    }

    public function update(Request $request, $redirect)
    {
        $data = $request->all();

        $request->validate([
            'provinces_id' => 'required|exists:provinces,id',
            'regencies_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'zip_code' => 'required|string|max:10',
            'phone_number' => 'required|string|max:15',
        ]);

        $item = Auth::user();

        $item->update($data);

        return redirect()->route($redirect);
    }
}
