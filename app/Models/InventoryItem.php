<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock_quantity',
        'unit_price',
        'condition',
        'status',
        'minimum_stock'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2'
    ];

    // Relasi dengan pembelian
    public function purchases()
    {
        return $this->hasMany(InventoryPurchase::class);
    }

    // Relasi dengan penggunaan
    public function usages()
    {
        return $this->hasMany(InventoryUsage::class);
    }

    // Otomatis update status berdasarkan stok
    public function updateStatus()
    {
        $this->status = $this->stock_quantity > 0 ? 'Tersedia' : 'Tidak Tersedia';
        $this->save();
    }

    // Kurangi stok
    public function reduceStock($quantity)
    {
        $this->stock_quantity -= $quantity;
        $this->updateStatus();
    }

    // Tambah stok
    public function addStock($quantity)
    {
        $this->stock_quantity += $quantity;
        $this->updateStatus();
    }

    // Cek apakah stok hampir habis
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->minimum_stock;
    }
}