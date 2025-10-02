<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'payment_status',
        'payment_method',
        'payment_id',
        'total_price',
        'shipping_address_id',
        'billing_address_id',
        'shipping_method',
        'shipping_cost',
        'notes',
        'tracking_number',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_price, 2);
    }

    public function getFormattedShippingCostAttribute()
    {
        return '$' . number_format($this->shipping_cost, 2);
    }

    public function getSubtotalAttribute()
    {
        return $this->total_price - $this->shipping_cost;
    }

    public function getFormattedSubtotalAttribute()
    {
        return '$' . number_format($this->subtotal, 2);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }
}