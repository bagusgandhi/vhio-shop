@extends('layouts.base-layout')

@section('title', 'All Your Order History')
@section('content')
    <div class="container mx-auto pb-16">
        @include('components.header')
        @if (session()->has('error'))
            @include('components.error-message', ['message' => session('error')])
        @else
            <h3 class="text-grey pb-4">Your Order History</h3>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200 table">
                    <thead>
                        <tr class="border-b-primary">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <p class="font-bold text-sm lg:hidden"> Order History List</p>
                            </th>
                            <th
                                class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <p class="font-bold text-sm">Invoice</p>
                            </th>
                            <th
                                class="hidden md:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <p class="font-bold text-sm">Total</p>
                            </th>
                            <th
                                class="hidden md:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <p class="font-bold text-sm">Payment Status</p>
                            </th>
                            <th
                                class="hidden md:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <p class="font-bold text-sm">Date</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($allOrder as $index => $item)
                            <tr>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap lg:w-1/12">
                                    <span class="p-2 hover:text-error cursor-pointer hidden lg:block">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                    <a href="{{ url('orders/' . $item['invoice']) }}"
                                        class="grid grid-cols-4  items-center">
                                        <span class="col-span-2 hover:text-primary">{{ $item['invoice'] }}</span>
                                    </a>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-center">
                                    <p>{{ \App\Helpers\CurrencyFormat::data($item['total']) }}</p>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-center">
                                    <span class="col-span-2 hover:text-primary">{{ $item['status_payment'] }}</span>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-center">
                                    <span class="col-span-2 hover:text-primary">{{ $item['created_at'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 pagination">
                    {{ $allOrder->links() }}
                </div>
            </div>
        @endif

    </div>
@endsection
