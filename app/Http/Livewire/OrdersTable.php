<?php

namespace App\Http\Livewire;

use App\Models\Order;
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
                ->linkTo('job', 6),
        ];
    }
}
