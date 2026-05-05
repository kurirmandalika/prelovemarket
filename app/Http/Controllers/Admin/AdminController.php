<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::query()->count(),
            'productsCount' => Product::query()->count(),
            'availableProductsCount' => Product::query()->where('status', 'available')->count(),
            'ordersCount' => Order::query()->count(),
            'latestOrders' => Order::query()->with(['buyer', 'seller', 'product'])->latest()->take(6)->get(),
        ]);
    }
}
