<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name', 'image', 'description','price', 'slug','status','deleted_at'
    ];


    // one order has many order product
    public function orderproduct(){
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
}
