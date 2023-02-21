<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    )
    {
    }

    public function create()
    {
        return view('order.store');
    }

    public function update(Order $id)
    {
        return view('order.update', ['order' => $id]);
    }
}
