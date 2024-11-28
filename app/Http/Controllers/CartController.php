<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Models\Cart;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $provinces = Province::all();
        $regencies = Regency::where('province_id', (int) $user->provinces_id)->get();
        $carts = Cart::with(['product.galleries', 'user'])->where('users_id', $user->id)->get();
        return view('pages.cart', [
            'carts' => $carts,
            'provinces' => $provinces,
            'regencies' => $regencies,
            'user' => $user
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $cart->qty = $request->qty;
        $cart->save();

        return redirect()->route('cart');
    }

    public function success()
    {
        return view('pages.success');
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'qty' => 'required|integer|min:1'
            ]);

            $product = Product::find($request->product_id);
            $totalWeight = $product->weight * $request->qty;

            $cart = Cart::where('users_id', Auth::id())
                        ->where('products_id', $request->product_id)
                        ->first();

            if ($cart) {
                $cart->qty += $request->qty;
                $cart->total_weight += $totalWeight;
                $cart->save();
            } else {
                Cart::create([
                    'users_id' => Auth::id(),
                    'products_id' => $request->product_id,
                    'qty' => $request->qty,
                    'total_weight' => $totalWeight
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to add to cart'], 500);
        }
    }
}

