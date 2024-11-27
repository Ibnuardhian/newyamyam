<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries'])->where('slug', $id)->firstOrFail();

        return view('pages.detail', [
            'product' => $product
        ]);
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $userId = Auth::user()->id;
        $qty = $request->input('qty', 1);

        $cartItem = Cart::where('products_id', $id)->where('users_id', $userId)->first();

        if ($cartItem) {
            // Update existing cart item
            $cartItem->qty += $qty;
            $cartItem->total_weight = $cartItem->qty * $product->weight;
            $cartItem->save();
        } else {
            // Create new cart item
            $data = [
                'products_id' => $id,
                'users_id' => $userId,
                'qty' => $qty,
                'total_weight' => $product->weight * $qty
            ];

            Cart::create($data);
        }

        return redirect()->route('cart');
    }
}