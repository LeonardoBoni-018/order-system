<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["name", "price", "stock"];

    // Um produto pode aparecer em vários itens de pedido
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
