<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, OrderService $orderService)
    {
        $data = $request->validate([
            "items" => ["required", "array", "min:1"],
            "items.*.product_id" => [
                "required",
                "integer",
                "exists:products,id",
            ],
            "items.*.quantity" => ["required", "integer", "min:1"],
        ]);

        $order = $orderService->create($request->user()->id, $data["items"]);

        return response()->json($order, 201);
    }
}
