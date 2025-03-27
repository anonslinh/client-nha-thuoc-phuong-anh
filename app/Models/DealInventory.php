<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'sku',
        'name',
        'image',
        'description',
        'original_price',
        'deal_price',
        'quantity',
        'display_order',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function inventories()
    {
        return $this->hasMany(DealInventory::class, 'product_id');
    }

    public function purchases()
    {
        return $this->hasMany(DealPurchase::class);
    }
}
