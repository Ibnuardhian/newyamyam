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
        $sort = $request->input('sort');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->when($selectedCategory != 'Semua Kategori', function ($query) use ($selectedCategory) {
                return $query->whereHas('category', function ($q) use ($selectedCategory) {
                    $q->where('name', $selectedCategory);
                });
            })
            ->when($sort, function ($query) use ($sort) {
                if ($sort == 'low_to_high') {
                    return $query->orderBy('price', 'asc');
                } elseif ($sort == 'high_to_low') {
                    return $query->orderBy('price', 'desc');
                }
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