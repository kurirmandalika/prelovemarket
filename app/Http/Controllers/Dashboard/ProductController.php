<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = $request->user()
            ->products()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('dashboard.products.index', compact('products'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->user()->sellerProfile()->exists()) {
            return redirect()
                ->route('dashboard.seller-profile.edit')
                ->with('error', 'Lengkapi profil penjual sebelum menambahkan produk.');
        }

        return view('dashboard.products.create', [
            'categories' => Category::query()->orderBy('name')->get(),
            'conditions' => Product::CONDITIONS,
            'statuses' => Product::STATUSES,
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['status'] = 'available';
        $data['image'] = $request->file('image')->store('products', 'public');

        Product::create($data);

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        Gate::authorize('update', $product);

        return view('dashboard.products.edit', [
            'product' => $product,
            'categories' => Category::query()->orderBy('name')->get(),
            'conditions' => Product::CONDITIONS,
            'statuses' => Product::STATUSES,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image']);

        if ($product->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $product->id);
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        Gate::authorize('delete', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (Product::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
