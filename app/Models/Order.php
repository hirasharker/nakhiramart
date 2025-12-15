<?php

namespace App\Models;

use OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'shipped_date',
        'billing_address',
        'shipping_address',
        'total_amount',
        'order_status_id',
        'payment_method',
        'is_paid'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'shipped_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'is_paid' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    // Accessors
    public function getOrderNumberAttribute()
    {
        return 'ORD-' . str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('name', 'Pending');
        });
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    // Methods
    public static function createFromCart(Cart $cart, array $data)
    {
        $order = self::create([
            'user_id' => $cart->user_id ?? auth()->id(),
            'order_date' => now(),
            'billing_address' => $data['billing_address'],
            'shipping_address' => $data['shipping_address'],
            'total_amount' => $cart->subtotal,
            'order_status_id' => 1,
            'payment_method' => $data['payment_method'] ?? null,
            'is_paid' => false
        ]);

        foreach ($cart->items as $item) {
            $order->lines()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'line_total' => $item->total
            ]);
        }

        $cart->clear();

        return $order;
    }
}