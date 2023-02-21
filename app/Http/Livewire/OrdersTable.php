<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Mediconesystems\LivewireDatatables\Action;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class OrdersTable extends LivewireDatatable
{
    public $model = Order::class;


    public function builder()
    {
        return Order::query();
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label(__('ID'))
                ->linkTo('orders/update'),
            Column::name('email')
                ->label(__('E-mail')),
            Column::name('phone')
                ->label(__('Phone')),
            Column::name('address')
                ->label(__('Address')),
            Column::name('order_date')
                ->label(__('Order date'))
        ];
    }
}
