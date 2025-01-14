<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Models\Cart;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $provinces = Province::all();
        $regencies = Regency::where('province_id', (int) $user->provinces_id)->get();
        $carts = Cart::with(['product.galleries', 'user'])->where('users_id', $user->id)->get();

        // Calculate total price and discount
        $totalPrice = 0;
        $discountPrice = 0;
        $discountCode = $request->input('discount_code');
        $discount = null;
        $shippingCost = 0; // Add logic to calculate shipping cost if needed

        if ($discountCode) {
            $discount = Discount::where('code', $discountCode)->where('is_active', true)->first();
        }

        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->qty;
        }

        if ($discount) {
            $discountPrice = DiscountController::calculateDiscount($discount, $totalPrice, $totalPrice, $shippingCost);
        }

        return view('pages.cart', [
            'carts' => $carts,
            'provinces' => $provinces,
            'regencies' => $regencies,
            'user' => $user,
            'totalPrice' => $totalPrice,
            'discountPrice' => $discountPrice,
            'discountCode' => $discountCode,
        ]);
    }

    public function applyDiscount(Request $request)
    {
        $discountCode = $request->input('discount_code');
        return redirect()->route('cart', ['discount_code' => $discountCode]);
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

