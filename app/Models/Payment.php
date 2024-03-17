<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $fillable = [
        'gross_amount','va_number', 'bank','payment_type', 'transaction_time','transaction_status', 'transaction_id','order_id','user_id','invoice','expiry_time'   
    ];


    // one payment has one order
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    // one order owned by one user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
