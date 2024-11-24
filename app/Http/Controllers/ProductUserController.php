<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductUserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $selectedCategory = $request->input('category');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->when($selectedCategory != 'Semua Kategori', function ($query) use ($selectedCategory) {
                return $query->whereHas('category', function ($q) use ($selectedCategory) {
                    $q->where('name', $selectedCategory);
                });
            })
            ->paginate(12);

        $categories = Category::all();

        return view('pages.category', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}