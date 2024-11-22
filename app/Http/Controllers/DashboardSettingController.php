<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSettingController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        $provinces = Province::all();
        $regencies = Regency::all();

        return view('pages.dashboard-account',[
            'user' => $user,
            'provinces' => $provinces,
            'regencies' => $regencies
        ]);
    }

    public function update(Request $request, $redirect)
    {
        $data = $request->all();

        $item = Auth::user();

        $item->update($data);

        return redirect()->route($redirect);
    }
}
