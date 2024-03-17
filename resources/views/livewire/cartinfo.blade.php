<div class="dropdown dropdown-hover dropdown-end z-20">
    <label tabindex="0" class="btn m-1 btn-ghost btn-circle lg:bg-grey-secondary-50 btn-outline">
        <div class="indicator">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span
                class="badge badge-sm indicator-item h-4 w-4 p-2 bg-primary text-white">{{ Cart::getTotalQuantity() }}
            </span>
        </div>
    </label>
    <div tabindex="0" class=" card card-compact dropdown-content w-52 bg-base-100 shadow">
        <div class="card-body">
            <span class="font-bold text-lg">{{ $totalItems }} items</span>
            <span class="text-slate-400">Subtotal: Rp{{ \App\Helpers\CurrencyFormat::data($subTotal) }}</span>
            <a href="{{ url('/cart') }}">
                <div class="card-actions">
                    <button class="btn btn-primary btn-block text-base-100">View cart</button>
                </div>
            </a>
        </div>
    </div>
</div>