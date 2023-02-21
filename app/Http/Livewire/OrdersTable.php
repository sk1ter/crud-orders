<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Mediconesystems\LivewireDatatables\Action;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\LabelColumn;
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
                ->label(__('E-mail'))
                ->filterable()
                ->searchable(),
            Column::name('phone')
                ->label(__('Phone'))
                ->filterable()
                ->searchable(),
            Column::callback('id', function ($id) {
                $q = \DB::select('select sum((ohp.quantity * p.price) / 100) as sum from order_has_product ohp left join products p on p.id = ohp.product_id where order_id = '. $id .' order by order_id');
                return $q[0]->sum ?? 0;
            }),
            Column::name('address')
                ->label(__('Address'))
                ->filterable()
                ->searchable(),
            DateColumn::name('order_date')
                ->label(__('Order date'))
                ->filterable()
                ->searchable()
            ->width(300)
        ];
    }

    public function calculateAmount($products)
    {
    }
}
