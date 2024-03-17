<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'status_order','status_payment', 'sub_total', 'user_id',
        'invoice', 'total'
    ];

    // one order owned by one payment
    public function payment(){
        return $this->hasOne(Payment::class,'order_id');
    }

    // one order owned by one user
    public function user(){
         return $this->belongsTo(User::class, 'user_id');
    }

    // one order has many order product
    public function orderproduct(){
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
}
