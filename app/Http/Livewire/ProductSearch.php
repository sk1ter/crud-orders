<?php

namespace App\Http\Livewire;


use App\Models\Product;
use Livewire\Component;

class ProductSearch extends Component
{
    public $search = '';
    public $searchResults = [];


    public function render()
    {
        if (strlen($this->search) >= 2) {
            $this->searchResults = Product::where('name', 'like', '%' . $this->search . '%')
                ->limit(10)->get()->map(fn(Product $product) => ['value' => $product->id, 'title' => $product->name, 'price' => $product->price]);
        }

        return view('livewire.select');
    }
}
