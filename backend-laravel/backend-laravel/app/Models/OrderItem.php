<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ["order_id", "product_id", "quantity", "price"];

    // Item pertence a um pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item pertence a um produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
