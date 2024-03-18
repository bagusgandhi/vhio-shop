@extends('layouts.base-layout')

@section('title', 'Order Invoice')
@section('content')
    <div class="container mx-auto">
        @include('components.header')
        @if (session()->has('error'))
            @include('components.error-message', ['message' => session('error')])
        @else
            <div class="pb-16">
                <div class="flex flex-row items-center justify-between mx-auto p-6">
                    <div class="w-1/2">
                        <h3 class="font-bold text-2xl">Invoice</h3>
                        <p class="text-xl">#{{ $oneOrder['invoice'] }}</p>
                    </div>
                    <div class="rounded-lg">
                        <span class="rounded lg:text-center">
                            @if ($oneOrder['status_payment'] === 'paid')
                                <p class="p-4 text-success font-bold">{{ $oneOrder['status_order'] }} /
                                    {{ $oneOrder['status_payment'] }} </br>@ {{ $oneOrder['updated_at'] }}</p>
                            @else
                                <p class="p-4 text-error font-bold">{{ $oneOrder['status_order'] }} /
                                    {{ $oneOrder['status_payment'] }}</p>
                            @endif
                        </span>
                        @if ($oneOrder->payment->expiry_time > now() && $oneOrder->payment->transaction_status === 'pending')
                            <a href="{{ url('payments/' . $oneOrder->payment->transaction_id) }}"><button
                                    class="w-full btn btn-sm bg-gray-800 text-white">Pay Now</button></a>
                        @else
                            @if ($oneOrder->payment->transaction_status == 'settlement' || $oneOrder->payment->transaction_status == 'capture')
                                <p class="font-bold text-center">Payment success!.</p>
                            @else
                                <p class="font-bold">This payment has expired.</p>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="pb-8">

                    <table class="min-w-full divide-y divide-gray-200 table">
                        <thead>
                            <tr class="lg:bg-grey-secondary-50">
                                <th class="lg:hidden">
                                    <p class="font-bold text-sm">Order Deails</p>
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm">Order Deails</p>
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm text-center">QTY</p>
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm text-center">Subtotal</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($orderProducts as $order)
                                <tr>
                                    <td class="md:table-cell px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-row items-center gap-4">
                                            <div class="w-24 lg:w-14">
                                                <img class="h-24 lg:h-14 mx-auto" src="{{ url($order->product->image) }}"
                                                    alt="{{ $order->product->name }}">
                                            </div>
                                            <div class="lg:hidden">
                                                <p class="">{{ $order->product->name }}</p>
                                                <p class="text-grey-secondary">Items: {{ $order->qty }}</p>
                                                <p class="text-pink-primary">
                                                    {{ \App\Helpers\CurrencyFormat::data($order->total_price) }}
                                                </p>
                                            </div>
                                            <p class="hidden lg:block">{{ $order->product->name }}</p>

                                        </div>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <p class="text-center">{{ $order->qty }}</p>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <p class="text-center">{{ \App\Helpers\CurrencyFormat::data($order->total_price) }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="bg-primary text-white font-bold">
                                <td>
                                    <p class="hidden lg:block">Total</p>
                                </td>
                                <td class="hidden lg:table-cell"></td>
                                <td class="hidden lg:table-cell">
                                    <p class="text-center text-pink-primary">
                                        {{ \App\Helpers\CurrencyFormat::data($oneOrder->total) }}</p>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    @if ($oneOrder->status_payment === 'paid')
                        <div class="p-6 bg-success text-white">
                            <h4 class="font-bold px-2 text-green">Detail Payment</h4>
                            <table class="min-w-full divide-y divide-gray-200 table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="font-bold">{{ $oneOrder->payment->va_number }}</p>
                                            <p>at {{ $oneOrder->payment->updated_at }}</p>
                                        </td>
                                        <td>
                                            <p class="text-right font-bold">Bank
                                                {{ strtoupper($oneOrder->payment->bank) }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
