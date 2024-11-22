<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Models\Cart;
use App\Models\Province;
use App\Models\Regency;
use App\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller

{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $provinces = Province::all();
        $regencies = Regency::all();
        $carts = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();
        return view('pages.cart', [
            'carts' => $carts,
            'provinces' => $provinces,
            'regencies' => $regencies
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function success()
    {
        return view('pages.success');
    }

}

