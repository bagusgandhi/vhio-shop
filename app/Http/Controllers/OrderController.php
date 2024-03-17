<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        try {
            $orders = $this->order;
            $user = Auth::user();

            $allOrder = $orders->where([['user_id',$user->id]])->paginate(8);
            return view('pages.member.orders.index', compact('allOrder'));
        } catch(\Exception $e){
            return redirect('products')->with('error', 'An error occurred while fetching orders.');
        }
    }

    public function show($invoice)
    {
        try {            
            $orders = $this->order;
            $user = Auth::user();

            $oneOrder = $orders->where([['invoice',$invoice],['user_id',$user->id]])->with('payment')->firstOrFail();
            $orderProducts = OrderProduct::where('order_id', $oneOrder->id)->with('product')->get();

            return view('pages.member.orders.detail', compact('oneOrder','orderProducts'));
        } catch (ModelNotFoundException $e) {
            return redirect('orders')->with('error', 'Order not found.');
        } catch (\Exception $e) {
            return redirect('orders')->with('error', 'An error occurred while fetching the order details.');
        }
    }
}
