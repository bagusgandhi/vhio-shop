<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;


class Cartlist extends Component
{
    protected $listeners = ['cartUpdated' => 'refresh'];
    public $cartItems = [];
    public $orderData;
    public $payment = [
        [
            'name' => 'bca',
            'image' => 'https://sample-demo-dot-midtrans-support-tools.et.r.appspot.com/bca.png'
        ],
        [
            'name' => 'bri',
            'image' => 'https://sample-demo-dot-midtrans-support-tools.et.r.appspot.com/bri.png'
        ],
        [
            'name' => 'bni',
            'image' => 'https://sample-demo-dot-midtrans-support-tools.et.r.appspot.com/bni.png'
        ]
    ];
    public $selectedPayment;


    public function refresh()
    {
        $this->cartItems = \Cart::getContent();
    }

    public function removeCart($id)
    {
        \Cart::remove($id);
        $msg = 'Item has removed !';

        $this->dispatch('showToast', $msg, 'success');
        $this->dispatch('addToCart');
        
        $this->dispatch('cartUpdated');


    }

    public function submit()
    {
        // Get user id
        $user = auth()->user();
        $userId = $user->id;
    
        // Check if cart is not empty
        if (!!\Cart::getTotal()) {
            try {
                // Start a database transaction
                DB::beginTransaction();
    
                // Prepare order data
                $cartItems = \Cart::getContent();
                $cartTransformed = $cartItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'sub_total_price' => $item->price,
                        'total_price' => $item->price * $item->quantity
                    ];
                });

                $orderData = [
                    'user_id' => $userId,
                    'products' => array_values(json_decode($cartTransformed, true)),
                    'subtotal' => \Cart::getTotal(),
                    'bank' => $this->selectedPayment
                ];
    
                // Submit order
                $order = new OrderService($orderData);
                $orderResult = $order->create();
    
                // Prepare payment data
                $paymentData = [
                    'bank' => $orderData['bank'],
                    'invoice' => $orderResult['invoice'],
                    'total' => $orderData['subtotal']
                ];

                // Prepare midtrans config
                $midtransConfig = [
                    'midtransUrl' => config('services.midtrans.midtransUrl'),
                    'serverKey' => config('services.midtrans.serverKey')
                ];
    
                // Request payment
                $pay = new PaymentService($paymentData, $midtransConfig);
                $requestPay = $pay->requestPayment();

                // debug purpose
                // dd($requestPay);
                
                if (isset($requestPay['error'])) {
                    throw new Exception('Payment request failed: ' . $requestPay['error']);
                }
                
                $resultPay = [
                    'transaction_id' => $requestPay['transaction_id'],
                    'va_number' => $requestPay['va_numbers'][0]['va_number'],
                    'gross_amount' => $requestPay['gross_amount'],
                    'bank' => $requestPay['va_numbers'][0]['bank'],
                    'transaction_time' => $requestPay['transaction_time'],
                    'payment_type' => $requestPay['payment_type'],
                    'transaction_status' => $requestPay['transaction_status'],
                    'invoice' => $orderResult['invoice'],
                    'order_id' => $orderResult['id'],
                    'user_id' => $userId,
                    'expiry_time' => Carbon::parse($requestPay['expiry_time'])->setTimezone('Asia/Jakarta')
                ];

                // sebug purpose
                // dd($resultPay);

                $insertPayData = $pay->insertPayment($resultPay); 

                // Commit the transaction if successful
                DB::commit();
    
                // Remove cart
                \Cart::clear();
    
                return redirect()->to('/payments/' . $insertPayData);
            } catch (\Exception $e) {
                // Roll back the transaction on error
                DB::rollBack();
                dd($e);
    
                // Show error message
                $msg = 'An error occurred. Order process failed.';
                $this->dispatch('showToast', $msg, 'error');
            }
        } else {
            $msg = 'Empty Cart, Process Failed.';
            $this->dispatch('showToast', $msg, 'error');
        }
    }

    public function mount()
    {
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.cartlist', ['cartItems' => $this->cartItems]);
    }
}
