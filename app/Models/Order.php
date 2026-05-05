<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    public const EXPEDITIONS = [
        'jne' => 'JNE',
        'jnt' => 'J&T Express',
        'sicepat' => 'SiCepat',
        'anteraja' => 'AnterAja',
        'pos' => 'POS Indonesia',
    ];

    public const SHIPPING_STATUSES = [
        'pending' => 'Menunggu Diproses',
        'packed' => 'Dikemas',
        'shipped' => 'Dikirim',
        'delivered' => 'Diterima',
        'cancelled' => 'Dibatalkan',
    ];

    public const ORDER_STATUSES = [
        'pending' => 'Menunggu',
        'processing' => 'Diproses',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    protected $fillable = [
        'order_number',
        'buyer_id',
        'seller_id',
        'product_id',
        'product_title',
        'product_image',
        'total_price',
        'shipping_address',
        'expedition',
        'shipping_status',
        'payment_status',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function expeditionLabel(): string
    {
        return self::EXPEDITIONS[$this->expedition] ?? strtoupper($this->expedition);
    }

    public function shippingStatusLabel(): string
    {
        return self::SHIPPING_STATUSES[$this->shipping_status] ?? ucfirst($this->shipping_status);
    }

    public function statusLabel(): string
    {
        return self::ORDER_STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function formattedTotal(): string
    {
        return 'Rp '.number_format((float) $this->total_price, 0, ',', '.');
    }
}
