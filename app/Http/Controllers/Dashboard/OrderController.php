<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->purchases()
            ->with(['seller.sellerProfile', 'product'])
            ->latest()
            ->paginate(10);

        return view('dashboard.orders.index', [
            'orders' => $orders,
            'shippingStatuses' => Order::SHIPPING_STATUSES,
        ]);
    }

    public function store(StoreOrderRequest $request, Product $product): RedirectResponse
    {
        $order = DB::transaction(function () use ($request, $product) {
            $order = Order::create([
                'order_number' => 'PM-'.now()->format('Ymd').'-'.strtoupper(Str::random(6)),
                'buyer_id' => $request->user()->id,
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'product_title' => $product->title,
                'product_image' => $product->image,
                'total_price' => $product->price,
                'shipping_address' => $request->validated('shipping_address'),
                'expedition' => $request->validated('expedition'),
                'shipping_status' => 'pending',
                'payment_status' => 'paid',
                'status' => 'pending',
                'notes' => $request->validated('notes'),
            ]);

            $product->update(['status' => 'sold']);

            return $order;
        });

        return redirect()
            ->route('dashboard.orders.index')
            ->with('success', 'Pesanan '.$order->order_number.' berhasil dibuat.');
    }

    public function sales(Request $request): View
    {
        $orders = $request->user()
            ->sales()
            ->with(['buyer', 'product'])
            ->latest()
            ->paginate(10);

        return view('dashboard.orders.sales', [
            'orders' => $orders,
            'shippingStatuses' => Order::SHIPPING_STATUSES,
        ]);
    }

    public function updateShippingStatus(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->seller_id === $request->user()->id, 403);

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

        return back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}
