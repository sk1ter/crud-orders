<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderService
{
    public function create(OrderRequest $request): void
    {
        try {
            \DB::beginTransaction();
            $order = Order::create($request->only([
                'phone',
                'email',
                'address',
                'address_latitude',
                'address_longitude',
                'order_date'
            ]));
            foreach ($request->input('products') as $product) {
                $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            }
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }
}
