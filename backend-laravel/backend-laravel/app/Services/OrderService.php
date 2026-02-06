<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\PaymentService;

class OrderService
{
    /**
     * Cria um pedido com itens
     */
    public function create(int $userId, array $items): Order
    {
        return DB::transaction(function () use ($userId, $items) {

            $order = Order::create([
                'user_id' => $userId,
                'status'  => 'pending',
                'total'   => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Estoque insuficiente');
                }

                $subtotal = $product->price * $item['quantity'];

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);

                $product->decrement('stock', $item['quantity']);

                $total += $subtotal;
            }

            $order->update(['total' => $total]);

            $paymentService = app(PaymentService::class);

            $paid = $paymentService->pay($order->id, $total);

            if (!$paid) {
                throw new \Exception('Pagamento recusado');
            }

            $order->update(['status' => 'paid']);

            return $order->load('items.product');
        });
    }
}
