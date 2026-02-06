<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Exception;

class PaymentService
{
    public function pay(int $orderId, float $amount): bool
    {
        /** @var Response $response */
        $response = Http::timeout(5)->post(
            config('services.payment.url') . '/pay',
            [
                'order_id' => $orderId,
                'amount'   => $amount,
            ]
        );

        if (!$response->successful()) {
            throw new Exception('Erro no serviço de pagamento');
        }

        return $response->json()['status'] === 'approved';
    }
}
