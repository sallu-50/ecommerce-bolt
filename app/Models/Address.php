<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'is_default_shipping',
        'is_default_billing',
    ];

    protected $casts = [
        'is_default_shipping' => 'boolean',
        'is_default_billing' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address_line_1;
        
        if ($this->address_line_2) {
            $address .= ", {$this->address_line_2}";
        }
        
        $address .= ", {$this->city}, {$this->state} {$this->postal_code}, {$this->country}";
        
        return $address;
    }

    public function getSummaryAttribute()
    {
        return "{$this->full_name}, {$this->city}, {$this->country}";
    }

    public function scopeDefaultShipping($query)
    {
        return $query->where('is_default_shipping', true);
    }

    public function scopeDefaultBilling($query)
    {
        return $query->where('is_default_billing', true);
    }
}