<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with(['buyer', 'seller.sellerProfile', 'product'])
            ->latest()
            ->paginate(12);

        return view('admin.orders.index', [
            'orders' => $orders,
            'shippingStatuses' => Order::SHIPPING_STATUSES,
        ]);
    }

    public function updateShippingStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'shipping_status' => ['required', Rule::in(array_keys(Order::SHIPPING_STATUSES))],
        ]);

        $order->update([
            'shipping_status' => $data['shipping_status'],
            'status' => match ($data['shipping_status']) {
                'delivered' => 'completed',
                'cancelled' => 'cancelled',
                'pending' => 'pending',
                default => 'processing',
            },
        ]);

        return back()->with('success', 'Status pengiriman pesanan berhasil diperbarui.');
    }
}
