<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
        'price',
        'options',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'options' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function scopeGetCartByIdentifier($query, $userId = null, $sessionId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        } elseif ($sessionId) {
            return $query->where('session_id', $sessionId);
        }

        return $query->whereRaw('1 = 0'); // Return an empty query
    }

    public static function addItem($productId, $quantity = 1, $userId = null, $sessionId = null, $options = null)
    {
        $product = Product::findOrFail($productId);
        
        if ($userId) {
            $item = self::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();
        } elseif ($sessionId) {
            $item = self::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->first();
        } else {
            return false;
        }

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $item = self::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->current_price,
                'options' => $options,
            ]);
        }

        return $item;
    }

    public static function removeItem($itemId, $userId = null, $sessionId = null)
    {
        $query = self::where('id', $itemId);
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        return $query->delete();
    }

    public static function updateQuantity($itemId, $quantity, $userId = null, $sessionId = null)
    {
        $query = self::where('id', $itemId);
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        $item = $query->first();
        
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
            return $item;
        }

        return false;
    }

    public static function getCartTotal($userId = null, $sessionId = null)
    {
        $query = self::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        return $query->get()->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public static function getCartCount($userId = null, $sessionId = null)
    {
        $query = self::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        return $query->sum('quantity');
    }

    public static function clearCart($userId = null, $sessionId = null)
    {
        $query = self::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        return $query->delete();
    }

    public static function mergeGuestCart($sessionId, $userId)
    {
        $guestCart = self::where('session_id', $sessionId)->get();
        
        foreach ($guestCart as $item) {
            $userItem = self::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->first();
            
            if ($userItem) {
                $userItem->quantity += $item->quantity;
                $userItem->save();
                $item->delete();
            } else {
                $item->user_id = $userId;
                $item->session_id = null;
                $item->save();
            }
        }
    }
}