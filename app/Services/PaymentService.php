<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class PaymentService
{
    protected $paymentData;
    protected $midtransConfig;

    public function __construct($data, $midtransConfig)
    {
        $this->paymentData = $data;
        $this->midtransConfig = $midtransConfig;
    }

    public function requestPayment()
    {
        try {
            $response = Http::withHeaders($this->buildHeaders())
                ->post($this->midtransConfig['midtransUrl'], $this->buildRequestBody());

            $responseData = $response->json();

            return $responseData;
        } catch (Exception $e) {
            throw new Exception("Error creating order: " . $e->getMessage());

        }
    }

    public function insertPayment($data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $payment = Payment::create($data);

                return $payment->transaction_id;
            });
        } catch (Exception $e) {
            throw new Exception("Error creating payment: " . $e->getMessage());
        }
    }

    protected function buildHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->midtransConfig['serverKey'] . ':'),
            'Content-Type' => 'application/json',
        ];
    }

    protected function buildRequestBody()
    {
        $user = Auth::user();
        return [
            'payment_type' => 'bank_transfer',
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'transaction_details' => [
                'order_id' => $this->paymentData['invoice'],
                'gross_amount' => $this->paymentData['total'],
            ],
            'bank_transfer' => [
                'bank' => $this->paymentData['bank'],
            ],
            'custom_expiry' => [ 
                'expiry_duration' => 10,
                'unit' => 'minute'
            ]
        ];
    }
}
