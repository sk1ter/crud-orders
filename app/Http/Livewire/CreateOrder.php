<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateOrder extends Component
{
    public $order;
    public $order_date;
    public $products;
    public $suggested_products;

    public $phone;
    public $email;
    public $address;
    public $address_latitude;
    public $address_longitude;

    public $term = null;

    protected $listeners = ['addProduct' => 'addProduct', 'quantityChange' => 'quantityChange'];

    protected $rules = [
        'order_date' => 'required|date:d.m.Y',
        'email' => 'required|email',
        'phone' => 'nullable|string|size:12',
        'address' => 'required|string',
        'products' => 'required|array',
        'address_latitude' => 'nullable|numeric',
        'address_longitude' => 'nullable|numeric',
    ];


    protected function prepareForValidation($attributes)
    {
        if (!empty($attributes['phone'])) {
            $phone = preg_replace('/\s+/', '', $attributes['phone']);
            $phone = preg_replace('/[^+0-9]/', '', $phone);
            $attributes['phone'] = $phone;
        }

        return $attributes;
    }


    public function render()
    {
        return view('livewire.create-order');
    }

    public function search()
    {
        if (mb_strlen($this->term) > 2) {
            $this->suggested_products = Product::where(DB::raw('lower(name)'), 'like', '%' . $this->term . '%')
                ->limit(10)->get()->toArray();
        }
    }

    public function clear()
    {
        $this->suggested_products = null;
        $this->term = null;
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if ($product !== null) {
            $this->products = array_merge(is_array($this->products) ? $this->products : [], [$product]);
        }
    }

    public function quantityChange($data)
    {
        $this->products = collect($this->products)->map(function ($product) use ($data) {
            if ($product['id'] === $data['id']) {
                $product = ['quantity' => $data['quantity'], ...$product];
            } else {
                $product['quantity'] = 0;
            }
            return $product;
        })->toArray();
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @param mixed $address_latitude
     */
    public function setAddressLatitude($address_latitude): void
    {
        $this->address_latitude = $address_latitude;
    }

    /**
     * @param mixed $address_longitude
     */
    public function setAddressLongitude($address_longitude): void
    {
        $this->address_longitude = $address_longitude;
    }

    public function saveOrder()
    {
        $this->validate();
        if ($this->order === null) {
            $order = new Order();
        } else {
            $order = clone $this->order;
        }

        $order->fill([
            'order_date' => $this->order_date,
            'phone' => $this->phone,
            'address' => $this->address,
            'address_longitude' => $this->address_longitude,
            'address_latitude' => $this->address_latitude,
            'email' => $this->email
        ]);
        $order->save();
        foreach ($this->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }
        $this->redirect(route('dashboard'));
    }

}
