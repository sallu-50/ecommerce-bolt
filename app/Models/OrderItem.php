<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'product_name',
        'product_options',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'product_options' => 'json',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFormattedSubtotalAttribute()
    {
        return '$' . number_format($this->subtotal, 2);
    }
}