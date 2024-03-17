<div>

    <div class="container mx-auto">
        <div class="px-8">

            @if (count($cartItems) === 0)
                <div class="text-center bg-grey-secondary-50 rounded-md p-10">
                    <h3 class="font-bold text-xl">Your Cart is Empty</h3>
                    <p>Your shopping cart is currently empty. It's time to start shopping!</p>
                    <a href="{{ url('products') }}" class="flex justify-center py-2">
                        <button class="btn btn-sm btn-primary rounded-lg font-bold text-white text-md ">Shop
                            Now!</button>
                    </a>
                </div>
            @else
                <h3 class="text-grey pb-4">Produk yang ada di keranjang belanja</h3>
                <div class="pb-16">
                    <table class="min-w-full divide-y divide-gray-200 table">
                        <thead>
                            <tr class="border-b-primary">
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm lg:hidden"> Cart List</p>
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm">Products</p>
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm">Price</p>
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm">QTY</p>
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <p class="font-bold text-sm">Total Price</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap lg:w-1/12">
                                        <span class="p-2 hover:text-error cursor-pointer hidden lg:block"
                                            wire:click="removeCart('{{ $item['id'] }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </span>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                        <div 
                                            class="grid grid-cols-4  items-center">
                                            <span>
                                                <img class="h-20" src="{{ url($item['attributes']->image) }}"
                                                    alt="{{ $item['name'] }}">
                                            </span>
                                            <span class="col-span-2">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-center">
                                        <p>{{ \App\Helpers\CurrencyFormat::data($item['price']) }}</p>
                                    </td>
                                    <td class="flex flex-row items-center relative md:table-cell lg:w-1/6">
                                        <span wire:click="removeCart('{{ $item['id'] }}')"
                                            class="bg-pink-primary p-1 lg:hidden absolute text-white top-4 right-0 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </span>
                                        <div class="w-1/3 lg:hidden">
                                            <img class="h-28 mx-auto" src="{{ url($item['attributes']->image) }}"
                                                alt="{{ $item['name'] }}">
                                        </div>
                                        <div class="w-2/3 lg:w-full">
                                            <h3 class="lg:hidden text-pink-primary font-bold">{{ $item['name'] }}</h3>
                                            <p class="lg:hidden">
                                                {{ \App\Helpers\CurrencyFormat::data($item['price']) }}</p>

                                            <livewire:cartupdate :item="$item" :key="$item['id']" />

                                            <p class="lg:hidden text-grey text-lg mt-4 font-bold">
                                                {{ \App\Helpers\CurrencyFormat::data($item['price'] * $item['quantity']) }}
                                            </p>
                                        </div>

                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-center">
                                        {{ \App\Helpers\CurrencyFormat::data($item['price'] * $item['quantity']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if (!!Cart::getTotal())
                        <div class="mt-6 p-4 flex lg:block items-center justify-between lg:w-1/3 ml-auto rounded">
                            <div class="flex flex-row items-center justify-between gap-4">
                                <p class="lg:text-xl">Total: </p>
                                <p class="lg:text-2xl text-xl font-bold pr-2">
                                    {{ \App\Helpers\CurrencyFormat::data(Cart::getTotal()) }}
                                </p>
                            </div>
                        </div>
                        <form action="" wire:submit.prevent="submit" method="POST">
                            <h3 class="font-semibold pb-4">Select Payment</h3>
                            <div class="flex flex-col gap-4">
                                @foreach ($payment as $item)
                                    <label wire:click="$dispatch('cartUpdated')"
                                        class="px-4 rounded-md border-2 border-primary label cursor-pointer flex flex-row gap-4">
                                        <span class="flex items-center gap-4">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 p-2">
                                        </span>
                                        <input type="radio" class="radio radio-primary" value="{{ $item['name'] }}"
                                            wire:model="selectedPayment" required />
                                    </label>
                                @endforeach
                            </div>
                            <div class="my-6">
                                <button type="submit" {{ is_null($selectedPayment) ? 'disabled' : '' }} type="submit" class="btn btn-md bg-gray-800 text-white rounded-lg w-full">Pay
                                    Now</button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

        </div>


    </div>
</div>
