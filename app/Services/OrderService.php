<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderData;

    public function __construct($data)
    {
        $this->orderData = $data;
    }

    protected function generateInvoice()
    {
        $date = Carbon::now();
        $start_rand = rand(10000, 99999);
        $end_rand = rand(10000, 99999);
        $result = $date->format('Ymd');
        $invoice = $start_rand . $result . $end_rand;

        return $invoice;
    }

    protected function insertOrder($orderData, $invoice)
    {
        try {
            return DB::transaction(function () use ($orderData, $invoice) {
                $subtotal = $orderData['subtotal'];
                $userId = $orderData['user_id'];

                $order = Order::create([
                    'status_order' => 'order',
                    'status_payment' => 'unpaid',
                    'sub_total' => $subtotal,
                    'total' => $subtotal,
                    'invoice' => $invoice,
                    'user_id' => $userId,
                ]);

                return $order;
            });
        } catch (Exception $e) {
            throw new Exception("Error creating order: " . $e->getMessage());
        }
    }

    protected function insertOrderProduct($orderData, $orderId)
    {
        try {
            $products = collect($orderData['products']);

            return DB::transaction(function () use ($products, $orderId) {
                $products->each(function ($item) use ($orderId) {
                    OrderProduct::create([
                        "order_id" => $orderId,
                        "product_id" => $item['id'],
                        "qty" => $item['quantity'],
                        "price" => $item['price'],
                        "sub_total_price" => $item['sub_total_price'],
                        "total_price" => $item['total_price']
                    ]);
                });
            });
        } catch (Exception $e) {
            throw new Exception("Error creating order products: " . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $orderData = $this->orderData;
            $invoice = $this->generateInvoice();
            $order = $this->insertOrder($orderData, $invoice);            
            $this->insertOrderProduct($orderData, $order['id']);

            return $order;
        } catch (Exception $e) {
            throw new Exception("Error creating order: " . $e->getMessage());
        }
    }
}
