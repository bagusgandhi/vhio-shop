<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'orders_products';
    protected $fillable = [
        'order_id', 'product_id',
        'price','qty','sub_total_price','total_price',
    ];
    protected $with = ['product'];

    // many order_product product belongs to one order
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    // one order product has many products
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
