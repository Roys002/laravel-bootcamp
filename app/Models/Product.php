<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    // Mass assignment protection
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'sku',
        'is_active'
    ];

    // Casting (seperti struct tags di Go)
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Accessor (auto transform saat read)
    public function getPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Mutator (auto transform saat write)
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    // Local scope (query helper)
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
