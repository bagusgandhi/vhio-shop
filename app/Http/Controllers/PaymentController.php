<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PaymentController extends Controller
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function show($transaction_id)
    {
        try {            
            $payments = $this->payment;
            $user = Auth::user();
            $currentTime = Carbon::now();

            $onePayment = $payments->where([
                ['transaction_id', $transaction_id],
                ['user_id',$user->id]
            ])->firstOrFail();
            
            if ($currentTime < $onePayment->expiry_time && $onePayment->transaction_status == 'pending') {
                return view('pages.member.payment', compact('onePayment'));
            } 

            return redirect()->route('showOrder', ['invoice' => $onePayment->invoice]);
            
        } catch (ModelNotFoundException $e) {
            return redirect('cart')->with('error', 'Payment not found.');
        } catch (\Exception $e) {
            dd($e);
            return redirect('cart')->with('error', 'An error occurred while fetching the payment details.');
        }
    }

    public function callback(Request $request)
    {
        try {
            $payments = $this->payment;

            $serverKey = config('services.midtrans.serverKey');
            $invoice = $request->order_id;
            $transaction_status = $request->transaction_status;
            $transaction_time = $request->transaction_time;
            $status_code = $request->status_code;
            $gross_amount = $request->gross_amount;
            $va_number = $request->va_numbers[0]['va_number'];

    
            $hashed = hash("sha512", $invoice.$status_code.$gross_amount.$serverKey);
            
            if($hashed == $request->signature_key){
                switch ($transaction_status) {
                    // midtrans pending
                    case 'pending':
                        $order = Order::where('invoice', $invoice)->get();
                        $order[0]->update([
                            'status_order' => 'order',
                            'status_payment' => 'pending'
                        ]);
                        if ($va_number) {
                            $payment = Payment::where('invoice', $invoice)->get();
                            $payment[0]->update([
                                'transaction_time' => $transaction_time,
                                'transaction_status' => $transaction_status, 
                            ]);
                            return response()->json(['message' => 'Payment Status Pending']);
                        }
                        break;
                    
                    case 'capture':
                        $order = Order::where('invoice', $invoice)->get();
                        $order[0]->update([
                            'status_order' => 'process',
                            'status_payment' => 'paid',
                        ]);
                        if ($va_number) {
                            $payment = Payment::where('invoice', $invoice)->get();
                            $payment[0]->update([
                                'transaction_time' => $transaction_time,
                                'transaction_status' => $transaction_status, 
                            ]);
                            return response()->json(['message' => 'Payment Status Captured']);
                        }

                        session()->push('callback-midtrans', ['message' => 'Payment success!']);

                        break; 

                    case 'settlement':
                        $order = Order::where('invoice', $invoice)->get();
                        $order[0]->update([
                            'status_order' => 'process',
                            'status_payment' => 'paid',
                        ]);
                        if ($va_number) {
                            $payment = Payment::where('invoice', $invoice)->get();
                            $payment[0]->update([
                                'transaction_time' => $transaction_time,
                                'transaction_status' => $transaction_status, 
                            ]);
                            return response()->json(['message' => 'Payment Status Success']);
                        }

                        session()->push('callback-midtrans', ['message' => 'Payment success!']);

                        break;

                    case 'expire':
                        $order = Order::where('invoice', $invoice)->get();
                        $order[0]->update([
                            'status_order' => 'failed',
                            'status_payment' => 'unpaid',
                        ]);
                        if ($va_number) {
                            $payment = Payment::where('invoice', $invoice)->get();
                            $payment[0]->update([
                                'transaction_time' => $transaction_time,
                                'transaction_status' => $transaction_status, 
                            ]);
                            return response()->json(['message' => 'Payment Status Failed']);
                        } 
                        break;
                    case 'failure':
                        $order = Order::where('invoice', $invoice)->get();
                        $order[0]->update([
                            'status_order' => 'failed',
                            'status_payment' => 'unpaid',
                        ]);
                        if ($va_number) {
                            $payment = Payment::where('invoice', $invoice)->get();
                            $payment[0]->update([
                                'transaction_time' => $transaction_time,
                                'transaction_status' => $transaction_status, 
                            ]);
                        return response()->json(['message' => 'Payment Status Failed']); 
                        }   
                        break;
                    default:
                        Order::where('invoice', $invoice)->update([
                            'status' => 'failed',
                        ]);
                        return response()->json(['message' => 'Payment Status Failed']); 
                        break;
                }
                
            }
        } catch(\Throwable $th){
            return $th;
        }
    }
    
}
