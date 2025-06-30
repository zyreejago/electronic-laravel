<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'admin_id',
        'quantity',
        'unit_price',
        'total_price',
        'purchase_date',
        'notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}