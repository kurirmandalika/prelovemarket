<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'productsCount' => $user->products()->count(),
            'availableProductsCount' => $user->products()->where('status', 'available')->count(),
            'soldProductsCount' => $user->products()->where('status', 'sold')->count(),
            'purchaseCount' => $user->purchases()->count(),
            'salesCount' => $user->sales()->count(),
            'latestPurchases' => $user->purchases()->with(['seller', 'product'])->latest()->take(4)->get(),
            'latestSales' => $user->sales()->with(['buyer', 'product'])->latest()->take(4)->get(),
        ]);
    }
}
