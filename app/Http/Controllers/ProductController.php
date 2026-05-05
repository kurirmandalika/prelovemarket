<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function home(): View
    {
        $products = Product::query()
            ->with(['category', 'user.sellerProfile'])
            ->where('status', 'available')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::query()
            ->withCount(['products' => fn ($query) => $query->where('status', 'available')])
            ->orderBy('name')
            ->get();

        return view('home', compact('products', 'categories'));
    }

    public function index(Request $request): View
    {
        $selectedCondition = $request->string('condition')->toString();

        $products = Product::query()
            ->with(['category', 'user.sellerProfile'])
            ->where('status', 'available')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->string('search')->toString().'%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('category')->toString()));
            })
            ->when(array_key_exists($selectedCondition, Product::CONDITIONS), function ($query) use ($selectedCondition) {
                $query->where('condition', $selectedCondition);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'conditions' => Product::CONDITIONS,
        ]);
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'user.sellerProfile']);

        $relatedProducts = Product::query()
            ->with(['category', 'user.sellerProfile'])
            ->where('status', 'available')
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category(Category $category): View
    {
        $products = $category->products()
            ->with(['category', 'user.sellerProfile'])
            ->where('status', 'available')
            ->latest()
            ->paginate(12);

        return view('products.category', compact('category', 'products'));
    }
}
