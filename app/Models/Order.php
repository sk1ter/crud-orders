<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'order_date',
        'address',
        'email',
        'address_latitude',
        'address_longitude',
    ];

    protected $casts = [
        'order_date' => 'date'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_has_product')->withPivot(['quantity']);
    }
}
