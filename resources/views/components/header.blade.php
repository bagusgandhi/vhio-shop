<div>
    <div class="flex items-center justify-between py-4 mb-16">
        <div class="flex gap-10 items-center">
            <a href="{{ url('/products') }}">
                <h1 class="text-2xl font-bold text-center text-purple-900">Vhio Shop</h1>
            </a>
            <a href="{{ url('/orders') }}">
                <h1 class="text-center text-purple-900 hover:text-black">History Order</h1>
            </a>
        </div>
        <div class="flex gap-4 items-center">
            <livewire:cartinfo />
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white btn-sm btn btn-error">Logout</button>
            </form>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="relative">
            <div class="absolute w-full top-0 ">
                <livewire:notif />
            </div>
        </div>
    </div>
</div>
