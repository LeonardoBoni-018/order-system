<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    /**
     * Cria um pedido com itens
     */
    public function create(int $userId, array $items): Order
    {
        return DB::transaction(function () use ($userId, $items) {
            $order = Order::create([
                "user_id" => $userId,
                "status" => "pending",
                "total" => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->find($item["product_id"]);

                if (!$product) {
                    throw ValidationException::withMessages([
                        "product_id" => "Produto não encontrado",
                    ]);
                }

                if ($product->stock < $item["quantity"]) {
                    throw ValidationException::withMessages([
                        "stock" => "Estoque insuficiente para {$product->name}",
                    ]);
                }

                $subtotal = $product->price * $item["quantity"];

                OrderItem::create([
                    "order_id" => $order->id,
                    "product_id" => $product->id,
                    "quantity" => $item["quantity"],
                    "price" => $product->price,
                ]);

                // Atualiza estoque
                $product->decrement("stock", $item["quantity"]);

                $total += $subtotal;
            }

            $order->update([
                "total" => $total,
            ]);

            return $order->load("items.product");
        });
    }
}
